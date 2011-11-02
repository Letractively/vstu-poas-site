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
	function get_short ($id = null)
	{
		if (isset($id))
		{
			$projects = $this->db->select('id, name_ru')->get_where(TABLE_PROJECTS, array('id' => $id), 1)->result();
			if( !$projects)
			{
				return FALSE;
			}
			return $projects[0];
		}
		
		return $this->db->select('id, name_ru')->order_by('name_ru')->get(TABLE_PROJECTS)->result();
	}
	function get_detailed($id = null) 
	{
		if (isset($id))
		{
			$projects = $this->db->select('id,'. 
										  'name_' . lang() . ' as name,' .
										  'description_' . lang() . ' as description,' .
										  'url'
										  )->get_where(TABLE_PROJECTS, array('id' => $id), 1)->result();
			if( !$projects)
			{
				return FALSE;
			}
			return $projects[0];
		}
		
		return $this->db->select('id,'. 
								 'name_' . lang() . ' as name,' .
								 'description_' . lang() . ' as description,' .
								 'url'
								)->order_by('name_ru')->get(TABLE_PROJECTS)->result();
	}
	/**
	 * Получить информацию о проекте из данных, полученных методом POST
	 * return Project - объект, содержащий собранную информацию о проекте
	*/
	function get_from_post() 
	{
		$project = new stdClass();
		$project->name_ru = 		$this->input->post('project_name_ru');
		$project->name_en = 		$this->input->post('project_name_en');
		$project->description_ru = 	$this->input->post('project_description_ru');
		$project->description_en = 	$this->input->post('project_description_en');
		$project->url = 			$this->input->post('project_url');
		$project->image = 			$this->input->post('project_image');
		if ($this->input->post('project_id') != '') 
		{
			$project->id = 			$this->input->post('project_id');
		}
		// Не будем хранить пустоты зазря
		if($project->name_en === '') { $project->name_en = null; }
		if($project->description_en === '') { $project->description_en = null; }
		if ($project->image == 0 ) {$project->image = null; }
		
		return $project;
	}
	/**
	 * Добавить новый проект, используя данные, отправленные методом POST
	 * @return int id - идентификатор добавленого проекта | FALSE
	 */
	function add_from_post() 
	{
		$project = $this->get_from_post();
		if($this->db->insert(TABLE_PROJECTS, $project))
		{
			$this->message = 'Проект был успешно внесен в базу данных';
			return $this->db->insert_id();
		}
		else
		{
			$this->message = 'Ошибка! Проект не удалось добавить проект';
			return FALSE;
		}
	}
	
	function edit_from_post() 
	{
		$project = $this->get_from_post();
		
		$this->db->where('id', $project->id);
		$response = $this->db->update(TABLE_PROJECTS, $project);
		if ($response != 1) 
		{
			$this->message = 'Ошибка! Проект не был изменен';
		}
		else {
			$this->message = 'Проект был успешно изменен';
		}
		return $response;
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