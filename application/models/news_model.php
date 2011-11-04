<?php
/**
 * Модель для хранения новостей
 */

class News_model extends CI_Model {
	var $message = '';
	
	/** 
	 * Добавить новость
	 * 
	 * @param News $news
	 */
	function add($news) 
	{
		if(!isset($news->name_ru) OR $news->name_ru === FALSE OR $news->name_ru == '') 
		{
			return FALSE;
		}
		$news->time = date('Y-m-d G:i:s');
		$news->update = $news->time;
		if( !isset($news->url) || $news->url == '' )
		{ 
			$news->url = str_to_url($news->name_ru);
		}
		else
		{
			$news->url = str_to_url($news->url);
		}
		
		
		// На случай совпадения URL-адреса
		$check_url = $news->url;
		$i = 1;
		while( $this->get_by_url_for_admin( $check_url ) )
		{
			$check_url = $news->url.$i;
			$i++;
		}
		$news->url = $check_url;
		
		$this->db->insert(TABLE_NEWS, $news);
		return $this->db->insert_id();
	}
	
	
	/**
	 * Получить основную информацию о новостях
	 * 
	 * Получить основную информацию о новостях (потребляет меньше ресурсов, чем простая функция {@link get()})
	 * @param int $page - номер страницы
	 * @param int $amount_on_page - количество новостей на одной странице (20 по умолчанию)
	 * @return array(int[0..n] => News)|FALSE
	 */
	function get_short($page = 1, $amount_on_page = 20)
	{
		return $this->db
			->select('id, name_'.lang().' as name, url, notice_'.lang().' as notice')
			->where('name_'.lang().' IS NOT NULL AND name_'.lang().'!=""')
			->order_by('time')
			->get(TABLE_NEWS, $amount_on_page, ($page-1)*$amount_on_page)
			->result();
	}
	
	
	/**
	 * Получить новость по её идентификатору
	 * @param int $id - уникальный идентификатор новости
	 */
	function get_by_id_for_admin($id)
	{
		$news = $this->db->get_where(TABLE_NEWS, array('id' => $id), 1)->result();
		if(!$news)
		{
			return FALSE;
		}
		return $news[0];
	}
	
	/**
	 * Получить всю информацию о новости по её уникальном url-адресу (на всех языках)
	 * @param string $url - уникальный url-адрес новости
	 * @return News - объект с информацией о новости | FALSE
	 */
	function get_by_url($url)
	{
		$news = $this->db
			->select('id, time, name_'.lang().' as name, url, notice_'.lang().' as notice, text_'.lang().' as text' )
			->get_where(TABLE_NEWS, array('url' => $url), 1)->result();

		if( $news && ( ! isset($news[0]->name) || $news[0]->name == '' ) )
		{
			$news = $this->db
			->select('id, time, name_ru as name, url, notice_ru as notice, text_ru as text' )
			->get_where(TABLE_NEWS, array('url' => $url), 1)->result();
		}
		
		if( ! $news )
		{
			return FALSE;
		}
		
		return $news[0];
	}
	
	/**
	 * Получить информацию о новости по её уникальном url-адресу (только на текущем языке)
	 * @param string $url - уникальный url-адрес новости
	 * @return News_local - объект с информацией о новости на одном языке | FALSE
	 */
	function get_by_url_for_admin($url)
	{
		$news = $this->db->get_where(TABLE_NEWS, array('url' => $url), 1)->result();
		if(!$news)
		{
			return FALSE;
		}
		return $news[0];
	}
	
	
	/**
	 * Удалить новость из БД
	 * @param int $news_id - уникальный идентификатор новости
	*/
	function delete( $news_id )
	{
		if( ! $this->db->delete(TABLE_NEWS, array('id' => $news_id)))
		{
			$this->message = 'Произошла ошибка, новость удалить не удалось.';
			return FALSE;
		} 
		else 
		{
			$this->message = 'Новость удалена успешно (id был равен '.$news_id.').';
		}
		return TRUE;
	}
	
	
	/**
	 * Получить информацию о статье из данных, полученных методом POST
	 * return News - объект, содержащий собранную информацию о новости
	*/
	function get_from_post()
	{
		$news->name_ru = $this->input->post('news_name_ru');	// название новости
		$news->text_ru = $this->input->post('news_text_ru');	// содержимое новости
		$news->notice_ru = $this->input->post('news_notice_ru');// анонс новости
		if( $this->input->post('is_news_en') )
		{
			$news->name_en = $this->input->post('news_name_en');
			$news->text_en = $this->input->post('news_text_en');
			$news->notice_en = $this->input->post('news_notice_en');
		}
		else
		{
			$news->name_en = '';
			$news->text_en = '';
			$news->notice_en = '';
		}
		
		if( $this->input->post('news_url_not_change') )
		{
			$news->url = URL_NOT_CHANGE;
		}
		else if( $this->input->post('news_url') != '' )
		{
			$news->url = $this->input->post('news_url');
		}
		
		if( $this->input->post('news_id') != '' )
		{
			$news->id = $this->input->post('news_id');
		}
		return $news;
	}
	
	/**
	 * Добавить новую новость в базу данных, взяв за основу информацию, полученную методом POST
	 * @return int - идентификатор добавленной новости | FALSE
	 */
	function add_from_post()
	{
		return $this->add( $this->get_from_post() );
	}
	
	/**
	 * Отредактировать информацию о новости, взяв за основу информацию отправленную методом POST
	 */
	function edit_from_post()
	{
		return $this->update( $this->get_from_post() );
	}
	
	/**
	 * Обновить информацию о новости
	 * @param [in] News $news - объект новости. Должны быть заполнены лишь те поля, которые подлежат обновлению. Но поле id должно быть заполнено обязательно.
	 */
	function update($news)
	{
		if( !isset($news->id) )
		{
			return FALSE;
		}
		
		if( isset($news->url) && $news->url == URL_NOT_CHANGE )
		{
			unset($news->url);
		}
		else if( (!isset($news->url) OR $news->url == "") && isset($news->name_ru))
		{
			$news->url = str_to_url($news->name_ru);
		}
		
		$this->db->where('id', $news->id);
		return $this->db->update(TABLE_NEWS, $news);
	}
}

/* End of file news_model.php */
/* Location: ./application/models/news_model.php */