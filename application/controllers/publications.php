<?php
class Publications extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(TRUE);	// Отладка (содержимое после основного контента)
		$this->load->database('default');
		$this->load->model(MODEL_PUBLICATION);
		lang();
	}
	
	function index($year = null)
	{
		$data['title'] = 'Публикации - Сайт кафедры ПОАС';                
        $data['years'] = $this->{MODEL_PUBLICATION}->get_years();
        
        if ($year == null && count($data['years']) > 0)
        {
            $data['currentyear'] = $data['years'][0];
        }
        else 
        {
            $data['currentyear'] = $year;
        }
        if ($data['currentyear'])
        {
            $data['publications'] = $this->{MODEL_PUBLICATION}->get_by_year($data['currentyear']);            
        }
        $data['content'] = $this->load->view('publications_view', $data, TRUE);
        $this->load->view('templates/main_view', $data);
	}
	
}