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
		$data['content'] = 'Бобро поржаровать!';
		$this->load->view('templates/new_main_view', $data);
    }
}
