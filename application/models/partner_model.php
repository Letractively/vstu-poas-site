<?php
require_once('super_model.php');
class Partner_model extends Super_model{
    /**
     * Получить краткую информацию о партнере
     * @param int $id идентификатор партнера
     * @return партнер
     */
    function get_short($id = null)
    {
        return $this->_get_short(TABLE_PARTNERS,
                                 'url, short_' . lang() . ' as short,',
                                 'name_' . lang() . ', name_ru, id',
                                 $id);
    }

    /**
     * Получить информацию о партнере для представления
     * @param int $id идентификатор партнера
     * @return партнер
     */
    function get_detailed($id) {
        $select1 = 'short_' . lang() . ' as short, full_' . lang() . ' as full, url';
        $select2 = 'short_ru as short, full_ru as full, url';
        return $this->_get_detailed($id, TABLE_PARTNERS, $select1, $select2);
    }

    /**
     * Получить полную информацию о партнере
     * @param int $id идентификатор партнера
     * @return партнер
     */
    function get_partner($id)
    {
        $record = $this->db
                            ->select('*')
                            ->from(TABLE_PARTNERS)
                            ->where(TABLE_PARTNERS.'.id', $id)
                            ->get()
                            ->result();
		if (!$record)
		{
			return NULL;
		}
		return $record[0];
    }

    /**
     * Получить информацию о партнере из POST-запроса
     * @return партнер
     */
    function get_from_post()
    {
        $fields = array(
            'name_ru' => 'partner_name_ru',
            'name_en' => 'partner_name_en',
            'short_ru' => 'partner_short_ru',
            'short_en' => 'partner_short_en',
            'full_ru' => 'partner_full_ru',
            'full_en' => 'partner_full_en',
            'url' => 'partner_url'
        );
        $nulled_fields = array(
            'name_en' => '',
            'short_en' => '',
            'full_ru' => '',
            'full_en' => '',
            'url' => ''
        );
        return $this->_get_from_post('partner', $fields, $nulled_fields);
    }

    /**
     * Добавить партнера, получаемого через POST-запрос
     * @return int id - идентификатор добавленной записи | FALSE
     */
    function add_from_post()
    {
        $partner = $this->get_from_post();
        unset($partner->image_name);
        return $this->_add(TABLE_PARTNERS, $partner);
    }

    /**
	 * Получить информацию о партнере из данных, полученных методом POST
	 * @return объект, содержащий собранную информацию о партнере
	 */
    function edit_from_post() {
        $partner = $this->get_from_post();
        unset($partner->image_name);
        return $this->_edit(TABLE_PARTNERS, $partner);
    }

    /**
     * Удалить партнера из базы данных
     * @param int $id идентификатор партнера
     * @return TRUE, если партнер удален, иначе FALSE
     */
    function delete($id)
    {
        $files = $this->db->select('image')->get_where(TABLE_PARTNERS, array('id' => $id))->result();

        if (count($files) == 1)
        {
            $this->load->model(MODEL_FILE);
            $this->{MODEL_FILE}->delete_file($files[0]->image);
        }
        return $this->_delete(TABLE_PARTNERS, $id);
    }

    /**
	 * Проверить данные, введенные на форме edit_partner_view на корректность
	 * @return массив с ошибками
	 */
	function get_errors() {
        $rus = array(
            'partner_name_ru' => 'nameruforgotten',
            'partner_short_ru' => 'shortruforgotten',
            'partner_full_ru' => 'fullruforgotten'
        );
        $eng = array(
            'partner_name_en' => 'nameenforgotten',
            'partner_short_en' => 'shortenforgotten',
            'partner_full_en' => 'fullenforgotten'
        );
        return $this->_get_errors($rus, $eng);
	}

    function exists($id)
    {
        return $this->_record_exists(TABLE_PARTNERS, $id);
    }

    /**
     * Получить путь к изображению проекта
     * @param $id id проекта
     * @return путь к файлу или null
     */
    function get_image($id)
    {
        $partner = $this->get_partner($id);
        $this->load->model(MODEL_FILE);
        return $this->{MODEL_FILE}->get_file_path($partner->image);
    }

    function get_cards()
    {
        $result = $this->_get_short(TABLE_PARTNERS,
                                 'short_'.lang().' as short, url, image',
                                 'name_' . lang(),
                                 null);
        $this->load->model(MODEL_FILE);
        if (is_array($result)) {
            foreach($result as $record){
                $record->image = $this->{MODEL_FILE}->get_file_path($record->image);
            }
        }
        return $result;
    }

    function get_card($id)
    {
        $result = $this->_get_short(TABLE_PARTNERS,
                                 'short_'.lang().' as short,full_'.lang().' as full, url, image',
                                 'name_' . lang(),
                                 $id);
        $this->load->model(MODEL_FILE);
        if ($result)
            $result->image = $this->{MODEL_FILE}->get_file_path($result->image);
        return $result;
    }
}
