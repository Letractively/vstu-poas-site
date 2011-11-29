<?php
class Notfound extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(TRUE);	// Отладка (содержимое после основного контента)
		$this->load->database('default');
		lang();
	}

	/// Главная страница сайта
	function index()
	{
		$data['content'] = '<h3>404</h3><br> Sorry... <br> :\'(';
        $data['active'] = 'none';
		$this->load->view('templates/new_main_view', $data);
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */