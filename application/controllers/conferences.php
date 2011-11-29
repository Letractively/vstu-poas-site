<?php
class Conferences extends CI_Controller{
    function __construct()
	{
		parent::__construct();
        lang();
	}

    /**
     * Вывести страницу конференций
     */
    function index()
    {
        $data['title'] = $this->lang->line('page_conferences');
        $data['active'] = 'page_conferences';
		$data['content'] = 'Конференции';
		$this->load->view('templates/new_main_view', $data);
    }
}
