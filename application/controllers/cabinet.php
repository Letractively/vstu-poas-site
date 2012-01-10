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
            $data['user'] = $this->{MODEL_USER}->get_info_for_cabinet($this->session->userdata('user_id'));
            $data['content'] = $this->load->view('/cabinet_view', $data, TRUE);
        }
        else
        {
            $data['content'] = $this->load->view('/login_view', NULL, TRUE);
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