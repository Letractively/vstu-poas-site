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
		// @todo проверка на админа или редактора новостей
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
		// @todo проверка на администратора
		$data = NULL;
		$this->load->model(MODEL_USER);

		
		switch($this->uri->segment(3)) {
			case 'delete':
				// по адресу "/admin/users/delete/<user_id> 
				// удаление пользователя через админку				
				$this->user_model->delete_user($this->uri->segment(4));
				redirect('admin/users');
				break;
			case 'add':
				// по адресу "/admin/users/add
				// добавление пользователя через админку
				if ($this->uri->segment(4) == 'action')
				{
					if ($errors = $this->user_model->get_errors_add())
					{
						$data['content'] = $this->load->view('/admin/edit_user_view', $errors, TRUE);
						$data['title'] = 'Создание учетной записи пользователя';
						$this->load->view('/templates/admin_view', $data);
					}
					else 
					{
						$this->user_model->add_from_post();
						redirect('admin/users');
					}
					
				}
				else {
					// по адресу "/admin/users/add
					// добавление пользователя через админку
					//$data['users'] = $this->user_model->get_short();
					$data['content'] = $this->load->view('/admin/edit_user_view', $data, TRUE);
					$data['title'] = 'Создание учетной записи пользователя';
					$this->load->view('/templates/admin_view', $data);
				}
				break;
			
			case '':
			default:
				// по адресу "/admin/users": список всех пользователей
				// он же при несуществующем методе
				$data['users'] = $this->user_model->get_short();
				$data['content'] = $this->load->view('/admin/users_view', $data, TRUE);
				$data['title'] = 'Пользователи';
				$this->load->view('/templates/admin_view', $data);
				break;
		}		
	}
	
	/**
	 * Работа с проектами
	 */
	function projects()
	{
		// @todo проверка на преподавателя
		$data = NULL;
		$this->load->model(MODEL_PROJECT);
		
		switch($this->uri->segment(3)) {
			case 'add':
				if ($this->uri->segment(4) == 'action') 
				{
					$this->project_model->add_from_post();
					$this->_view_projects($this->project_model->message);
				}
				else 
				{
					// по адресу "/admin/projects/add": добавление нового проекта
					$data['content'] = $this->load->view('/admin/edit_project_view', $data, TRUE);
					$data['title'] = 'Создание нового проекта';
					$this->load->view('/templates/admin_view', $data);
				}
				break;
			case 'edit':
				if ($this->uri->segment(4) == 'action') 
				{
					$this->project_model->edit_from_post();
					$this->_view_projects($this->project_model->message);
				}
				else 
				{
					// по адресу "/admin/projects/edit/{id}": добавление редактирование проекта
					$id = $this->uri->segment(4);
					$data = array();
					$data['project'] = $this->project_model->get_project($id);
					$data['content'] = $this->load->view('/admin/edit_project_view', $data, TRUE);
					$data['title'] = 'Изменение проекта';
					$this->load->view('/templates/admin_view', $data);
				}
				break;
			case 'delete':
				// по адресу "/admin/projects/delete": удаление проекта
				$this->project_model->delete( $this->uri->segment(4) );
				
				$this->_view_projects($this->project_model->message);
				break;
			case '':
			default:
				// по адресу "/admin/projects": список всех проектов
				// он же при несуществующем методе
				$this->_view_projects();
				break;
		}
	}
	
	function _view_projects($message = null) {
		$data['projects'] = $this->project_model->get_short();
		$data['content'] = $this->load->view('/admin/projects_view', $data, TRUE);
		$data['title'] = 'Проекты';
		if($message != null) 
		{
			$data['message'] = $message;
		}
		$this->load->view('/templates/admin_view', $data);
	}
	
	function directions()
    {
        $this->_page('directions', 'direction', MODEL_DIRECTION);
	}
    
    function publications()
    {
        $this->_page('publications', 'publication', MODEL_PUBLICATION);
    }
    
    function partners()
    {
        $this->_page('partners', 'partner', MODEL_PARTNERS);
    }
    function _page($name, $singlename, $model)
	{
		$data = NULL;
		$this->load->model($model);
		
		switch($this->uri->segment(3)) {
			case 'add':
				if ($this->uri->segment(4) == 'action')
				{
					$this->$model->add_from_post();
					$this->_view_page_list($name, $model, $this->$model->message);
				}
				else
				{
					// по адресу "/admin/$name/add": добавление нового 
					$data['content'] = $this->load->view('/admin/edit_' . $singlename . '_view', $data, TRUE);
					$data['title'] = 'Создание нового ' . $singlename;          // creatingnew.$singlename;
					$this->load->view('/templates/admin_view', $data);
				}
				break;
			case 'edit':
				if ($this->uri->segment(4) == 'action')
				{
					$this->$model->edit_from_post();
					$this->_view_page_list($name, $model, $this->$model->message);
				}
				else
				{
					// по адресу "/admin/$name/edit/{id}": редактирование 
					$id = $this->uri->segment(4);
					$data = array();
                    $methodname = 'get_' . $singlename;
					$data[$singlename] = $this->$model->$methodname($id);
					$data['content'] = $this->load->view('/admin/edit_' . $singlename . '_view', $data, TRUE);
					$data['title'] = 'Изменение ' . $singlename;
					$this->load->view('/templates/admin_view', $data);
				}
				break;
			case 'delete':
				// по адресу "/admin/$name/delete": удаление 
				$this->$model->delete( $this->uri->segment(4) );
			
				$this->_view_page_list($name, $model, $this->$model->message);
				break;
			case '':
			default:
				// по адресу "/admin/$name": список всех 
				// он же при несуществующем методе
				$this->_view_page_list($name, $model);
				break;
		}
	}
	function _view_page_list($name, $model, $message = null)
    {
        $data[$name] = $this->$model->get_short();
		$data['content'] = $this->load->view('admin/' . $name . '_view', $data, TRUE);
		$data['title'] = $name;
		if($message != null)
		{
			$data['message'] = $message;
		}
		$this->load->view('/templates/admin_view', $data);
    }
	
	function logout()
	{
		$this->session->sess_destroy();
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */