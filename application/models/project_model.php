<?php
/**
 * @class Project_model
 * Модель проектов.
 */

require_once('super.php');
class Project_model extends Super
{

    /**
     * Провести валидацию данных в POST-запросе на странице редактирования
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @return boolean TRUE, если нет ошибок валидации, иначе - FALSE
     */
    public function validate()
    {
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $flag = $this->form_validation->run('admin/projects');
        if ($flag == FALSE)
        {
            $this->admin_message = 'Введены недопустимые данные';
        }
        return $flag;
    }

    /**
     * Сформировать запись из полей, полученных методом POST
     * @return mixed объект записи или FALSE
     */
    public function get_from_post()
    {
        $fields = array(
            'name_ru'  => 'project_name_ru',
            'name_en'  => 'project_name_en',
            'full_ru'  => 'project_full_ru',
            'full_en'  => 'project_full_en',
            'short_ru' => 'project_short_ru',
            'short_en' => 'project_short_en',
            'url' => 'project_url'
        );
        $nulled_fields = array(
            'name_ru' => '',
            'name_en' => '',
            'short_ru' => '',
            'short_en' => '',
            'full_en' => '',
            'full_ru' => '',
            'url' => ''
        );
        return parent::create_record_object('project', $fields, $nulled_fields);
    }

    /**
     * Добавить запись в БД, параметры которой переданы через POST-запросы
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @return boolean TRUE, если запись была успешно добавлена, иначе - FALSE
     */
    public function add_from_post()
    {
        return parent::add(TABLE_PROJECTS, $this->get_from_post());
    }

    /**
     * Получить список записей для панели администратора
     * @param int $page страница
     * @param int $amount_on_page количество записей на странице
     * @return array массив записей
     */
    public function get_records_for_admin_view($page = 1, $amount_on_page = 20)
    {
        $records = $this->db
                ->select('id, name_ru as name')
                ->get(TABLE_PROJECTS, $amount_on_page, ($page - 1) * $amount_on_page)
                ->result();
        if (is_array($records)) {
            foreach($records as $record){
                $record->memberscount = $this->get_members_count($record->id);
            }
        }
        return $records;
    }

    /**
     * Получить число участников проекта
     * @param int $id идентификатор проекта
     * @return int число участников проекта
     */
    public function get_members_count($id)
    {
        return $this->db->query('select count(distinct userid) as count from '
                                         .TABLE_PROJECT_MEMBERS
                                         .' where projectid='
                                         .$id)->row()->count;
    }

    /**
	 * Получить информацию обо всех участниках проекта
	 * @param int $id идентификатор проекта
	 * @return массив пользователей
	 */
	function get_members($id)
	{
		$this->db
            ->select(TABLE_USERS . '.id, name_'.lang().' as name, surname_'.lang().' as surname, patronymic_'.lang().' as patronymic')
            ->from(TABLE_PROJECT_MEMBERS)
            ->join(TABLE_USERS, TABLE_USERS.'.id = ' . TABLE_PROJECT_MEMBERS . '.userid')
            ->where('projectid = ' . $id);
        return $this->db->get()->result();
	}

     /**
     * Проверить, существует ли запись в БД
     * @param int $id идентифиактор искомой записи
     * @return boolean TRUE, если запись существует, иначе - FALSE
     */
    public function exists($id)
    {
        return parent::record_exists(TABLE_PROJECTS, $id);
    }

    /**
     * Получить полные данные о записи
     * @param int $id идентификатор записи
     * @return mixed запись или FALSE, если запись не существует
     */
    public function get_record_for_admin_edit_view($id)
    {
        return parent::get(TABLE_PROJECTS, $id);
    }

    /**
     * Обновить запись в БД, параметры которой переданы через POST-запросы
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @return boolean TRUE, если запись была успешно обновлена, иначе - FALSE
     */
    public function edit_from_post()
    {
        $project = $this->get_from_post();
        return parent::edit(TABLE_PROJECTS, $project);
    }

    /**
     * Удалить запись из БД
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @param int $id идентификатор удаляемой записи
     * @return boolean TRUE, если запись существовала и была успешно удалена, иначе - FALSE
     */
    public function delete($id)
    {
        $this->load->model(MODEL_FILE);
        $result = parent::get_fields(
                TABLE_PROJECTS,
                array('image'),
                NULL,
                NULL,
                $id);
        $this->{MODEL_FILE}->delete_file($result->image);
        // Удаление участников направления
        parent::delete_record(TABLE_PROJECT_MEMBERS, $id, 'projectid');

        return parent::delete_record(TABLE_PROJECTS, $id);
    }

    /**
     * Получить путь к изображению проекта
     * @param int $id идентификатор проекта
     * @return mixed путь или NULL
     */
    public function get_image_path($id)
    {
        $result = parent::get_fields(
                TABLE_PROJECTS,
                array('image'),
                NULL,
                NULL,
                $id);
        $this->load->model(MODEL_FILE);
        if ($result)
            $result->image = $this->{MODEL_FILE}->get_file_path($result->image);
        return $result->image;
    }

    /**
     * Получить информацию о направлениях для страницы направлений
     * @return array направления
     */
    public function get_cards()
    {
        $result = parent::get_fields(
                TABLE_PROJECTS,
                array(
                    'id',
                    'name_'.lang().' as name',
                    'short_'.lang().' as short',
                    'url'
                    ),
                NULL,
                'name_'.lang().' IS NOT NULL AND short_'.lang().' IS NOT NULL'
                );
        if (is_array($result)) {
            foreach($result as $record){
                $record->image = $this->get_image_path($record->id);
            }
        }
        return $result;
    }

    /**
     * Получить данные о направлении для страницы направлений на сайте
     * @param int $id идентификатор направления
     * @return object объект записи
     */
    public function get_card($id)
    {
        $result = parent::get_fields(
                TABLE_PROJECTS,
                array(
                    'id',
                    'name_'.lang().' as name',
                    'short_'.lang().' as short',
                    'full_'.lang().' as full',
                    'url',
                    'image'
                ),
                NULL,
                NULL,
                $id);
        if ($result->name == NULL)
        {
            $result = parent::get_fields(
                TABLE_PROJECTS,
                array(
                    'id',
                    'name_ru as name',
                    'short_ru as short',
                    'full_ru as full',
                    'url',
                    'image'
                ),
                NULL,
                NULL,
                $id);
        }
        $this->load->model(MODEL_FILE);
        if ($result)
            $result->image = $this->{MODEL_FILE}->get_file_path($result->image);
        return $result;
    }
}

/* End of file project_model.php */
/* Location: ./application/models/project_model.php */