<?php
class Projects extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(TRUE);	// Отладка (содержимое после основного контента)
		$this->load->database('default');
		$this->load->model('project_model');
		//$this->load->model('user_model');
		//$this->load->model('news_model');
		lang();
	}
	
	/// Главная страница сайта
	function index()
	{
		
		$data['projects'] = $this->project_model->get_short();
		$data['content'] = $this->load->view('projects_view', $data, TRUE);
		$this->load->view('templates/main_view', $data);
	}

	
	/**
	 * @method 
	 * Страница с новостями
	 * @param [in] segment3 - номер страницы
	 */ 
	function get()
	{
		// @todo - страница с новостями (к примеру 10 новостей на каждой странице)
		//$data['news'] = $this->news_model->get_short(1, 4);;
		//$data['content'] = $this->load->view('news_last_view', $data, TRUE);
		//$this->load->view('templates/main_view', $data);
	}
	
	/**
	 * @todo 
	 * Страница просмотра одного проекта целиком
	 */
	function show ($id)
	{
		$data['project'] = $this->project_model->get_detailed($id);
		if (!$data['project']) 
		{
			$data['content'] = $this->lang->line('projects_doesnt_exist');
			$this->load->view('templates/main_view', $data);
		}
		else 
		{
			$data['content'] = $this->load->view('project_view', $data, TRUE);
			$this->load->view('templates/main_view', $data);
		}
	}
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */