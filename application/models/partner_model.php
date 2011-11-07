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
        return $this->_get_short(TABLE_PARTNERS, 'url, short_' . lang(), $id);
    }
    
    /**
     * Получить информацию о партнере для представления
     * @param int $id идентификатор партнера
     * @return партнер
     */
    function get_detailed($id) {
        $select1 = 'short_' . lang() . ' as short, full_' . lang() . 'as full, url';
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
        return $this->_get_record($id, TABLE_PARTNERS);
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
            'url' => 'partner_url',
            'image' => 'partner_image'
        );
        $nulled_fields = array(            
            'name_en' => '',
            'short_en' => '',
            'full_ru' => '',
            'full_en' => '',
            'url' => '',
            'image' => 0
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
        unset($partner->image);
        return $this->_add(TABLE_PARTNERS, $partner);
    }
    
    /**
	 * Получить информацию о партнере из данных, полученных методом POST
	 * @return объект, содержащий собранную информацию о партнере
	 */
    function edit_from_post() {
        $partner = $this->get_from_post();
        unset($partner->image);
        return $this->_edit(TABLE_PARTNERS, $partner);
    }
    
    /**
     * Удалить партнера из базы данных
     * @param int $id идентификатор партнера
     * @return TRUE, если партнер удален, иначе FALSE 
     */
    function delete($id)
    {
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
}
