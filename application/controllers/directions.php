<?php
class Directions extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(TRUE);	// Отладка (содержимое после основного контента)
		$this->load->database('default');
		$this->load->model('direction_model');
		lang();
	}
	
	function index()
	{
		$data['title'] = 'Направления - Сайт кафедры ПОАС';
		$data['directions'] = $this->direction_model->get_short();
		$data['content'] = $this->load->view('directions_view', $data, TRUE);
		$this->load->view('templates/main_view', $data);
	}
	
	/**
	 * Отобразить данные о направлении
	 * @param $id идентификатор направления
	 */
	function show ($id)
	{
		$data['title'] = 'Направления - Сайт кафедры ПОАС';
		$data['direction'] = $this->direction_model->get_detailed($id);		
		if (!$data['direction']) 
		{
			$data['content'] = $this->lang->line('direction_doesnt_exist');
			$this->load->view('templates/main_view', $data);
		}
		else 
		{
			$data['members'] = $this->direction_model->get_members($id);
			$data['content'] = $this->load->view('direction_view', $data, TRUE);
			$this->load->view('templates/main_view', $data);
		}
	}
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */