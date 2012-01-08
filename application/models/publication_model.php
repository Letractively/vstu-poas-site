<?php
/**
 * Модель партнера
 */
require_once('super.php');
class Publication_model extends Super{

    /**
     * Получить список записей для панели администратора
     * @param int $page страница
     * @param int $amount_on_page количество записей на странице
     * @return array массив записей
     */
    public function get_records_for_admin_view($page = 1, $amount_on_page = 20)
    {
        $result = $this->db
                ->select('id, name_ru as name')
                ->get(TABLE_PUBLICATIONS, $amount_on_page, ($page - 1) * $amount_on_page)
                ->result();
        if (is_array($result)) {
            foreach($result as $record){
                $record->authorscount = $this->get_authors_count($record->id);
            }
        }
        return $result;
    }

    /**
     * Получить число авторов публикации
     * @param int $id идетификатор публикации
     * @return int число авторов публикации
     */
    public function get_authors_count($id)
    {
        return $this->db->from(TABLE_PUBLICATION_AUTHORS)->where('publicationid', $id)->count_all_results();
    }

    /**
	 * Получить информацию обо всех авторах публикации
	 * @param int $id идентификатор публикации
	 * @return array массив пользователей
	 */
	public function get_authors($id)
	{
		$this->db
            ->select(TABLE_USERS . '.id, name_'.lang().' as name, surname_'.lang().' as surname, patronymic_'.lang().' as patronymic')
            ->from(TABLE_PUBLICATION_AUTHORS)
            ->join(TABLE_USERS, TABLE_USERS.'.id = ' . TABLE_PUBLICATION_AUTHORS . '.userid')
            ->where('publicationid = ' . $id);
        return $this->db->get()->result();
	}

    /**
     * Провести валидацию данных в POST-запросе на странице редактирования
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @return boolean TRUE, если нет ошибок валидации, иначе - FALSE
     */
    public function validate()
    {
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $flag = $this->form_validation->run('admin/publications');
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
            'name_ru'     => 'publication_name_ru',
            'name_en'     => 'publication_name_en',
            'fulltext_ru' => 'publication_fulltext_ru',
            'fulltext_en' => 'publication_fulltext_en',
            'abstract_ru' => 'publication_abstract_ru',
            'abstract_en' => 'publication_abstract_en',
            'year'        => 'publication_year',
            'info_ru'     => 'publication_info_ru',
            'info_en'     => 'publication_info_en'
        );
        $nulled_fields = array(
            'name_ru'     => 'publication_name_ru',
            'name_en'     => '',
            'fulltext_ru' => '',
            'fulltext_en' => '',
            'abstract_ru' => '',
            'abstract_en' => '',
            'info_ru'     => '',
            'info_en'     => ''
        );
        return parent::create_record_object('publication', $fields, $nulled_fields);
    }

    /**
     * Добавить запись в БД, параметры которой переданы через POST-запросы
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @return boolean TRUE, если запись была успешно добавлена, иначе - FALSE
     */
    public function add_from_post()
    {
        return parent::add(TABLE_PUBLICATIONS, $this->get_from_post());
    }

    /**
     * Проверить, существует ли запись в БД
     * @param int $id идентифиактор искомой записи
     * @return boolean TRUE, если запись существует, иначе - FALSE
     */
    public function exists($id)
    {
        return parent::record_exists(TABLE_PUBLICATIONS, $id);
    }

    /**
     * Получить полные данные о записи
     * @param int $id идентификатор записи
     * @return mixed запись или FALSE, если запись не существует
     */
    public function get_record_for_admin_edit_view($id)
    {
        return parent::get(TABLE_PUBLICATIONS, $id);
    }

    /**
     * Обновить запись в БД, параметры которой переданы через POST-запросы
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @return boolean TRUE, если запись была успешно обновлена, иначе - FALSE
     */
    public function edit_from_post()
    {
        $publication = $this->get_from_post();
        return parent::edit(TABLE_PUBLICATIONS, $publication);
    }

    /**
     * Удалить запись из БД
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @param int $id идентификатор удаляемой записи
     * @return boolean TRUE, если запись существовала и была успешно удалена, иначе - FALSE
     */
    public function delete($id)
    {
        // Удаление файлов публикации
        $this->load->model(MODEL_FILE);
        $result = parent::get_fields(
                TABLE_PUBLICATIONS,
                array('fulltext_ru_file', 'fulltext_en_file', 'abstract_ru_file', 'abstract_en_file'),
                NULL,
                NULL,
                $id);
        $this->{MODEL_FILE}->delete_file($result->fulltext_ru_file);
        $this->{MODEL_FILE}->delete_file($result->fulltext_en_file);
        $this->{MODEL_FILE}->delete_file($result->abstract_ru_file);
        $this->{MODEL_FILE}->delete_file($result->abstract_en_file);
        // Удаление авторов публикации
        parent::delete_record(TABLE_PUBLICATION_AUTHORS, $id, 'publicationid');
        // Удаление записи
        return parent::delete_record(TABLE_PUBLICATIONS, $id);
    }

    /**
     * Получить путь к файлу публикации
     * @param int $id идентификатор публикации
     * @param string $field тип файла / поле таблицы, содержащее идентификатор файла
     * @return mixed путь или NULL
     */
    public function get_file_path($id, $field)
    {
        $result = parent::get_fields(
                TABLE_PUBLICATIONS,
                array($field),
                NULL,
                NULL,
                $id);
        $this->load->model(MODEL_FILE);
        if ($result)
            $result->$field = $this->{MODEL_FILE}->get_file_path($result->$field);
        return $result->$field;
    }

    /**
     * Получить все года, в которых есть публикации на указанном языке
     * @return array упорядоченный по убыванию массив лет
     */
    function get_years()
    {
        $records = $this->db
                    ->select('year')
                    ->distinct()
                    ->from(TABLE_PUBLICATIONS)
                    ->where('name_'.lang().' IS NOT NULL AND name_'.lang().' != ""')
                    ->order_by('year DESC')
                    ->get()
                    ->result();
        $years = array();
        foreach ($records as $record)
        {
            $years[] = $record->year;
        }
        return $years;
    }

    /**
     * Получить все публикации в указанный год
     * @param int $year год
     * @return array публикации
     */
    function get_by_year($year)
    {
        $result = parent::get_fields(
                TABLE_PUBLICATIONS,
                array(
                    'id',
                    'name_'.lang().' as name',
                    'fulltext_ru',
                    'fulltext_en',
                    'abstract_ru',
                    'abstract_en',
                    'info_'.lang().' as info'
                ),
                'id DESC',
                'name_'.lang().' IS NOT NULL AND name_'.lang().' != "" AND year = ' . $year
                );
        foreach($result as $record)
        {
            $record->authors = $this->get_authors($record->id);
            $record->year = $year;
            $record->fulltext_ru_file = $this->get_file_path($record->id, 'fulltext_ru_file');
            $record->fulltext_en_file = $this->get_file_path($record->id, 'fulltext_en_file');
            $record->abstract_ru_file = $this->get_file_path($record->id, 'abstract_ru_file');
            $record->abstract_en_file = $this->get_file_path($record->id, 'abstract_en_file');
        }
        return $result;
    }
}

/* End of file publication_model.php */
/* Location: ./application/models/publication_model.php */