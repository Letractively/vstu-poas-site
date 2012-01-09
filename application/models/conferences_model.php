<?php
require_once('super.php');

class Conferences_model extends Super
{
    /**
     * Получить список записей для панели администратора
     * @param int $page страница
     * @param int $amount_on_page количество записей на странице
     * @return array массив записей
     */
    public function get_records_for_admin_view($page = 1, $amount_on_page = 20)
    {
        $records = $this->db
                ->select('id, name_ru as name, begin, end')
                ->get(TABLE_CONFERENCES, $amount_on_page, ($page - 1) * $amount_on_page)
                ->result();
        return $records;
    }

    /**
     * Провести валидацию данных в POST-запросе на странице редактирования
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @return boolean TRUE, если нет ошибок валидации, иначе - FALSE
     */
    public function validate()
    {
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $flag = $this->form_validation->run('admin/conferences');
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
            'id'        => 'conference_id',
            'name_ru'   => 'conference_name_ru',
            'name_en'   => 'conference_name_en',
            'info_ru'   => 'conference_info_ru',
            'info_en'   => 'conference_info_en',
            'url'       => 'conference_url',
            'begin'     => 'conference_begin',
            'end'       => 'conference_end'
        );
        $nulled_fields = array(
            'id'        => '',
            'name_ru'   => '',
            'name_en'   => '',
            'info_ru'   => '',
            'info_en'   => '',
            'url'       => '',
            'begin'     => '',
            'end'       => ''
        );
        return parent::create_record_object('partner', $fields, $nulled_fields);
    }

    /**
     * Добавить запись в БД, параметры которой переданы через POST-запросы
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @return boolean TRUE, если запись была успешно добавлена, иначе - FALSE
     */
    public function add_from_post()
    {
        return parent::add(TABLE_CONFERENCES, $this->get_from_post());
    }

    /**
     * Проверить, существует ли запись в БД
     * @param int $id идентифиактор искомой записи
     * @return boolean TRUE, если запись существует, иначе - FALSE
     */
    public function exists($id)
    {
        return parent::record_exists(TABLE_CONFERENCES, $id);
    }

    /**
     * Получить полные данные о записи
     * @param int $id идентификатор записи
     * @return mixed запись или FALSE, если запись не существует
     */
    public function get_record_for_admin_edit_view($id)
    {
        return parent::get(TABLE_CONFERENCES, $id);
    }

    /**
     * Обновить запись в БД, параметры которой переданы через POST-запросы
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @return boolean TRUE, если запись была успешно обновлена, иначе - FALSE
     */
    public function edit_from_post()
    {
        $partner = $this->get_from_post();
        return parent::edit(TABLE_CONFERENCES, $partner);
    }

    /**
     * Удалить запись из БД
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @param int $id идентификатор удаляемой записи
     * @return boolean TRUE, если запись существовала и была успешно удалена, иначе - FALSE
     */
    public function delete($id)
    {
        return parent::delete_record(TABLE_CONFERENCES, $id);
    }

    /**
     * Получить основные данные о конференциях для страницы конференций
     * @return array список записей
     */
    public function get_cards()
    {
        $result = parent::get_fields(
                TABLE_CONFERENCES,
                array(
                    'id',
                    'name_'.lang().' as name',
                    'url',
                    'begin',
                    'end'
                ),
                'begin DESC, end',
                'name_'.lang().' IS NOT NULL'
                );
        return $result;
    }

    public function get_card($id)
    {
        $result = parent::get_fields(
                TABLE_CONFERENCES,
                array(
                    'id',
                    'name_'.lang().' as name',
                    'info_'.lang().' as info',
                    'url',
                    'begin',
                    'end'
                ),
                NULL,
                NULL,
                $id);
        if ($result->name == NULL)
        {
            $result = parent::get_fields(
                TABLE_CONFERENCES,
                array(
                    'id',
                    'name_ru as name',
                    'info_ru as info',
                    'url',
                    'begin',
                    'end'
                ),
                NULL,
                NULL,
                $id);
        }
        return $result;
    }

    /**
     * Получить определенное количество последних конференций
     * @param int $count требуемое число конференций
     * @return array конференции
     */
    public function get_last($count)
    {
        $result = $this->db
                ->select(array(
                    'id',
                    'name_'.lang().' as name',
                    'begin'
                ))
                ->from(TABLE_CONFERENCES)
                ->where('name_'.lang().' IS NOT NULL')
                ->order_by('begin DESC, end')
                ->limit($count)
                ->get()
                ->result();
        
        return $result;
    }
}