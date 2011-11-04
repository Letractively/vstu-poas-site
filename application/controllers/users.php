<?php
class Users extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(TRUE);	// Отладка (содержимое после основного контента)
		$this->load->database('default');
		$this->load->model('user_model');
		//$this->load->model('news_model');
		lang();
	}
	
	/// Главная страница сайта
	function index()
	{
		$data['title'] = 'Пользователи - Сайт кафедры ПОАС';
		$data['content'] = 'todo';
		$this->load->view('templates/main_view', $data);
	}
	
	/**
	 * Отобразить данные о пользователе
	 * @param $id идентификатор пользователя
	 * @param $page страница, для которой требуются данные
	 */
	function show ($id, $page = 'contacts')
	{
		$data['title'] = 'Пользователи - Сайт кафедры ПОАС';
		$data['id'] = $id;
		$data['info'] = $this->user_model->get_user_info($id, $page);
		$data['page'] = $page;
		$data['content'] = $this->load->view('user_view', $data, TRUE);
		$this->load->view('templates/main_view', $data);
	}
	
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */