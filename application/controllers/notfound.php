<?php
class Notfound extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		lang();
		if (has_to_show_debug())
            $this->output->enable_profiler(TRUE);
	}

	/// Главная страница сайта
	function index()
	{
        $breadcrumbs = array();
        $breadcrumbs['/'] = $this->lang->line('page_main');
        $breadcrumbs['/notfound'] = $this->lang->line('page_404');

        $data['breadcrumbs'] = $breadcrumbs;
		$data['content'] = $this->load->view('static/404', NULL, TRUE);
        $data['active'] = 'none';
        $data['title'] = $this->lang->line('page_404');

        $this->load->view('templates/main_view', $data);
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */