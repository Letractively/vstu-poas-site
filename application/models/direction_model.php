<?php
/**
 * @class Direction_model
 * Модель направлений.
 */

require_once('super_model.php');
class Direction_model extends Super_model 
{
    /**
     * Получить краткую информацию о направлении
     * @param int $id идентификатор направления
     * @return направление
     */
    function get_short($id = null)
    {
        return $this->_get_short(TABLE_DIRECTIONS, 
                                 null, 
                                 'name_' . lang() . ', name_ru, id', 
                                 $id);
    }
    
    /**
     * Получить информацию о направлении для представления
     * @param int $id идентификатор направления
     * @return направление 
     */
    function get_detailed($id) {
        $select1 = 'description_' . lang() . ' as description';
        $select2 = 'description_ru as description';
        return $this->_get_detailed($id, TABLE_DIRECTIONS, $select1, $select2);
    }
    
    /**
     * Получить полную информацию о направлении
     * @param int $id идентификатор направления
     * @return направление 
     */
    function get_direction($id)
    {
        return $this->_get_record($id, TABLE_DIRECTIONS);
    }
    
    /**
     * Получить информацию о направлении из POST-запроса
     * @return направление
     */
    function get_from_post() 
    {
        $fields = array(
            'name_ru' => 'direction_name_ru',
            'name_en' => 'direction_name_en',
            'description_ru' => 'direction_description_ru',
            'description_en' => 'direction_description_en'
        );
        $nulled_fields = array(            
            'name_en' => '',
            'description_ru' => '',
            'description_en' => ''
        );
        return $this->_get_from_post('direction', $fields, $nulled_fields);
    }
    
    /**
     * Добавить направление, получаемое через POST-запрос
     * @return int id - идентификатор добавленной записи | FALSE
     */
    function add_from_post()
    {        
        return $this->_add(TABLE_DIRECTIONS, $this->get_from_post());
    }
    
    /**
	 * Получить информацию о направлени из данных, полученных методом POST
	 * @return объект, содержащий собранную информацию о направлении
	 */
    function edit_from_post() {
        return $this->_edit(TABLE_DIRECTIONS, $this->get_from_post());
    }
    
    /**
     * Удалить направление из базы данных
     * @param int $id идентификатор направления
     * @return TRUE, если направление удалено, иначе FALSE 
     */
    function delete($id)
    {
        return $this->_delete(TABLE_DIRECTIONS, $id);
    }
    
    /**
	 * Получить информацию обо всех участниках направления
	 * @param int $id идентификатор направления
	 * @return массив пользователей
	 */
	function get_members($id)
	{
		$this->db
				->select(TABLE_USERS . '.id, first_name, last_name, ishead')
				->from(TABLE_DIRECTION_MEMBERS)
				->join(TABLE_USERS, TABLE_USERS.'.id = ' . TABLE_DIRECTION_MEMBERS . '.userid')
				->where('directionid = ' . $id);
				return $this->db->get()->result();
	}
    
    /**
     * Проверить название направления (заполнено ли)
     * @return object Объект ошибок
     */
    function get_errors()
    {
        // Тут проще проверить все самому, а не использовать $this->_get_errors($rus, $eng);
        $errors = null;
        if ($this->input->post('direction_name_ru') === '')
            $errors->nameruforgotten = true;
        if (    $this->input->post('direction_description_en') !== '' &&
                $this->input->post('direction_name_en') === '')
        {
            $errors->nameenforgotten = true;
        }
        
        return $errors;
    }
}
?>