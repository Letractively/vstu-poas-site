<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Контроллер для обработки всех ajax-запросов
 *
 */
class Ajax extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
	}
	
	function index()
	{
	}
	
	/**
	 * Попытаться залогиниться, использя данные, отправленные методом POST
	 * @return bool - TRUE, если авторизация прошла успешно
	 */
	function login()
	{
		$this->load->model(MODEL_USER);
		$user_group = $this->user_model->validate_from_post();
		if($user_group)
		{
			echo json_encode(1);
		}
		else
		{
			echo json_encode(0);
		}
	}
}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */