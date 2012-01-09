<?php
class Conferences extends CI_Controller{
    function __construct()
	{
		parent::__construct();
        lang();
        if (has_to_show_debug())
            $this->output->enable_profiler(TRUE);
        $this->load->model(MODEL_CONFERENCE);
	}

    /**
     * Вывести страницу конференций
     */
    function index()
    {

        $data['conferences'] = $this->{MODEL_CONFERENCE}->get_cards();
		$data['content'] = $this->load->view('conferences_view', $data, TRUE);

        $data['title'] = $this->lang->line('page_conferences');
        $data['active'] = 'page_conferences';
        $data['breadcrumbs'] = $this->get_breadcrumbs();
		$this->load->view('templates/main_view', $data);
    }

    function show($id)
    {

        $data['breadcrumbs'] = $this->get_breadcrumbs();
        $data['title'] = $this->lang->line('page_conferences');
        if (!is_numeric($id) || !$this->{MODEL_CONFERENCE}->exists($id))
        {
            $data['content'] = $this->lang->line('conference_doesnt_exist');
        }
        else
        {
            $data['conference'] = $this->{MODEL_CONFERENCE}->get_card($id);
            $data['breadcrumbs']['/conferences/'.$id] = $data['conference']->name;
            $data['title'] .= ' - '.$data['conference']->name;
            $data['content'] = $this->load->view('conference_view', $data, TRUE);
        }
        $data['active'] = 'page_conferences';
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
