<?php
class Cabinet extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if (has_to_show_debug())
            $this->output->enable_profiler(TRUE);
		$this->load->database('default');
		$this->load->model(MODEL_USER);
		lang();
	}

	function index()
	{
		$data['title'] = $this->lang->line('page_cabinet');
        $data['active'] = '';
        $data['breadcrumbs'] = $this->get_breadcrumbs();

        if ($this->ion_auth->logged_in())
        {
            $fio = $this->{MODEL_USER}->get_fio($this->session->userdata('user_id'));
            $data['content'] = 'Ваше ФИО : '.$fio->surname.' '.$fio->name.' '.$fio->patronymic;
        }
        else
        {
            $data['content'] = 'Вы не авторизованы';
        }
		$this->load->view('templates/main_view', $data);
	}
    function get_breadcrumbs()
    {
        $breadcrumbs = array();
        $breadcrumbs['/'] = $this->lang->line('page_main');
        $breadcrumbs['/cabinet'] = $this->lang->line('page_cabinet');
        return $breadcrumbs;
    }
}