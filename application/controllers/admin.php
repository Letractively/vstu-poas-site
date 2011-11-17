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
        $data['title'] = 'Главная';
        $data['content'] = $this->load->view('admin/index_view', null, TRUE);
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
     * Узнать, свободен ли логин.
     * Используется библиотекой Form validation, см. config/form_validation.php
     * @param $username интересующий систему логин
     * @return bool TRUE, если логин свободен, иначе FALSE
     */
    function _username_unique($username)
    {
        $this->load->model(MODEL_USER);
        $result = $this->{MODEL_USER}->is_username_exist($username);
        if ($result){
            $this->form_validation->set_message('_username_unique', 'Логин уже используется');
        }
        return !$result;
    }
    
    function _validate_photo($file)
    {
        $config['upload_path'] = './uploads/users/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		
		$this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload('user_photo'))
		{
            // Если при добавлении файла произошла ошибка - закончить операцию
            $errors = $this->upload->display_errors('','');
            if ($errors != $this->lang->line('upload_no_file_selected'))
            {
                $this->form_validation->set_message('_validate_photo', $this->upload->display_errors('',''));
                return FALSE;
            }
            else
            {
                return TRUE;
            }
		}	
		else
		{            
            // Получаем корректный путь к файлу
            $upload_data = $this->upload->data();
            $segments = explode('/',$upload_data['full_path']);
            $segments = array_reverse($segments);
            
            $record->name = $segments[2].'/'.$segments[1].'/'.$segments[0];
            if($this->db->insert(TABLE_FILES, $record)){
                $_POST['user_photo'] = $this->db->insert_id();
            }
		}
    }
	/**
	 * Работа с пользователями
	 */
	function users()
	{
        //$this->_page('users', 'user', MODEL_USER);
        $data = NULL;
		$this->load->model(MODEL_USER);
        $this->load->model(MODEL_FILE);
        $this->lang->load('site', 'russian');
		$this->load->library('form_validation');
		switch($this->uri->segment(3)) {
			case 'add':
                if($this->uri->segment(4) == 'action')
                {
                    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                    if ($this->form_validation->run('admin/users/add') == FALSE)
                    {
                        $data['extra'] = $this->{MODEL_USER}->get_view_extra();
                        $data['content'] = $this->load->view('admin/edit_user_view', $data, TRUE);
                        $data['title'] = $this->lang->line('creatingnew') . ' ' . $this->lang->line('user_a');
                        $this->load->view('/templates/admin_view', $data);                        
                    }
                    else
                    {
                        $this->{MODEL_USER}->add_from_post();
                        $this->_view_page_list('users', MODEL_USER, $this->{MODEL_USER}->message);
                    }
                }
                else
                {
                    // загрузить необходимые виду данные
                    $data['extra'] = $this->{MODEL_USER}->get_view_extra();
                    $data['content'] = $this->load->view('/admin/edit_user_view', $data, TRUE);
                    $data['title'] = $this->lang->line('creatingnew') . ' ' . $this->lang->line('user_a');
                    $this->load->view('/templates/admin_view', $data);
                }
				break;
			case 'edit':
                if($this->uri->segment(4) == 'action')
                {
                    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                    if ($this->form_validation->run('admin/users/edit') == FALSE)
                    {
                        $data['extra'] = $this->{MODEL_USER}->get_view_extra();
                        $data['user'] = $this->{MODEL_USER}->get_from_post();
                        $data['content'] = $this->load->view('admin/edit_user_view', $data, TRUE);
                        $data['title'] = $this->lang->line('changing') . ' ' . $this->lang->line('user_a');
                        $this->load->view('/templates/admin_view', $data);                        
                    }
                    else
                    {
                        $this->{MODEL_USER}->edit_from_post();
                        $this->_view_page_list('users', MODEL_USER, $this->{MODEL_USER}->message);
                    }
                }
                else
                {
                    if (!$this->{MODEL_USER}->exists($this->uri->segment(4)))
                    {
                        $this->_view_page_list('users', MODEL_USER, 'Пользователь не существует');
                        return;
                    }
                    // загрузить необходимые виду данные
                    $data['extra'] = $this->{MODEL_USER}->get_view_extra();
                    $data['user'] = $this->{MODEL_USER}->get_user($this->uri->segment(4));
                    $data['content'] = $this->load->view('/admin/edit_user_view', $data, TRUE);
                    $data['title'] = $this->lang->line('changing') . ' ' . $this->lang->line('user_a');
                    $this->load->view('/templates/admin_view', $data);
                }
				break;
			case 'delete':
                if (!$this->{MODEL_USER}->exists($this->uri->segment(4)))
                {
                    $this->_view_page_list('users', MODEL_USER, 'Пользователь не существует');
                    return;
                }
				$this->{MODEL_USER}->delete($this->uri->segment(4));
                $this->_view_page_list('users', MODEL_USER, $this->{MODEL_USER}->message);
				break;
            case 'edit_photo':
                if (!$this->{MODEL_USER}->exists($this->uri->segment(4)))
                {
                    $this->_view_page_list('users', MODEL_USER, 'Пользователь не существует');
                    return;
                }                
                $data['record_id'] = $this->uri->segment(4);
                $data['table_name'] = TABLE_USERS;
                $data['field_name'] = 'photo';
                $data['file_url'] = $this->{MODEL_USER}->get_photo($this->uri->segment(4));
                $data['upload_path'] = './uploads/users/';
                $data['max_width'] = '800';
                $data['max_height'] = '600';
                $data['content'] = $this->load->view('upload_file', $data, TRUE);
                $data['content'] .= '<br><br><a href="admin/users"> К списку пользователей </a>';
                $user = $this->{MODEL_USER}->get_short($this->uri->segment(4));
                $data['title'] = 'Редактирование фотографии пользователя <br>"' . $user->surname . ' ' . $user->name . ' ' . $user->patronymic . '"';
                $this->load->view('/templates/admin_view', $data);
				break;
			case '':
			default:
				// по адресу "/admin/$name": список всех 
				// он же при несуществующем методе
				$this->_view_page_list('users', MODEL_USER);
				break;
		}
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
        //$this->_page('users', 'user', MODEL_USER);
        $data = NULL;
		$this->load->model(MODEL_PARTNER);
        $this->lang->load('site', 'russian');
		$this->load->library('form_validation');
		switch($this->uri->segment(3)) {
			case 'add':
                if($this->uri->segment(4) == 'action')
                {
                    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                    if ($this->form_validation->run('admin/partners/add') == FALSE)
                    {
                        $data['extra'] = $this->{MODEL_PARTNER}->get_view_extra();
                        $data['content'] = $this->load->view('admin/edit_partner_view', $data, TRUE);
                        $data['title'] = $this->lang->line('creatingnew') . ' ' . $this->lang->line('partner_a');
                        $this->load->view('/templates/admin_view', $data);                        
                    }
                    else
                    {
                        $this->{MODEL_PARTNER}->add_from_post();
                        $this->_view_page_list('partners', MODEL_PARTNER, $this->{MODEL_PARTNER}->message);
                    }
                }
                else
                {
                    // загрузить необходимые виду данные
                    $data['extra'] = $this->{MODEL_PARTNER}->get_view_extra();
                    $data['content'] = $this->load->view('/admin/edit_partner_view', $data, TRUE);
                    $data['title'] = $this->lang->line('creatingnew') . ' ' . $this->lang->line('partner_a');
                    $this->load->view('/templates/admin_view', $data);
                }
				break;
			case 'edit':
                if($this->uri->segment(4) == 'action')
                {
                    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                    if ($this->form_validation->run('admin/partners/edit') == FALSE)
                    {
                        $data['extra'] = $this->{MODEL_PARTNER}->get_view_extra();
                        $data['partner'] = $this->{MODEL_PARTNER}->get_from_post();
                        $data['content'] = $this->load->view('admin/edit_partner_view', $data, TRUE);
                        $data['title'] = $this->lang->line('changing') . ' ' . $this->lang->line('partner_a');
                        $this->load->view('/templates/admin_view', $data);                        
                    }
                    else
                    {
                        $this->{MODEL_PARTNER}->edit_from_post();
                        $this->_view_page_list('partners', MODEL_PARTNER, $this->{MODEL_PARTNER}->message);
                    }
                }
                else
                {
                    if (!$this->{MODEL_PARTNER}->exists($this->uri->segment(4)))
                    {
                        $this->_view_page_list('partners', MODEL_PARTNER, 'Партнер не существует');
                        return;
                    }
                    // загрузить необходимые виду данные
                    $data['extra'] = $this->{MODEL_PARTNER}->get_view_extra();
                    $data['partner'] = $this->{MODEL_PARTNER}->get_partner($this->uri->segment(4));
                    $data['content'] = $this->load->view('/admin/edit_partner_view', $data, TRUE);
                    $data['title'] = $this->lang->line('changing') . ' ' . $this->lang->line('user_a');
                    $this->load->view('/templates/admin_view', $data);
                }
				break;
			case 'delete':
                if (!$this->{MODEL_PARTNER}->exists($this->uri->segment(4)))
                {
                    $this->_view_page_list('partners', MODEL_PARTNER, 'Партнер не существует');
                    return;
                }
				$this->{MODEL_PARTNER}->delete($this->uri->segment(4));
                $this->_view_page_list('partners', MODEL_PARTNER, $this->{MODEL_PARTNER}->message);
				break;
			case '':
			default:
				// по адресу "/admin/$name": список всех 
				// он же при несуществующем методе
				$this->_view_page_list('partners', MODEL_PARTNER);
				break;
		}
    }
    
    function courses()
    {
        $data = NULL;
		$this->load->model(MODEL_COURSE);
        $this->lang->load('site', 'russian');
        
        switch($this->uri->segment(3)) {
            case 'add':
                $this->{MODEL_COURSE}->add_from_post();
                $this->_view_page_list('courses', MODEL_COURSE, $this->{MODEL_COURSE}->message);
                break;
            case 'edit':
                if ($this->uri->segment(4) == 'action')
                {
                    $this->{MODEL_COURSE}->edit_from_post();
                    $this->_view_page_list('courses', MODEL_COURSE, $this->{MODEL_COURSE}->message);
                }
                else
                {
                    // проверить, а есть ли запись
                    if (!$this->{MODEL_COURSE}->exists($this->uri->segment(4)))
                    {
                        $this->_view_page_list('courses', MODEL_COURSE, 'Запись не существует');
                        return;
                    }
                    $data['course'] = $this->{MODEL_COURSE}->get_course($this->uri->segment(4));
                    $data['extra'] = $this->{MODEL_COURSE}->get_view_extra();
                    $data['content'] = $this->load->view('/admin/edit_course_view', $data, TRUE);
                    $data['title'] = $this->lang->line('changing') . ' ' . $this->lang->line('course_a');
                    $this->load->view('/templates/admin_view', $data);
                }
                break;
            case 'delete':
                $this->{MODEL_COURSE}->delete($this->uri->segment(4));
                $this->_view_page_list('courses', MODEL_COURSE, $this->{MODEL_COURSE}->message);
                break;
            default:
                $this->_view_page_list('courses',MODEL_COURSE);
        }
        
    }
    
    /**
     * Управляющая страницами функция.
     * @param $name название страницы (напр. users)
     * @param $singlename название страницы в единственном числе (напр user)
     * @param $model модель, используемая на странице
     */
    function _page($name, $singlename, $model)
	{
		$data = NULL;
		$this->load->model($model);
        $this->lang->load('site', 'russian');
		
		switch($this->uri->segment(3)) {
			case 'add':
                // по адресу "/admin/$name/add" происходит операция добавления
				if ($this->uri->segment(4) == 'action')
				{
                    if ($errors = $this->$model->get_errors())
                    {
                        // Если на форме ввода есть ошибки - вернуться к форме
                        $data['errors'] = $errors;
                        $data[$singlename] = $this->$model->get_from_post();
                        $data['extra'] = $this->$model->get_view_extra();
                        $data['content'] = $this->load->view('/admin/edit_' . $singlename . '_view', $data, TRUE);
                        $data['title'] = $this->lang->line('creatingnew') . ' ' . $this->lang->line($singlename.'_a');
                        $this->load->view('/templates/admin_view', $data);
                    }
                    else
                    {
                        // Если все данные введены верно - добавить запись в базу данных
                        $this->$model->add_from_post();
                        $this->_view_page_list($name, $model, $this->$model->message);
                    }
				}
				else
				{
                    // загрузить необходимые виду данные
                    $data['extra'] = $this->$model->get_view_extra();
                    // вызвать вид (форму ввода данных)
					$data['content'] = $this->load->view('/admin/edit_' . $singlename . '_view', $data, TRUE);
					$data['title'] = $this->lang->line('creatingnew') . ' ' . $this->lang->line($singlename.'_a');
					$this->load->view('/templates/admin_view', $data);
				}
				break;
			case 'edit':
                // по адресу "/admin/$name/add" происходит операция изменения 
				if ($this->uri->segment(4) == 'action')
				{
                    // Если на форме ввода есть ошибки - вернуться к ним
                    if ($errors = $this->$model->get_errors())
                    {
                        $data['errors'] = $errors;
                        $data[$singlename] = $this->$model->get_from_post();
                        $data['extra'] = $this->$model->get_view_extra();
                        $data['content'] = $this->load->view('/admin/edit_' . $singlename . '_view', $data, TRUE);
                        $data['title'] = $this->lang->line('changing') . ' ' . $this->lang->line($singlename.'_a');
                        $this->load->view('/templates/admin_view', $data);
                    }
                    else
                    {
                        // Если ошибок нет
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
        redirect($this->config->item('base_url'));
	}
    function _add_file($file) 
    {
        $config['upload_path'] = './uploads/projects/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		
		$this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload('project_image'))
		{
            // Если при добавлении файла произошла ошибка - закончить операцию
            $this->form_validation->set_message('_add_file', $this->upload->display_errors('',''));
            return FALSE;
		}	
		else
		{
            // Если ошибок не возникло - запомнить путь к файлу в POST переменной
            echo 'no errors';
            
            // Получаем корректный путь к файлу
            $upload_data = $this->upload->data();
            $segments = explode('/',$upload_data['full_path']);
            $segments = array_reverse($segments);
            
            $_POST['project_image'] = $segments[2].'/'.$segments[1].'/'.$segments[0];
            
            return TRUE;
		}
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */