<?php
class Notfound extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(TRUE);	// ������� (���������� ����� ��������� ��������)
		$this->load->database('default');
		lang();
	}
	
	/// ������� �������� �����
	function index()
	{
		$data['content'] = '<h3>404</h3><br> Sorry... <br> :\'(';
		$this->load->view('templates/main_view', $data);
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */