<?php
class Contacts extends CI_Controller{
    function __construct()
	{
		parent::__construct();
        lang();
	}

    /**
     * Вывести страницу истории кафедры
     */
    function index()
    {
        // Загрузка нужного словаря -
        // необходимо для корректной работы $this->lang->line()
        $data['title'] = $this->lang->line('page_contacts');
        $data['active'] = 'page_contacts';
		$data['content'] = $this->load->view('static/contacts', '', TRUE);
		$this->load->view('templates/new_main_view', $data);
    }
}
