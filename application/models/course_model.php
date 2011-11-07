<?php
require_once('super_model.php');
class Course_model extends Super_model{
    function get_short($id = null) 
    {
        // Родительский метод не годится, он опирается на язык
        if (isset($id))
		{
			$records = $this->db
							 ->select('id, course, year')
							 ->get_where(TABLE_USER_COUSRES, array('id' => $id), 1)
							 ->result();
			if( !$records)
			{
				return FALSE;
			}
            $this->db
                        ->from(TABLE_USER_COUSRES)
                        ->where('course', $records[0]->course)
                        ->where('year', $records[0]->year);
            $records[0]->studentscount = $this->db->count_all_results();
			return $records[0];
		}
	
		$result =  $this->db
					->select('id, course, year')
					->order_by('year DESC, course DESC')
					->get(TABLE_USER_COUSRES)
					->result();
        if ($result)
        {
            foreach ($result as $record)
            {
                $this->db
                        ->from(TABLE_USER_COUSRES)
                        ->where('course', $record->course)
                        ->where('year', $record->year);
                $record->studentscount = $this->db->count_all_results();
            }
        }
        return $result;
    }
    function get_detailed($id){}
    function add_from_post(){}
    function edit_from_post(){}
    function delete($id){}
}

?>
