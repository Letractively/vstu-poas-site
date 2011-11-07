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
        $result = $this->_get_short(TABLE_DIRECTIONS, 
                                 null, 
                                 'name_' . lang() . ', name_ru, id', 
                                 $id);
        if (is_array($result)) {
            foreach($result as $record){
                $this->db->from(TABLE_DIRECTION_MEMBERS)->where('directionid', $record->id);
                $record->memberscount = $this->db->count_all_results();
            }
        }
        return $result; 
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
        $direction = $this->_get_record($id, TABLE_DIRECTIONS);
        $direction->members = $this->get_members($id);
        $direction->users = $this->db
                                    ->select('id,name,surname,patronymic')
                                    ->from(TABLE_USERS)
                                    ->order_by('surname,name,patronymic')
                                    ->get()
                                    ->result();
        return $direction;
    }
    
    /**
     * Обновить список участников направления
     * 
     * @param type $id идентификатор направления
     * @param $members массив идентификаторов участников направления
     */
    function update_project_members($id, $members)
    {
        $this->_update_connected_users(TABLE_DIRECTION_MEMBERS, 
                'directionid', 
                $id, 
                $members);
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
        $direction =  $this->_add(TABLE_DIRECTIONS, $this->get_from_post());
        $this->update_project_members($direction->id, $this->input->post('direction_members'));
        return $direction;
    }
    
    /**
	 * Получить информацию о направлени из данных, полученных методом POST
	 * @return объект, содержащий собранную информацию о направлении
	 */
    function edit_from_post() {
        $direction = $this->get_from_post();
        $this->update_project_members($direction->id, $this->input->post('direction_members'));
        return $this->_edit(TABLE_DIRECTIONS, $direction);
    }
    
    /**
     * Удалить направление из базы данных
     * @param int $id идентификатор направления
     * @return TRUE, если направление удалено, иначе FALSE 
     */
    function delete($id)
    {
        $result = $this->_delete(TABLE_DIRECTIONS, $id);
        $message = $this->message;
        $cascade = $this->_delete(TABLE_DIRECTION_MEMBERS, $id, 'directionid');
        $this->message = $message;
        return $cascade && $result;
    }
    
    /**
	 * Получить информацию обо всех участниках направления
	 * @param int $id идентификатор направления
	 * @return массив пользователей
	 */
	function get_members($id)
	{
		$this->db
				->select(TABLE_USERS . '.id, name, surname, patronymic, ishead')
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