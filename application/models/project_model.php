<?php
/**
 * @class Project_model
 * Модель проектов. 
 */

require_once('super_model.php');
class Project_model extends Super_model 
{
    /**
     * Получить краткую информацию о проекте
     * @param int $id идентификатор проекта
     * @return проект
     */
    function get_short($id = null)
    {
        $result = $this->_get_short(TABLE_PROJECTS, 
                                 'url', 
                                 'name_' . lang() . ',name_ru, id', 
                                 $id);
        if (is_array($result)) {
            foreach($result as $record){
                $this->db->from(TABLE_PROJECT_MEMBERS)->where('projectid', $record->id);
                $record->memberscount = $this->db->count_all_results();
            }
        }
        return $result; 
    }
    
    /**
     * Получить информацию о проекте для представления
     * @param int $id идентификатор проекта
     * @return проект
     */
    function get_detailed($id) {
        $select1 = 'description_' . lang() . ' as description, url';
        $select2 = 'description_ru as description, url';
        return $this->_get_detailed($id, TABLE_PROJECTS, $select1, $select2);
    }
    
    /**
     * Получить полную информацию о проекте
     * @param int $id идентификатор проекта
     * @return проект
     */
    function get_project($id)
    {
        $project = $this->_get_record($id, TABLE_PROJECTS);
        $project->members = $this->get_members($id);
        $project->users = $this->db
                                    ->select('id,name,surname,patronymic')
                                    ->from(TABLE_USERS)
                                    ->order_by('surname')
                                    ->get()
                                    ->result();
        return $project;
    }
    
    /**
     * Получить информацию о проекте из POST-запроса
     * @return проект
     */
    function get_from_post() 
    {
        $fields = array(
            'name_ru' => 'project_name_ru',
            'name_en' => 'project_name_en',
            'description_ru' => 'project_description_ru',
            'description_en' => 'project_description_en',
            'url' => 'project_url',
            'image' => 'project_image'
        );
        $nulled_fields = array(            
            'name_en' => '',
            'description_en' => '',
            'url' => '',
            'image' => 0
        );
        return $this->_get_from_post('project', $fields, $nulled_fields);
    }
    
    /**
     * Обновить список участников проекта
     * 
     * @param type $id идентификатор проекта
     * @param $members массив идентификаторов участников проекта
     */
    function update_project_members($id, $members)
    {
        // Если никого вообще нет - удалить по id проекта
        if (!$members) 
        {
            $this->db->delete(TABLE_PROJECT_MEMBERS, array('projectid' => $id));
            return;
        }
        $records = $this->db
                                ->select('userid')
                                ->get_where(TABLE_PROJECT_MEMBERS, array('projectid' => $id))
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
                    $this->db->delete(TABLE_PROJECT_MEMBERS, array(
                        'userid' => $old_member,
                        'projectid' => $id));
                    unset($old_member);
                }
            }
        // добавить в базу новых участников проекта
        if ($members)
            foreach($members as $member)
            {
                // Если нового нет среди старых
                if (array_search($member, $old_members) === FALSE)
                {
                    $record = new stdClass();
                    $record->projectid = $id;
                    $record->userid = $member;
                    $this->db->insert(TABLE_PROJECT_MEMBERS, $record);
                    unset($member);
                }
            }
    }
    /**
     * Добавить проект, получаемый через POST-запрос
     * @return int id - идентификатор добавленной записи | FALSE
     */
    function add_from_post()
    {
        $project = $this->get_from_post();
        unset($project->image);
        $record = $this->_add(TABLE_PROJECTS, $project);
        $this->update_project_members($record->id, $this->input->post('project_members'));
        return $record;
    }
    
    /**
	 * Получить информацию о проекте из данных, полученных методом POST
	 * @return объект, содержащий собранную информацию о проекте
	 */
    function edit_from_post() {
        $project = $this->get_from_post();
        unset($project->image);
        $this->update_project_members($project->id, $this->input->post('project_members'));
        return $this->_edit(TABLE_PROJECTS, $project);
    }
    
    /**
     * Удалить проект из базы данных
     * Так же удаляет записи из таблицы "участники проекта"
     * @param int $id идентификатор проекта
     * @return TRUE, если проект удален, иначе FALSE 
     */
    function delete($id)
    {
        $result = $this->_delete(TABLE_PROJECTS, $id);
        $message = $this->message;
        $cascade = $this->_delete(TABLE_PROJECT_MEMBERS, $id, 'projectid');
        $this->message = $message;
        return $cascade && $result;
    }
    
    /**
	 * Получить информацию обо всех участниках проекта
	 * @param int $id идентификатор проекта
	 * @return массив пользователей
	 */
	function get_members($id)
	{
		$this->db
				->select(TABLE_USERS . '.id, name, surname, patronymic')
				->from(TABLE_PROJECT_MEMBERS)
				->join(TABLE_USERS, TABLE_USERS.'.id = ' . TABLE_PROJECT_MEMBERS . '.userid')
				->where('projectid = ' . $id);
				return $this->db->get()->result();
	}
    
    /**
     * Проверить название и описание проекта (заполнены ли)
     * @return object Объект ошибок
     */
    function get_errors()
    {
        $rus = array(
            'project_name_ru' => 'nameruforgotten',
            'project_description_ru' => 'descriptionruforgotten',
        );
        $eng = array(
            'project_name_en' => 'nameenforgotten',
            'project_description_en' => 'descriptionenforgotten',
        );
        return $this->_get_errors($rus, $eng);
    }
}
?>