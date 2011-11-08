<?php
require_once('super_model.php');
class Course_model extends Super_model{
    function get_short($id = null) 
    {
        $result =  $this->db
					->select('id, course, year')
					->order_by('year DESC, course DESC')
					->get(TABLE_COURSES)
					->result();
        if ($result)
        {
            foreach ($result as $record)
            {
                $this->db
                        ->from(TABLE_USERS)
                        ->join(TABLE_USER_COURSES, TABLE_USERS.'.id = userid')
                        ->where('courseid', $record->id);
                $record->studentscount = $this->db->count_all_results();
            }
        }
        return $result;
    }
    function get_detailed($id){}
    function add_from_post()
    {
        $course->course = $this->input->post('course_course') + 1; 
        $course->course = (string)$course->course;
        $course->year = $this->input->post('course_year');
        
        if ($course->year == '')
        {
            $this->message = 'Не указан год';
            return FALSE;
        }
        
        if (!is_numeric($course->year))
        {
            $this->message = 'Неправильный год';
            return FALSE;
        }
        if($course->course == 7)    // Добавить сразу все курсы за определенный год
        {
            $errors = array();
            for($i = 1; $i <= 6; $i++)
            {
                $course->course = (string)$i;
                $this->db->from(TABLE_COURSES)->where('course', (string)$i)->where('year', $course->year);
                if ($this->db->count_all_results() > 0)
                {
                    $errors[] = $i;
                }
                else
                    if (!$this->_add(TABLE_COURSES, $course))
                        $errors[] = $i;
            }
            if (count($errors) == 0)
                $this->message = 'Записи были успешно внесены в базу данных';
            else
            {
                if(count($errors) == 1)
                    $this->message = 'Ошибка в курсе '. implode(',', $errors);
                else
                    $this->message = 'Ошибка в курсах '. implode(',', $errors);
            }
        }
        else
        {
            $this->db->from(TABLE_COURSES)->where('course', $course->course)->where('year', $course->year);
            if ($this->db->count_all_results() > 0)
            {        
                $this->message = 'Такой курс уже существует';
                return FALSE;
            }
            else
                return $this->_add(TABLE_COURSES, $course);
        }
    }
    function edit_from_post() {}
    function delete($id){}
}

?>
