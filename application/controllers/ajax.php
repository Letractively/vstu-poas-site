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
    
    /**
     * Сохраняет файл на сервере. Удаляет старый файл.
     * использует POST-переменные:
     * upload_path - куда сохранять файл
     * allowed_types - разрешенные типы файлов
     * max_size - максимальный разрешенный размер
     * max_width - ширина, если это файл
     * max_height - максимальная высота
     * 
     * table_name - имя таблицы, к которой будет относиться файл
     * record_id - id записи в таблице table_name, к которой будет относится файл
     * field_name - имя поля, в которое должен будет записаться id файла
     * 
     * результат в формате JSON:
     * error - текст ошибки
     * fullpath - полный путь к файлу
     */
    function upload()
    {
        $error = '';
        $path = '';
        $id = '';
        $config['upload_path'] = $_POST['upload_path'];
		$config['allowed_types'] = $_POST['allowed_types'];
		$config['max_size']	= $_POST['max_size'];
		$config['max_width']  = $_POST['max_width'];
		$config['max_height']  = $_POST['max_height'];
		
		$this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('file_form'))
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
            
            // добавление записи в таблицу файлов
            $this->db->insert(TABLE_FILES, $file);
            $id = $this->db->insert_id();
            $path = $this->config->item('base_url') . $file->name;
            
            $field = $_POST['field_name'];
            // удаление старого файла из таблицы table_name с id = record_id из поля field_name
            $old = $this->db
                            ->select($field)
                            ->get_where($_POST['table_name'], array('id' => $_POST['record_id']))
                            ->result();
            if ($old) 
            {
                $this->load->model(MODEL_FILE);
                $oldpath = $this->{MODEL_FILE}->delete_file($old[0]->$field);
            }
            // добавление нового
            
            $record->$field = $id;
            $this->db->where('id', $_POST['record_id']);
            $this->db->update($_POST['table_name'], $record);            
		}
        echo "{";
        echo				"error: '" . $error. "',\n";
        echo                "path:'" . $path . "',\n";
        echo                "id:'" . $id . "'\n";
        echo "}";
    }
}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */