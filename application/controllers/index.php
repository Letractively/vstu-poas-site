<?php
class Index extends CI_Controller{
    function __construct()
	{
		parent::__construct();
        lang();
        if (has_to_show_debug())
            $this->output->enable_profiler(TRUE);
	}

    /**
     * Вывести главную страницу
     */
    function index()
    {
        $data['title'] = $this->lang->line('page_main');
        $data['active'] = 'page_main';
        $data['content'] = '';
		$data['content'] .= 'Бобро поржаровать!';

        $breadcrumbs = array();
        $breadcrumbs['/'] = $this->lang->line('page_main');
        $data['breadcrumbs'] = $breadcrumbs;
		$this->load->view('templates/main_view', $data);
    }
}
