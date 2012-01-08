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
        $data['breadcrumbs'] = $this->get_breadcrumbs();
		$this->load->view('templates/main_view', $data);
    }

    /**
     * Сформировать хлебные крошки для страницы
     * @return array массив элементов навигации
     */
    public function get_breadcrumbs()
    {
        $breadcrumbs = array();
        $breadcrumbs['/'] = $this->lang->line('page_main');
        $breadcrumbs['/conferences'] = $this->lang->line('page_conferences');
        return $breadcrumbs;
    }
}
