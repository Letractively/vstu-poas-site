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
		$user_group = $this->{MODEL_USER}->validate_from_post();
		if($user_group)
		{
			echo json_encode(1);
		}
		else
		{
			echo json_encode(0);
		}
	}
    
    function upload()
    {
        $error = '';
        $path = '';
        $id = '';
        
        $config['upload_path'] = './uploads/users/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		
		$this->load->library('upload', $config);
        $elementName = $_POST['fileElementId'];
        if ( ! $this->upload->do_upload($elementName))
		{
            $error = $this->upload->display_errors('','');
		}	
		else
		{
            // Получаем корректный путь к файлу
            $upload_data = $this->upload->data();
            $segments = explode('/',$upload_data['full_path']);
            $segments = array_reverse($segments);
            $file->name = $segments[2].'/'.$segments[1].'/'.$segments[0];
            
            $this->db->insert(TABLE_FILES, $file);
            $id = $this->db->insert_id();
            $path = $this->config->item('base_url').$file->name;
		}
        echo "{";
        echo				"error: '" . $error. "',\n";
        echo                "path:'" . $path . "',\n";
        echo                "id:" . $id . "\n";
        echo "}";        
    }
}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */