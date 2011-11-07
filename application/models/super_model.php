<?php
/**
 * @class Super_model
 * Модель-предок.
 */


abstract class Super_model extends CI_Model{
    var $message ='';
    abstract function get_short($id);
    abstract function get_detailed($id);
    abstract function add_from_post();
    abstract function edit_from_post();
    abstract function delete($id);
    function get_errors() {return null;}
    /**
	 * Получить основную информацию о всех записях
	 *
	 * Получить только name, id записей
     * @param $table - имя таблицы базы данных
     * @param $extraselect - дополнительные поля для SELECT-запроса
	 * @param $id - id направления, необязательный параметр
	 * @return массив всех записей, запись с указанным id или FALSE
	 */
    protected final function _get_short($table, $extraselect, $id = null)
    {
        if (isset($id))
		{
			$records = $this->db
							 ->select($extraselect . ',id, name_'.lang().' as name ')
							 ->where('name_'.lang().' IS NOT NULL AND name_'.lang().' != ""')
							 ->get_where($table, array('id' => $id), 1)
                             ->order_by('id DESC')
							 ->result();
			if( !$records)
			{
				return FALSE;
			}
			return $records[0];
		}
	
		return $this->db
					->select($extraselect . ',id, name_'.lang().' as name')
					->where('name_'.lang().' IS NOT NULL AND name_'.lang().' != ""')
					->order_by('id DESC')
					->get($table)
					->result();
    }
    
    /**
	 * Получить детальную информацию о записи
	 *     
	 * @param $id - идентификатор записи    
     * @param $table - имя таблицы базы данных
     * @param $extselect1 - часть первого SELECT-запроса. Должны быть 
     * перечислены требуемые поля с учетом языка. id и name_XX не указывать.
     * @param $extselect2 - часть второго SELECT-запроса. Должны быть 
     * перечислены требуемые русские поля. id и name_ru не указывать.
     * 
	 * @return запись
	 */
	protected final function _get_detailed($id, $table, $extselect1, $extselect2)
	{
		if (isset($id))
		{
			$records = $this->db
                                ->select('id,'.
                                         'name_' . lang() . ' as name,' .
                                         $extselect1)
                                ->get_where($table, array('id' => $id), 1)
                                ->result();
			// Если не нашлось направления на требуемом языке - выдать русскую версию
			if ($records && ( ! isset($records[0]->name) || $records[0]->name == '' ))
			{
				$records = $this->db
										->select('id,'.
												'name_ru as name,' .
												$extselect2)
										->get_where($table, array('id' => $id), 1)
										->result();
			}
			if( !$records)
			{
				return FALSE;
			}
			return $records[0];
		}
	}
    
    /**
	 * Получить запись из таблицы базы данных
	 *
	 * @param $id - идентификатор записи
     * @param $table - имя таблицы базы данных
	 * @return массив всех записей, запись с указанным id или FALSE
	 */
    protected final function _get_record($id, $table)
    {
        $record = $this->db->select('*')->get_where($table, array('id' => $id), 1)->result();
		if (!$record)
		{
			return NULL;
		}
		return $record[0];
    }
    
    /**
	 * Добавить новую запись
     * @param $table - имя таблицы базы даных
     * @param $record - запись
	 * @return int id - идентификатор добавленной записи | FALSE
	 */
	protected final function _add($table, $record) 
	{
		if($this->db->insert($table, $record))
		{
			$this->message = 'Запись была успешно внесена в базу данных';
			return $this->db->insert_id();
		}
		else
		{
			$this->message = 'Ошибка! Запись не удалось добавить';
			return FALSE;
		}
	}
    
    /**
	 * Изменить запись
     * @param $table - имя таблицы базы даных
     * @param $record - запись
	 */
    protected final function _edit($table, $record)
	{
		$this->db->where('id', $record->id);
		$response = $this->db->update($table, $record);
		if ($response != 1)
		{
			$this->message = 'Ошибка! Запись не была изменено';
		}
		else {
			$this->message = 'Запись была успешно изменена';
		}
		return $response;
	}
    
    /**
	 * Получить информацию о записи из данных, полученных методом POST
     * 
     * @param $name - имя сущности (direction, project, user, publication...)
     * @param array $fields - массив передаваемых POST-запросом данных в формате
     * (имя поля таблицы => имя POST-переменной)
     * @param array $nulled_fields - массив проверяемых на пустоту полей в
     * формате (имя поля таблицы => значение, считаемое нулевым)
     * 
	 * @return объект, содержащий собранную информацию о записи
	 */
	protected final function _get_from_post($name, $fields, $nulled_fields)
	{
		$record = new stdClass();
        foreach($fields as $field => $post)
        {
            $record->$field = $this->input->post($post);
        }
		if ($this->input->post($name . '_id') != '')
		{
			$record->id = 			$this->input->post($name . '_id');
		}
		// Не будем хранить пустоты зазря
        foreach ($nulled_fields as $field => $null_value)
        {
            if($record->$field === $null_value) {
                //$record->$field = null;
                unset($record->$field);
            }
        }
		return $record;
	}
    
    /**
	 * Удалить запись из базы
	 *
     * @param $table - имя таблицы базы данных
	 * @param $id - идентификатор записи
	 * @return TRUE, если направление удалено, иначе FALSE
	 */
	protected final function _delete ($table, $id)
	{
		if( ! $this->db->delete($table, array('id' => $id)))
		{
			$this->message = 'Произошла ошибка, запись удалить не удалось.';
			return FALSE;
		}
		else
		{
			$this->message = 'Запись удалена успешно (id был равен ' . $id . ').';
		}
		return TRUE;
	}
    
    /**
     * Проверить поля на заполненность.
     * @param $necessary1 обязательные поля
     * @param $necessary2 поля, обязательные, если одно из них заполнено
     * @return ошибки 
     */
    protected final function _get_errors($necessary1, $necessary2)
    {
        $errors = null;
        // Должны быть заполнены $necessary1
        foreach ($necessary1 as $post => $field)
        {
            if ($this->input->post($post) == '')
                $errors->$field = true;
        }
        
        // Если пользователь ввел хотя бы одно поле $necessary2
        // требовать все остальные
        $necessary2_started = false;
        foreach ($necessary2 as $post => $field)
        {
            $necessary2_started = $necessary2_started || $this->input->post($post) !== '';
        }
        if ($necessary2_started)
        {
            foreach ($necessary2 as $post => $field)
            {
                if ($this->input->post($post) == '')
                    $errors->$field = true;
            }
        }
		return $errors;
    }
    
}

?>
