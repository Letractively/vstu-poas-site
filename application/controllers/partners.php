<?php
class Partners extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(TRUE);
		$this->load->database('default');
		$this->load->model(MODEL_PARTNER);
		lang();
	}

	function index()
	{
		$data['title'] = $this->lang->line('page_partners');
        $data['active'] = 'page_partners';
		$data['partners'] = $this->{MODEL_PARTNER}->get_cards();
		$data['content'] = $this->load->view('partners_view', $data, TRUE);
		$this->load->view('templates/new_main_view', $data);
	}

	/**
	 * Отобразить данные о партнере
	 * @param $id идентификатор партнера
	 */
	function show ($id)
	{
		$data['title'] = $this->lang->line('page_partners');
        $data['active'] = 'page_partners';
        if (!is_numeric($id))
        {
            $data['content'] = $this->lang->line('partner_doesnt_exist');
        }
        else
        {
            $data['partner'] = $this->{MODEL_PARTNER}->get_card($id);
            if (!$data['partner'])
            {
                $data['content'] = $this->lang->line('partner_doesnt_exist');
            }
            else
            {
                $data['content'] = $this->load->view('partner_view', $data, TRUE);
            }
        }
        $this->load->view('templates/new_main_view', $data);
	}
}