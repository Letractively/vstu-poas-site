<?php
class Notfound extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if (has_to_show_debug())
            $this->output->enable_profiler(TRUE);
		$this->load->database('default');
		lang();
	}

	/// Главная страница сайта
	function index()
	{
		$data['content'] = '<h3>404</h3><br> Sorry... <br> :\'(';
        $data['active'] = 'none';
		$this->load->view('templates/main_view', $data);
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */