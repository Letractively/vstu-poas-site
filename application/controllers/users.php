<?php
class Users extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if (has_to_show_debug())
            $this->output->enable_profiler(TRUE);
		$this->load->database('default');
		$this->load->model(MODEL_USER);
		//$this->load->model('news_model');
		lang();
	}

	/// Главная страница сайта
	function index()
	{
		$data['title'] = 'Пользователи - Сайт кафедры ПОАС';
        $data['users'] = $this->{MODEL_USER}->get_short();
        $data['active'] = 'none';
		$data['content'] = $this->load->view('users_view', $data, TRUE);
        $data['breadcrumbs'] = $this->get_breadcrumbs();
        $data['breadcrumbs']['/users'] = $this->lang->line('users');
		$this->load->view('templates/main_view', $data);
	}

	/**
	 * Отобразить данные о пользователе
	 * @param $id идентификатор пользователя
	 * @param $page страница, для которой требуются данные
	 */
	function show ($id, $page = 'contacts')
	{
        $fio = $this->{MODEL_USER}->get_fio($id);
		$data['title'] = 'Пользователи - Сайт кафедры ПОАС';
        $data['active'] = 'page_about';
		$data['id'] = $id;
		$data['info'] = $this->{MODEL_USER}->get_user_info($id, $page);
		$data['page'] = $page;
		$data['content'] = $this->load->view('user_view', $data, TRUE);

        $data['breadcrumbs'] = $this->get_breadcrumbs();
        $data['breadcrumbs']['/about'] = $this->lang->line('page_about');
        if ($this->{MODEL_USER}->get_user_groups($id)->group_id == ION_USER_LECTURER)
            $data['breadcrumbs']['/about/staff'] = $this->lang->line('page_staff');

        if ($this->{MODEL_USER}->get_user_groups($id)->group_id == ION_USER_STUDENT)
            $data['breadcrumbs']['/about/students'] = $this->lang->line('page_students');
        $data['breadcrumbs']['/users/'.$id] = $fio->surname.' '.$fio->name.' '.$fio->patronymic;
        $data['breadcrumbs']['/users/'.$id.'/'. $page] = $this->lang->line($page);
		$this->load->view('templates/main_view', $data);
	}

    /**
     * Сформировать хлебные крошки для страницы
     * @return array крошки
     */
    function get_breadcrumbs()
    {
        $breadcrumbs = array();
        $breadcrumbs['/'] = $this->lang->line('page_main');
        return $breadcrumbs;
    }

}

/* End of file users.php */
/* Location: ./application/controllers/users.php */