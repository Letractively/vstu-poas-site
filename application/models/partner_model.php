<?php
/**
 * Модель партнера
 */
require_once('super.php');
class Partner_model extends Super{

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
                ->get(TABLE_PARTNERS, $amount_on_page, ($page - 1) * $amount_on_page)
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
        $flag = $this->form_validation->run('admin/partners');
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
            'name_ru'  => 'partner_name_ru',
            'name_en'  => 'partner_name_en',
            'short_ru' => 'partner_short_ru',
            'short_en' => 'partner_short_en',
            'full_ru'  => 'partner_full_ru',
            'full_en'  => 'partner_full_en',
            'url'      => 'partner_url'
        );
        $nulled_fields = array(
            'name_en'  => '',
            'short_en' => '',
            'full_ru'  => '',
            'full_en'  => '',
            'url'      => ''
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
        return parent::add(TABLE_PARTNERS, $this->get_from_post());
    }

    /**
     * Проверить, существует ли запись в БД
     * @param int $id идентифиактор искомой записи
     * @return boolean TRUE, если запись существует, иначе - FALSE
     */
    public function exists($id)
    {
        return parent::record_exists(TABLE_PARTNERS, $id);
    }

    /**
     * Получить полные данные о записи
     * @param int $id идентификатор записи
     * @return mixed запись или FALSE, если запись не существует
     */
    public function get_record_for_admin_edit_view($id)
    {
        return parent::get(TABLE_PARTNERS, $id);
    }

    /**
     * Обновить запись в БД, параметры которой переданы через POST-запросы
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @return boolean TRUE, если запись была успешно обновлена, иначе - FALSE
     */
    public function edit_from_post()
    {
        $partner = $this->get_from_post();
        return parent::edit(TABLE_PARTNERS, $partner);
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
                TABLE_PARTNERS,
                array('image'),
                NULL,
                NULL,
                $id);
        $this->{MODEL_FILE}->delete_file($result->image);
        return parent::delete_record(TABLE_PARTNERS, $id);
    }

    /**
     * Получить основные данные о партнерах для списка партнеров на сайте
     * @return array список записей
     */
    public function get_cards()
    {
        $result = parent::get_fields(
                TABLE_PARTNERS,
                array(
                    'id',
                    'name_'.lang().' as name',
                    'short_'.lang().' as short',
                    'url',
                    'image'),
                'name_'.lang(),
                'name_'.lang().' IS NOT NULL AND short_'.lang().' IS NOT NULL'
                );
        $this->load->model(MODEL_FILE);
        if (is_array($result)) {
            foreach($result as $record){
                $record->image = $this->{MODEL_FILE}->get_file_path($record->image);
            }
        }
        return $result;
    }

    /**
     * Получить данные о партнере для страницы партнера на сайте
     * @param int $id идентификатор партнера
     * @return object объект записи
     */
    public function get_card($id)
    {
        $result = parent::get_fields(
                TABLE_PARTNERS,
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
                TABLE_PARTNERS,
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

    /**
     * Получить путь к изображению партнера
     * @param int $id идентификатор партнера
     * @return mixed путь или NULL
     */
    public function get_image_path($id)
    {
        $result = parent::get_fields(
                TABLE_PARTNERS,
                array('image'),
                NULL,
                NULL,
                $id);
        $this->load->model(MODEL_FILE);
        if ($result)
            $result->image = $this->{MODEL_FILE}->get_file_path($result->image);
        return $result->image;
    }
}

/* End of file partner_model.php */
/* Location: ./application/models/partner_model.php */