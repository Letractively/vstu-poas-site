<?php
/**
 * @class Publication_model
 * Модель публикаций.
 */

class Publication_model extends CI_Model 
{
	var $message = '';
    
    /**
	 * Получить основную информацию обо всех публикациях (или об одной публикации)
	 *
	 * Получить только name, id публикации
	 * @param $id - идентификатор публикации, необязательный параметр
	 * @return массив всех записей, запись с указанным id или FALSE
	 */
	function get_short ($id = null)
	{
		if (isset($id))
		{
			$publications = $this->db
							 ->select('id, name_'.lang().' as name')
							 ->where('name_'.lang().' IS NOT NULL AND name_'.lang().' != ""')
							 ->get_where(TABLE_PUBLICATIONS, array('id' => $id), 1)
							 ->result();
			if( !$publications)
			{
				return FALSE;
			}
			return $publications[0];
		}
	
		return $this->db
					->select('id, name_'.lang().' as name')
					->where('name_'.lang().' IS NOT NULL AND name_'.lang().' != ""')
					->order_by('name_'.lang())
					->get(TABLE_PUBLICATIONS)
					->result();
	}
}
?>
