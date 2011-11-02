<?php
class Projects extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(TRUE);	// ������� (���������� ����� ��������� ��������)
		$this->load->database('default');
		$this->load->model('project_model');
		//$this->load->model('user_model');
		//$this->load->model('news_model');
		lang();
	}
	
	/// ������� �������� �����
	function index($id = null)
	{
		if (isset($id)) {
		echo $id;
		}
		$data['projects'] = $this->project_model->get_detailed();
		$data['content'] = $this->load->view('projects_view', $data, TRUE);
		$this->load->view('templates/main_view', $data);
	}

	
	/**
	 * @method 
	 * �������� � ���������
	 * @param [in] segment3 - ����� ��������
	 */ 
	function get()
	{
		// @todo - �������� � ��������� (� ������� 10 �������� �� ������ ��������)
		//$data['news'] = $this->news_model->get_short(1, 4);;
		//$data['content'] = $this->load->view('news_last_view', $data, TRUE);
		//$this->load->view('templates/main_view', $data);
	}
	
	/**
	 * @todo 
	 * �������� ��������� ����� ������� �������
	 */
	function show( $projectid )
	{
		echo $projectid;
		$data['content'] = $projectid;
		$this->load->view('templates/main_view', $data);
	}
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */