<?php
class Conferences extends CI_Controller{
    function __construct()
	{
		parent::__construct();
        lang();
        if (has_to_show_debug())
            $this->output->enable_profiler(TRUE);
	}

    /**
     * Вывести страницу конференций
     */
    function index()
    {
        $data['title'] = $this->lang->line('page_conferences');
        $data['active'] = 'page_conferences';
		$data['content'] = 'Конференции';
		$this->load->view('templates/main_view', $data);
    }
}
