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
		$id = $this->db->insert_id();
		mkdir('uploads/news/'.$id, 0777);	// Создаём папку для файлов к новости
		return $id;
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
		// Проверка прав (сделать бы почеловечнее...)
		$ci = get_instance();
		$usergroup = $ci->user_model->logged_max_group();
		if( !$usergroup )
		{
			$this->db->where('category = 1');
		}
		else if($usergroup == 2)
		{
			$this->db->where('category <= 2');
		}
		
		return $this->db
			->select('id, name_'.lang().' as name, category + 0 as category, url, notice_'.lang().' as notice, time, DATE_FORMAT(`time`, \'%d.%m.%Y\') as `date`, DATE_FORMAT(`time`, \'%d.%m.%Y, %H:%i\') as `format_time`', FALSE)
			->where('name_'.lang().' IS NOT NULL AND name_'.lang().'!=""')
			->order_by('time DESC')
			->get(TABLE_NEWS, $amount_on_page, ($page-1)*$amount_on_page)
			->result();
	}
	
	
	/**
	 * Получить новость по её идентификатору для "админки"
	 * @param int $id - уникальный идентификатор новости
	 */
	function get_by_id_for_admin($id)
	{
		$news = $this->db->select('id, url, name_ru, name_en, notice_ru, notice_en, text_ru, text_en, category + 0 as category, time, update, is_photo_show')->get_where(TABLE_NEWS, array('id' => $id), 1)->result();
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
			->select('id, time, is_photo_show, category + 0 as category, name_'.lang().' as name, url, notice_'.lang().' as notice, text_'.lang().' as text, DATE_FORMAT(`time`, \'%d.%m.%Y, %H:%i\') as `format_time`', FALSE )
			->get_where(TABLE_NEWS, array('url' => $url), 1)->result();

		if( $news && ( ! isset($news[0]->name) || $news[0]->name == '' ) )
		{
			$news = $this->db
			->select('id, time, is_photo_show, category + 0 as category, is_photo_show, name_ru as name, url, notice_ru as notice, DATE_FORMAT(`time`, \'%d.%m.%Y, %H:%i\') as `format_time`, text_ru as text' )
			->get_where(TABLE_NEWS, array('url' => $url), 1)->result();
		}

		if( ! $news )
		{
			return FALSE;
		}
		
		// Проверка прав (сделать бы почеловечнее её...)
		$ci = get_instance();
		$usergroup = $ci->user_model->logged_max_group();
		if( !$usergroup && $news[0]->category != 1 || $usergroup == 2 && $news[0]->category > 2 )
		{
			// Нет доступа к этой новости (делаем заглушку)
			$not_news->name = 'Нет доступа';
			$not_news->url = $url;
			$not_news->notice = 'Нет доступа к новости';
			$not_news->text = 'Нет доступа к новости';
			$not_news->time = 0;
			$not_news->format_time = NULL;
			return $not_news;
		}
		
		$news[0]->photos = FALSE;
		if( $news[0]->is_photo_show )
		{
			$news[0]->photos = $this->get_photos($news[0]->id); // Список изображений, прикреплённых к новости
		}
		$news[0]->files = $this->get_files($news[0]->id);	// Список файлов, прикреплённых к новости
		
		return $news[0];
	}
	
	/** 
	 * Получить массив с именами изображений, прикреплённых к новости
	 * @param [in] int - идентификатор новости
	 * @return array[int => string]
	 */
	protected function get_photos($id_news)
	{
		return $this->db->select('filename')->get_where(TABLE_FILES_ELFINDER, array('mime' => 'image', 'obj_type' => OBJ_TYPE_NEWS, 'obj_id' => $id_news))->result();
	}
	
	/** 
	 * Получить массив с именами файлов, прикреплённых к новости
	 * @param [in] int - идентификатор новости
	 * @return array[int => string]
	 */
	protected function get_files($id_news)
	{
		return $this->db->select('filename, size')->get_where(TABLE_FILES_ELFINDER, array('mime !=' => 'image', 'obj_type' => OBJ_TYPE_NEWS, 'obj_id' => $id_news))->result();
	}
	
	/**
	 * Получить информацию о новости по её уникальном url-адресу (на всех языках)
	 * @param string $url - уникальный url-адрес новости
	 * @return News_local - объект с информацией о новости на одном языке | FALSE
	 */
	function get_by_url_for_admin($url)
	{
		$news = $this->db->select('id, url, is_photo_show, name_ru, name_en, notice_ru, notice_en, text_ru, text_en, category + 0 as category, time, update')->get_where(TABLE_NEWS, array('url' => $url), 1)->result();
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
		// Удаляем все файлы, связанные с новостью
		$this->load->helper('directory');
		remove_dir('uploads/news/'.$news_id.'/');
		
		if( ! $this->db->delete(TABLE_NEWS, array('id' => $news_id)))
		{
			$this->message = 'Произошла ошибка, новость удалить не удалось.';
			return FALSE;
		} 
		else 
		{
			// Удалим все файлы, привязанные к новости
			$this->db->where(array('obj_type' => OBJ_TYPE_NEWS, 'obj_id' => $news_id))->delete(TABLE_FILES_ELFINDER);
			
			$this->message = 'Новость удалена успешно (id был равен '.$news_id.').';
		}
		return TRUE;
	}
	
	
	/**
	 * Получить информацию о новости из данных, полученных методом POST
	 * return News - объект, содержащий собранную информацию о новости
	*/
	function get_from_post()
	{
		$news->name_ru = $this->input->post('news_name_ru');	// название новости
		$news->text_ru = $this->input->post('news_text_ru');	// содержимое новости
		$news->category = $this->input->post('news_category');	// категория новости
		$news->notice_ru = $this->input->post('news_notice_ru');// анонс новости
		$this->input->post('news_is_photo_show')? $news->is_photo_show=1 : $news->is_photo_show = 0; // вывести ли фотографии после новости
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
	
	/**
	 * Получить данные о последних 10 новостях для
	 * RSS-ленты
	 * 
	 * @access public
	 * @return array записи БД
	 */
	public function get_for_rss()
	{
		return $this->db->select('url, name_ru, notice_ru, time')->get_where(TABLE_NEWS, array('category' => 'Все'))->result();
	}
}

/* End of file news_model.php */
/* Location: ./application/models/news_model.php */