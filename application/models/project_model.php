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
        $select1 = 'description_' . lang() . ' as description, url, image';
        $select2 = 'description_ru as description, url, image';
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
        return $project;
    }
    
    function get_view_extra() {
        $extra = null;
        $extra->users = $this->db
                                ->select('id,name,surname,patronymic')
                                ->from(TABLE_USERS)
                                ->order_by('surname,name,patronymic')
                                ->get()
                                ->result();
        return $extra;
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
            'image' => 'project_image',
            'members' => 'project_members'
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
        $this->_update_connected_users(TABLE_PROJECT_MEMBERS, 
                'projectid', 
                $id, 
                $members);
    }
    /**
     * Добавить проект, получаемый через POST-запрос
     * @return int id - идентификатор добавленной записи | FALSE
     */
    function add_from_post()
    {
        $project = $this->get_from_post();
        unset($project->image);
        unset($project->members);
        if ($id = $this->_add(TABLE_PROJECTS, $project))
        {
            $this->update_project_members($id, $this->input->post('project_members'));
            $this->upload_file($id);
        }
        return $id;
    }
    
    function upload_file($id) {
        $config['upload_path'] = './uploads/projects/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload('project_image'))
		{
			$error = array('error' => $this->upload->display_errors());
			//@todo
            $this->message .= '. При загрузке файла произошла ошибка';
		}	
		else
		{
			$upload_data = $this->upload->data();
            
            $this->db->where('id', $id);
            $segments = explode('/',$upload_data['full_path']);
            $segments = array_reverse($segments);
            $record->image = $segments[2].'/'.$segments[1].'/'.$segments[0];
            $response = $this->db->update(TABLE_PROJECTS, $record);
		}
    }
    /**
	 * Получить информацию о проекте из данных, полученных методом POST
	 * @return объект, содержащий собранную информацию о проекте
	 */
    function edit_from_post() {
        $project = $this->get_from_post();
        unset($project->image);
        unset($project->members);
        $this->update_project_members($project->id, $this->input->post('project_members'));
        $this->upload_file($project->id);
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
    
    function exists($id)
    {
        return $this->_record_exists(TABLE_PROJECTS, $id);
    }
}
?>