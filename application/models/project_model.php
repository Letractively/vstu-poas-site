<?php
/**
 * @class Project_model
 * Модель проектов. 
 */

class Project_model extends CI_Model {
	var $message = '';
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
			'image' => $this->input->post('project_image')
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
	
	function edit_from_post() 
	{
		$data = array();
		$project = array(
			'name_ru' => $this->input->post('project_name_ru'),
			'name_en' => $this->input->post('project_name_en'),
			'description_ru' => $this->input->post('project_description_ru'),
			'description_en' => $this->input->post('project_description_en'),
			'url' => $this->input->post('project_url'),
			'image' => $this->input->post('project_image'),
			'id' => $this->input->post('project_id')
		);
		// Не будем хранить пустоты зазря
		if($project['name_en'] === '') { $project['name_en'] = null; }
		if($project['description_en'] === '') { $project['description_en'] = null; }
		
		$this->db->where('id', $project['id']);
		return $this->db->update(TABLE_PROJECTS, $project);
	}
	
	/**
	 * Получить запись о проекте из таблицы базы данных
	 * 
	 * @param $id - id проекта
	 * @return массив всех записей, запись с указанным id или FALSE
	*/
	function get_project($id) {
		
		$project = $this->db->select('*')->get_where(TABLE_PROJECTS, array('id' => $id), 1)->result();
		if (!$project)
		{
			return NULL;
		}
		return $project[0];
	}
	
	/**
	 * Удалить проект из базы 
	 *
	 * @param $id - id проекта
	 * @return TRUE, если проект удален, иначе FALSE
	*/
	function delete ($id)
	{
		if( ! $this->db->delete(TABLE_PROJECTS, array('id' => $id)))
		{
			$this->message = 'Произошла ошибка, проект удалить не удалось.';
			return FALSE;
		} 
		else 
		{
			$this->message = 'Проект удален успешно (id был равен ' . $id . ').';
		}
		return TRUE;
	}
}