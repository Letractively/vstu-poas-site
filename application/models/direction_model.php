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
        return $direction;
    }
    
    function get_view_extra() {
        $extra = null;
        $extra->users = $this->db
                                ->select(TABLE_USERS . '.id, name_'.lang().' as name, surname_'.lang().' as surname, patronymic_'.lang().' as patronymic')
                                ->from(TABLE_USERS)
                                ->order_by('surname,name,patronymic')
                                ->get()
                                ->result();
        return $extra;
    }
    
    /**
     * Обновить список участников направления
     * 
     * @param type $id идентификатор направления
     * @param $members массив идентификаторов участников направления
     */
    function update_direction_members($id, $members, $ishead)
    {
        // Метод родителя не пойдет, здесь два типа участников
        
        // Если никого вообще нет - удалить по id проекта
        if (!$members) 
        {
            $this->db->delete(TABLE_DIRECTION_MEMBERS, 
                    array(  'directionid' => $id,
                            'ishead' => $ishead));
            return;
        }
        $records = $this->db
                                ->select('userid')
                                ->get_where(TABLE_DIRECTION_MEMBERS, 
                                            array('directionid' => $id,
                                                'ishead' => $ishead))
                                ->result();
        $old_members = array();
        foreach ($records as $record)
        {
            $old_members[] = $record->userid;
        }
        // удалить устаревшие записи (тех, кто был записан в проект, а теперь
        // его в списке нет
            foreach($old_members as $old_member) 
            {
                // Если старого нет среди новых - удалить его
                if (array_search($old_member, $members) === FALSE)
                {
                    $this->db->delete(TABLE_DIRECTION_MEMBERS, array(
                        'userid' => $old_member,
                        'directionid' => $id,
                        'ishead' => $ishead));
                    unset($old_member);
                }
            }
        // добавить в базу новых участников
        if ($members)
            foreach($members as $member)
            {
                // Если нового нет среди старых
                if (array_search($member, $old_members) === FALSE)
                {
                    $record = new stdClass();
                    $record->directionid = $id;
                    $record->userid = $member;
                    $record->ishead = $ishead;
                    $this->db->insert(TABLE_DIRECTION_MEMBERS, $record);
                    unset($member);
                }
            }
    }
    
    /**
     * Удалить записи о участниках направления из таблицы участников,
     * если они одновременно руководители этого направления
     * @param type $directionid идентификатор направления
     * @param type $heads идентификаторы руководителей направления
     * @param type $members идентификаторы участников направления
     */
    function clean_members_dup($directionid, $heads, $members)
    {
        if(is_array($heads) && is_array($members))
        {
            foreach (array_intersect($heads, $members) as $userid)
            {
                $where = array('directionid' => $directionid,
                    'userid' => $userid,
                    'ishead' => FALSE);
                $this->db->delete(TABLE_DIRECTION_MEMBERS, $where);
            }
        }
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
            'description_en' => 'direction_description_en',
            'heads' => 'direction_heads',
            'not_heads' => 'direction_members'
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
        $direction = $this->get_from_post();
        unset($direction->heads);
        unset($direction->not_heads);
        if($id = $this->_add(TABLE_DIRECTIONS, $direction))
        {
            $this->update_direction_members($id, $this->input->post('direction_members'), FALSE);
            $this->update_direction_members($id, $this->input->post('direction_heads'), TRUE);
            $this->clean_members_dup($id,
                    $this->input->post('direction_members'),
                    $this->input->post('direction_heads'));
        }
        return $id;
    }
    
    /**
	 * Получить информацию о направлени из данных, полученных методом POST
	 * @return объект, содержащий собранную информацию о направлении
	 */
    function edit_from_post() {
        $direction = $this->get_from_post();
        $this->update_direction_members($direction->id, $this->input->post('direction_members'), FALSE);
        $this->update_direction_members($direction->id, $this->input->post('direction_heads'), TRUE);
        $this->clean_members_dup($direction->id,
                $this->input->post('direction_members'),
                $this->input->post('direction_heads'));
        unset($direction->heads);
        unset($direction->not_heads);
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
				->select(TABLE_USERS . '.id, name_'.lang().' as name, surname_'.lang().' as surname, patronymic_'.lang().' as patronymic, ishead')
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
    
    function exists($id)
    {
        return $this->_record_exists(TABLE_DIRECTIONS, $id);
    }
}
?>