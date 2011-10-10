<?php
/**
 * @class - контроллер административной панели (админки)
 */
class Admin extends CI_Controller {	
	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(TRUE);	// Отладка (содержимое после основного контента)
		$this->load->database('default');
		$this->load->model('user_model');
		$this->user_model->check_admin();		// Проверка прав (является ли пользователь администратором)
	}
	
	/** Главная страница админки */
	function index()
	{
		$data = NULL;
		$this->load->view('templates/admin_view', $data);
	}

	
	/**
	 * Работа с новостями
	 * @param segment3 - 'add' | 'edit' | 'delete'
	 * @param segment4 - 'action'
	 * @param segment5 - 'news_edit_success' | 'news_add_success'
	*/
	function news()
	{
		$data = NULL;
		$this->load->model(MODEL_NEWS);
	
		// по адресу "/admin/news": список всех новостей
		if( $this->uri->segment(3) == '' ) 
		{
			$data['news'] = $this->news_model->get_short();
			$data['content'] = $this->load->view('/admin/news_view', $data, TRUE);
			$data['title'] = 'Новости';
			$this->load->view('/templates/admin_view', $data);
		}
	
		// по адресу "/admin/news/add": страница добавления новой новости
		else if( $this->uri->segment(3) == 'add' )
		{
			if($this->uri->segment(4) == 'action') // по адресу "admin/articles/add/action"
			{
				$news_id = $this->news_model->add_from_post();
				redirect('/admin/news/edit/'.$this->news_model->get_by_id_for_admin($news_id)->url.'/news_add_success');
			}
			//$data['news'] = $this->news_model->get_short();
			$data['content'] = $this->load->view('/admin/edit_news_view', $data, TRUE);
			$data['title'] = 'Добавление новой статьи';
			$this->load->view('/templates/admin_view', $data);
			return TRUE;
		}
		
		// по адресу "/admin/news/edit/<article_url>": страница редактирования новости
		else if( $this->uri->segment(3) == 'edit' )
		{
			if($this->uri->segment(4) == 'action')
			{
				$this->news_model->edit_from_post();
				redirect('/admin/news/edit/'.$this->news_model->get_by_id_for_admin($this->input->post('news_id'))->url.'/news_edit_success'); // @todo: не учтено, что id может быть несуществующим
			}
			
			$message = $this->uri->segment(5);
			$news = $this->uri->segment(4);
			
			if( is_numeric($news) )
			{
				$data['news'] = $this->news_model->get_by_id_for_admin($news);
			}
			else
			{
				$data['news'] = $this->news_model->get_by_url_for_admin($news);
			}
			
			if( ! $data['news'] )
			{
				$data['news'] = $this->news_model->get_short();
				$data['content'] = $this->load->view('/admin/news_view', $data, TRUE);
				$data['title'] = 'Ошибка при попытке открыть новость';
				$data['message'] = 'Произошла ошибка. Запрашиваемая новость отстутсвует в базе данных.';
				$this->load->view('/templates/admin_view', $data);
				return FALSE;
			}
			
			if( $message == 'news_edit_success')
			{
				$data['message'] = 'Новость отредактирована успешно';
			}
			else if( $message == 'news_add_success')
			{
				$data['message'] = 'Новость успешно добавлена в базу данных';
			}
	
			$data['content'] = $this->load->view('/admin/edit_news_view', $data, TRUE);
			$data['title'] = 'Редактирование новости';
			$this->load->view('/templates/admin_view', $data);
		}
		// по адресу "/admin/news/delete": удаление новости
		else if( $this->uri->segment(3) == 'delete' )
		{
			$this->news_model->delete( $this->uri->segment(4) );
			
			$data['news'] = $this->news_model->get_short();
			$data['content'] = $this->load->view('/admin/news_view', $data, TRUE);
			$data['title'] = 'Новости';
			$data['message'] = $this->news_model->message;
			$this->load->view('/templates/admin_view', $data);
		}
	}
	
	/**
	 * Работа с пользователями
	 * @param segment(3) - 'delete'
	 * @param segment(4) - user_id
	 */
	function users()
	{
		$data = NULL;
		$this->load->model('user_model');

		// по адресу "/admin/users": список всех пользователей
		if( $this->uri->segment(3) == '' ) 
		{
			$data['users'] = $this->user_model->get_short();
			$data['content'] = $this->load->view('/admin/users_view', $data, TRUE);
			$data['title'] = 'Пользователи';
			$this->load->view('/templates/admin_view', $data);
		}
		// по адресу "/admin/users/delete/<user_id>
		else if( $this->uri->segment(3) == 'delete' )
		{
			// @todo Удаление пользователя через админку
			echo "Опа, а тут тютю";
		}
	}
	
	
	function logout()
	{
		$this->session->sess_destroy();
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */