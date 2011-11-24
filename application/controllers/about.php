<?php
class About extends CI_Controller{
    function __construct()
	{
		parent::__construct();
	}
    
    /**
     * Вывести страницу истории кафедры
     */
    function history()
    {
        // Загрузка нужного словаря - 
        // необходимо для корректной работы $this->lang->line()
        lang();
        $data['title'] = $this->lang->line('page_history');
		$data['content'] = $this->load->view('static/about_history_'.lang(), '', TRUE);
		$this->load->view('templates/main_view', $data);
    }
}