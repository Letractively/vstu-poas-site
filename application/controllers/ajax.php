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
        $this->load->model(MODEL_ION_AUTH);
        $logged = $this->{MODEL_ION_AUTH}->login(
                        $this->input->post('form_login_username'),
                        $this->input->post('form_login_password'),
                        TRUE);
        if(!$logged) 
        {
            echo json_encode($this->ion_auth->errors());
        }
        else
        {
            echo json_encode(1);
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
    
    function get_all_users()
    {   
        if ($this->ion_auth->is_admin())
        {
            $users = $this->db
                                ->select(TABLE_USERS . '.id, name_ru as name, surname_ru as surname, patronymic_ru as patronymic')
                                ->from(TABLE_USERS)
                                ->order_by('surname,name,patronymic')
                                ->get()
                                ->result();
            echo json_encode($users);
        }
    }
    
    /**
     * Возвращает список участников по
     * имени таблицы, имени поля для указания идентификатора пользователей,
     * имени поля для указания идентификатора второй сущности (проекта и т.д.)
     * идентификатору второй сущности
     */
    function get_members() 
    {   
        if ($this->ion_auth->is_admin())
        {
            $field = $_POST['userfield'];
            $members = $this->db
                                ->select($_POST['userfield'])
                                ->from($_POST['table'])
                                ->where($_POST['fkfield'], $_POST['fk'])
                                ->get()
                                ->result();
            $res = array();
            foreach ($members as $member) 
            {
                $res[]=$member->$field;
            }
            echo json_encode($res);
        }
    }
    
    /**
     * Обновляет состав участников
     * Получает название таблицы, идентификатор сущности, название поля
     * Новый список получает в POST-переменной users[]
     */
    function update_members() 
    {
        if ($this->ion_auth->is_admin())
        {
            $this->_update_connected_users($this->input->post('table'),
                    $this->input->post('fkfield'), 
                    $this->input->post('fk'),
                    $this->input->post('userfield'),
                    $this->input->post('users'));
            $f = fopen('log.txt', 'w');
            fputs($f, json_encode($_POST));
            fclose($f);
        }
    }
    /**
     * Обновить таблицу участников
     * 
     * @param type $table таблица участников
     * @param type $field поле, содержащее идентификатор записи
     * @param type $id идентификатор записи
     * @param type $members массив участников
     */
    function _update_connected_users($table, $field, $id, $userfield, $members)
    {
        // Если никого вообще нет - удалить по id проекта
        if (!$members) 
        {
            $this->db->delete($table, array($field => $id));
            return;
        }
        $records = $this->db
                                ->select($userfield)
                                ->get_where($table, array($field => $id))
                                ->result();
        $old_members = array();
        foreach ($records as $record)
        {
            $old_members[] = $record->userid;
        }
        // удалить устаревшие записи (тех, кто был записан в проект, а теперь
        // его в списке нет
            foreach($old_members as $old_member) 
            {
                // Если старого нет среди новых - удалить его
                if (array_search($old_member, $members) === FALSE)
                {
                    $this->db->delete($table, array(
                        $userfield => $old_member,
                        $field => $id));
                    unset($old_member);
                }
            }
        // добавить в базу новых участников
        if ($members)
            foreach($members as $member)
            {
                // Если нового нет среди старых
                if (array_search($member, $old_members) === FALSE)
                {
                    $record = new stdClass();
                    $record->$field = $id;
                    $record->userid = $member;
                    $this->db->insert($table, $record);
                    unset($member);
                }
            }
    }
}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */