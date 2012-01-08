<?php
/**
 * Модель-предок для всех сущностей сайта
 */

class Super extends CI_Model
{

    // Сообщение в панели администратора
    private $admin_message = FALSE;

    /**
     * Получить сообщение для панели администратора
     * @return сообщение или FALSE
     */
    public final function get_message()
    {
        return $this->admin_message;
    }

    /**
     * Проверить, существует ли запись в БД
     * @param int $id идентифиактор искомой записи
     * @return boolean TRUE, если запись существует, иначе - FALSE
     */
    public function exists($id)
    {
        return FALSE;
    }

    /**
     * Получить количество записей в БД
     * @return int количество записей в БД
     */
    public function count_all()
    {
        return 0;
    }

    /**
     * Удалить запись из БД
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @param int $id идентификатор удаляемой записи
     * @return boolean TRUE, если запись существовала и была успешно удалена, иначе - FALSE
     */
    public function delete($id)
    {
        return FALSE;
    }

    /**
     * Получить список записей для панели администратора
     * @param int $page страница
     * @param int $amount_on_page количество записей на странице
     * @return array массив записей
     */
    public function get_records_for_admin_view($page = 1, $amount_on_page = 20)
    {
        return array();
    }

    /**
     * Получить полные данные о записи
     * @param int $id идентификатор записи
     * @return mixed запись или FALSE, если запись не существует
     */
    public function get_record_for_admin_edit_view($id)
    {
        return new stdClass();
    }

    /**
     * Провести валидацию данных в POST-запросе на странице редактирования
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @return boolean TRUE, если нет ошибок валидации, иначе - FALSE
     */
    public function validate()
    {
        return FALSE;
    }

    /**
     * Добавить запись в БД, параметры которой переданы через POST-запросы
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @return mixed идентификатор, если запись была успешно добавлена, иначе - FALSE
     */
    public function add_from_post()
    {
        return FALSE;
    }

    /**
     * Обновить запись в БД, параметры которой переданы через POST-запросы
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @return boolean TRUE, если запись была успешно обновлена, иначе - FALSE
     */
    public function edit_from_post()
    {
        return FALSE;
    }

    /**
     * Сформировать запись из полей, полученных методом POST
     * @return mixed объект записи или FALSE
     */
    public function get_from_post()
    {
        return FALSE;
    }

    /**
     * Получить дополнительные данные для страницы редактирования записи
     * @param int $id идентификатор записи, для которой требуются данные
     * @return mixed данные или FALSE
     */
    public function get_admin_edit_view_extra($id = NULL)
    {
        return FALSE;
    }

    /**
	 * Собрать запись-объект из имени объекта и полей, переданных как
     * POST-запрос
     *
     * @param string $name - имя сущности (direction, project, user, publication...)
     * @param array $fields - массив передаваемых POST-запросом данных в формате
     * (имя поля таблицы => имя POST-переменной)
     * @param array $nulled_fields - массив проверяемых на пустоту полей в
     * формате (имя поля таблицы => значение, считаемое нулевым)
     *
	 * @return объект, содержащий собранную информацию о записи
	 */
	protected final function create_record_object($name, array $fields, array $nulled_fields)
	{
		$record = new stdClass();
        // Собрать поля в один объект
        foreach($fields as $field => $post)
        {
            $record->$field = $this->input->post($post);
        }
        // Добавить поле id, если оно передано
		if ($this->input->post($name . '_id') != '')
		{
			$record->id = $this->input->post($name . '_id');
		}
		// Сбросить в NULL определенные поля с определенными значениями
        foreach ($nulled_fields as $field => $null_value)
        {
            if($record->$field === $null_value) {
                $record->$field = NULL;
            }
        }
		return $record;
	}

    /**
	 * Добавить новую запись в базу данных
     * @param $table - имя таблицы базы даных
     * @param $record - запись
	 * @return mixed идентификатор добавленной записи | FALSE
	 */
	protected final function add($table, $record)
	{
		if($this->db->insert($table, $record))
		{
            $id = $this->db->insert_id();
			$this->admin_message = 'Запись была успешно внесена в базу данных ('.$table.', id=' . $id.')';
			return $id;
		}
		else
		{
			$this->admin_message = 'Ошибка! Запись не удалось добавить ('.$table.')';
			return FALSE;
		}
	}

    /**
	 * Добавить новую запись в базу данных
     * @param $table - имя таблицы базы даных
     * @param $record - запись
	 * @return mixed идентификатор добавленной записи | FALSE
	 */
	protected final function edit($table, $record)
	{
		$this->db->where('id', $record->id);
		$response = $this->db->update($table, $record);

		if ($response != 1)
		{
			$this->admin_message = 'Ошибка! Запись не была изменена ('.$table.', '.$record->id.')';
		}
		else {
			$this->admin_message = 'Запись была успешно изменена ('.$table.', '.$record->id.')';
		}
		return $response;
	}

    /**
     * Проверить, существует ли в таблице запись с указанным атрибутом
     *
     * @param string $table таблица
     * @param mixed $value значение
     * @param string $field поле, по умолчанию id
     * @return mixed число вхождений или FALSE
     */
    protected final function record_exists($table, $value, $field = 'id')
    {
        $this->db->from($table)->where($field, $value);
        $count = $this->db->count_all_results();
        return  $count > 0 ? $count : FALSE;
    }

    /**
     * Получить всю запись из БД
     * @param string $table название таблицы
     * @param int $id идентификатор
     * @return mixed запись или FALSE
     */
    protected final function get($table, $id)
    {
        $records = $this->db
                ->select('*')
                ->get_where($table, array('id' => $id))
                ->result();
        if (count($records) == 1)
        {
            return $records[0];
        }
        else
        {
            if (count($records) == 0)
                $this->admin_message = 'Ошибка! Запись с таким id не найдена';
            else
                $this->admin_message = 'Ошибка! Существует более чем одна запись с таким id';
            return FALSE;
        }
    }

    /**
	 * Удалить запись из базы
	 *
     * @param string $table - имя таблицы базы данных
	 * @param mixed $value - идентификатор записи
     * @param string $field - атрибут, по которому происходит поиск
	 * @return boolean TRUE, если запись удалена, иначе FALSE
	 */
	protected final function delete_record($table, $value, $field = 'id')
	{
		if(!$this->db->delete($table, array($field => $value)))
		{
			$this->admin_message = 'Произошла ошибка, запись удалить не удалось ('.$table.', '.$field.' = ' . $value . ').';
			return FALSE;
		}
		else
		{
			$this->admin_message = 'Запись удалена успешно ('.$table.', '.$field.' = ' . $value . ').';
            return TRUE;
		}
	}

    /**
     * Получить запись или записи из БД
     *
     * @param string $table название таблицы
     * @param array $fields извлекаемые поля
     * @param string $order_by порядок
     * @param string $where условие
     * @param int $id идентификатор
     * @return mixed объект записи или массив объектов записей
     */
    protected final function get_fields($table, array $fields, $order_by, $where, $id = NULL)
    {
        if ($id == NULL)
        {
            $this->db->select($fields);
            if ($where)
                $this->db->where($where);
            if ($order_by)
                $this->db->order_by($order_by);

            return $this->db->get($table)->result();
        }
        else
        {
            $this->db->select($fields);
            if ($where)
                $this->db->where($where);
            if ($order_by)
                $this->db->order_by($order_by);
            $records = $this->db
                    ->get_where($table, array('id' => $id), 1)
                    ->result();
            if( !$records)
			{
                $this->admin_message = 'Ошибка! Запись с таким id не найдена';
				return FALSE;
			}
			return $records[0];
        }
    }
}

/* End of file super.php */
/* Location: ./application/models/super.php */