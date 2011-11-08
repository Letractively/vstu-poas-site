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
	 */
	function users()
	{
        $this->_page('users', 'user', MODEL_USER);	
	}
	
	/**
	 * Работа с проектами
	 */
	function projects()
	{
        $this->_page('projects', 'project', MODEL_PROJECT);
	}
    
	/**
     * Работа с научными направлениями
     */
	function directions()
    {
        $this->_page('directions', 'direction', MODEL_DIRECTION);
	}
    
    /**
     * Работа с публикациями
     */
    function publications()
    {
        $this->_page('publications', 'publication', MODEL_PUBLICATION);
    }
    
    /**
     * Работа с партнерами
     */
    function partners()
    {
        $this->_page('partners', 'partner', MODEL_PARTNERS);
    }
    
    function courses()
    {
        $data = NULL;
		$this->load->model(MODEL_COURSES);
        $this->lang->load('site', 'russian');
        
        switch($this->uri->segment(3)) {
            case 'add':
                $this->{MODEL_COURSES}->add_from_post();
                $this->_view_page_list('courses', MODEL_COURSES, $this->{MODEL_COURSES}->message);
                break;
            case 'edit':
                if ($this->uri->segment(4) == 'action')
                {
                    $this->{MODEL_COURSES}->edit_from_post();
                    $this->_view_page_list('courses', MODEL_COURSES, $this->{MODEL_COURSES}->message);
                }
                else
                {
                    // проверить, а есть ли запись
                    if (!$this->{MODEL_COURSES}->exists($this->uri->segment(4)))
                    {
                        $this->_view_page_list('courses', MODEL_COURSES, 'Запись не существует');
                        return;
                    }
                    $data['course'] = $this->{MODEL_COURSES}->get_course($this->uri->segment(4));
                    $data['extra'] = $this->{MODEL_COURSES}->get_view_extra();
                    $data['content'] = $this->load->view('/admin/edit_course_view', $data, TRUE);
                    $data['title'] = $this->lang->line('changing') . ' ' . $this->lang->line('course_a');
                    $this->load->view('/templates/admin_view', $data);
                }
                break;
            case 'delete':
                $this->{MODEL_COURSES}->delete($this->uri->segment(4));
                $this->_view_page_list('courses', MODEL_COURSES, $this->{MODEL_COURSES}->message);
                break;
            default:
                $this->_view_page_list('courses',MODEL_COURSES);
        }
        
    }
    
    function _page($name, $singlename, $model)
	{
		$data = NULL;
		$this->load->model($model);
        $this->lang->load('site', 'russian');
		
		switch($this->uri->segment(3)) {
			case 'add':
				if ($this->uri->segment(4) == 'action')
				{
                    // Если на форме ввода есть ошибки - вернуться к ним
                    if ($errors = $this->$model->get_errors())
                    {
                        $data['errors'] = $errors;
                        $data[$singlename] = $this->$model->get_from_post();
                        $data['extra'] = $this->$model->get_view_extra();
                        $data['content'] = $this->load->view('/admin/edit_' . $singlename . '_view', $data, TRUE);
                        //$data['title'] = 'Создание нового ' . $singlename;
                        $data['title'] = $this->lang->line('creatingnew') . ' ' . $this->lang->line($singlename.'_a');
                        $this->load->view('/templates/admin_view', $data);
                    }
                    else
                    {
                        $this->$model->add_from_post();
                        $this->_view_page_list($name, $model, $this->$model->message);
                    }
				}
				else
				{
					// по адресу "/admin/$name/add": добавление нового 
                    $data['extra'] = $this->$model->get_view_extra();
					$data['content'] = $this->load->view('/admin/edit_' . $singlename . '_view', $data, TRUE);
					//$data['title'] = 'Создание нового ' . $singlename;
                    $data['title'] = $this->lang->line('creatingnew') . ' ' . $this->lang->line($singlename.'_a');
					$this->load->view('/templates/admin_view', $data);
				}
				break;
			case 'edit':
				if ($this->uri->segment(4) == 'action')
				{
                    // Если на форме ввода есть ошибки - вернуться к ним
                    if ($errors = $this->$model->get_errors())
                    {
                        $data['errors'] = $errors;
                        $data[$singlename] = $this->$model->get_from_post();
                        $data['extra'] = $this->$model->get_view_extra();
                        $data['content'] = $this->load->view('/admin/edit_' . $singlename . '_view', $data, TRUE);
                        //$data['title'] = 'Изменение ' . $singlename;
                        $data['title'] = $this->lang->line('changing') . ' ' . $this->lang->line($singlename.'_a');
                        $this->load->view('/templates/admin_view', $data);
                    }
                    else
                    {
                        $this->$model->edit_from_post();
                        $this->_view_page_list($name, $model, $this->$model->message);
                    }
				}
				else
				{
					// по адресу "/admin/$name/edit/{id}": редактирование 
					$id = $this->uri->segment(4);
                    // проверить, а есть ли запись
                    if (!$this->$model->exists($id))
                    {
                        $this->_view_page_list($name, $model, 'Запись не существует');
                        return;
                    }
                        
					$data = array();
                    $methodname = 'get_' . $singlename;
					$data[$singlename] = $this->$model->$methodname($id);
                    $data['extra'] = $this->$model->get_view_extra();
					$data['content'] = $this->load->view('/admin/edit_' . $singlename . '_view', $data, TRUE);
					//$data['title'] = 'Изменение ' . $singlename;
                    $data['title'] = $this->lang->line('changing') . ' ' . $this->lang->line($singlename.'_a');
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
		$data['title'] = $this->lang->line($name);
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