<?php
/**
 * @class Project_model
 * Модель проектов. 
 */

class Project_model extends CI_Model {
	/**
	 * Получить основную информацию о всех проектах (или об одном проекте)
	 * 
	 * Получить только name_ru и id проектов
	 * @param $id - id проекта, необязательный параметр
	 * @return массив всех записей, запись с указанным id или FALSE
	*/
	function get_short($id = null)
	{
		if( isset($id) )
		{
			$users = $this->db->select('id, name_ru')->get_where(TABLE_PROJECTS, array('id' => $id), 1)->result();
			if( ! $users)
			{
				return FALSE;
			}
			return $users[0];
		}
		
		return $this->db->select('id, name_ru')->order_by('name_ru')->get(TABLE_PROJECTS)->result();
	}
	
	/**
	 * Добавить новый проект, используя данные, отправленные методом POST
	 * @return int id - идентификатор добавленого проекта | FALSE
	 */
	function add_from_post() {
		$data = array();
		$project = array(
			'name_ru' => $this->input->post('project_name_ru'),
			'name_en' => $this->input->post('project_name_en'),
			'description_ru' => $this->input->post('project_description_ru'),
			'description_en' => $this->input->post('project_description_en'),
			'url' => $this->input->post('project_url'),
			'image' => $this->input->post('image')
		);
		// Не будем хранить пустоты зазря
		if($project['name_en'] === '') { $project['name_en'] = null; }
		if($project['description_en'] === '') { $project['description_en'] = null; }
		if ($project['image'] == 0 ) {$project['image'] = null; }
		if($this->db->insert(TABLE_PROJECTS, $project))
		{
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
	}
}