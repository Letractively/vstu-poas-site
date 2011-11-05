<?php
/**
 * @class Direction_model
 * Модель направлений.
 */

class Direction_model extends CI_Model {
	var $message = '';
	/**
	 * Получить основную информацию о всех направлениях (или об одном направлении)
	 *
	 * Получить только name, id направлений
	 * @param $id - id направления, необязательный параметр
	 * @return массив всех записей, запись с указанным id или FALSE
	 */
	function get_short ($id = null)
	{
		if (isset($id))
		{
			$directions = $this->db
							 ->select('id, name_'.lang().' as name')
							 ->where('name_'.lang().' IS NOT NULL AND name_'.lang().' != ""')
							 ->get_where(TABLE_DIRECTIONS, array('id' => $id), 1)
							 ->result();
			if( !$directions)
			{
				return FALSE;
			}
			return $directions[0];
		}
	
		return $this->db
					->select('id, name_'.lang().' as name')
					->where('name_'.lang().' IS NOT NULL AND name_'.lang().' != ""')
					->order_by('name_'.lang())
					->get(TABLE_DIRECTIONS)
					->result();
	}
	
	/**
	 * Получить информацию о направлени из данных, полученных методом POST
	 * return объект, содержащий собранную информацию о направлении
	 */
	function get_from_post()
	{
		$direction = new stdClass();
		$direction->name_ru = 		$this->input->post('direction_name_ru');
		$direction->name_en = 		$this->input->post('direction_name_en');
		$direction->description_ru = 	$this->input->post('direction_description_ru');
		$direction->description_en = 	$this->input->post('direction_description_en');
		if ($this->input->post('direction_id') != '')
		{
			$direction->id = 			$this->input->post('direction_id');
		}
		// Не будем хранить пустоты зазря
		if($direction->name_en === '') {
			$direction->name_en = null;
		}
		if($direction->description_en === '') {
			$direction->description_en = null;
		}
		if($direction->description_ru === '') {
			$direction->description_ru = null;
		}
		return $direction;
	}
	
	/**
	 * Добавить новое направление, используя данные, отправленные методом POST
	 * @return int id - идентификатор добавленого направления | FALSE
	 */
	function add_from_post() 
	{
		$direction = $this->get_from_post();
		if($this->db->insert(TABLE_DIRECTIONS, $direction))
		{
			$this->message = 'Направление было успешно внесено в базу данных';
			return $this->db->insert_id();
		}
		else
		{
			$this->message = 'Ошибка! Направление не удалось добавить';
			return FALSE;
		}
	}
	
	function edit_from_post()
	{
		$direction = $this->get_from_post();
	
		$this->db->where('id', $direction->id);
		$response = $this->db->update(TABLE_DIRECTIONS, $direction);
		if ($response != 1)
		{
			$this->message = 'Ошибка! Направление не было изменено';
		}
		else {
			$this->message = 'Направление было успешно изменено';
		}
		return $response;
	}
	
	/**
	 * Получить запись о направлении из таблицы базы данных
	 *
	 * @param $id - id направления
	 * @return массив всех записей, запись с указанным id или FALSE
	 */
	function get_direction($id) {
	
		$direction = $this->db->select('*')->get_where(TABLE_DIRECTIONS, array('id' => $id), 1)->result();
		if (!$direction)
		{
			return NULL;
		}
		return $direction[0];
	}
	/**
	 * Удалить направление из базы
	 *
	 * @param $id - id направления
	 * @return TRUE, если направление удалено, иначе FALSE
	 */
	function delete ($id)
	{
		if( ! $this->db->delete(TABLE_DIRECTIONS, array('id' => $id)))
		{
			$this->message = 'Произошла ошибка, направление удалить не удалось.';
			return FALSE;
		}
		else
		{
			$this->message = 'Направление удалено успешно (id был равен ' . $id . ').';
		}
		return TRUE;
	}
}
