<?php
class Contacts extends CI_Controller{
    function __construct()
	{
		parent::__construct();
        lang();
        if (has_to_show_debug())
            $this->output->enable_profiler(TRUE);
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
        $data['breadcrumbs'] = $this->get_breadcrumbs();
		$this->load->view('templates/new_main_view', $data);
    }

    function get_breadcrumbs()
    {
        $breadcrumbs = array();
        $breadcrumbs['/'] = $this->lang->line('page_main');
        $breadcrumbs['/contacts'] = $this->lang->line('page_contacts');
        return $breadcrumbs;
    }
}
