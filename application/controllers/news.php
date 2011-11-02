<?php
class News extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(TRUE);	// Отладка (содержимое после основного контента)
		$this->load->database('default');
		$this->load->model('user_model');
		$this->load->model('news_model');
		lang();
	}
	
	/// Главная страница сайта
	function index()
	{
		$data['news'] = $this->news_model->get_short(1, 4);;
		$data['content'] = $this->load->view('news_last_view', $data, TRUE);
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
	 * Страница просмотра одной новости целиком
	 */
	function show( $url_of_news )
	{
		$data['news'] = $this->{MODEL_NEWS}->get_by_url($url_of_news);
		$data['content'] = $this->load->view('news_view', $data, TRUE);
		$this->load->view('templates/main_view', $data);
	}
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */