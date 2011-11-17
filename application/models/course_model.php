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
                        ->from(TABLE_USER_COURSES)
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
    
    function edit_from_post() 
    {
        $course->id = $this->input->post('course_id');
        $this->update_course_members($course->id, $this->input->post('course_members'));
    }
    
    function update_course_members($id, $members)
    {
        $this->_update_connected_users(TABLE_USER_COURSES, 
                'courseid', 
                $id, 
                $members);
    }
    
    /**
     * Удалить курс из базы данных
     * Так же удаляет записи из таблицы "студенты курса"
     * @param int $id идентификатор курса
     * @return TRUE, если курс удален, иначе FALSE 
     */
    function delete($id)
    {
        $result = $this->_delete(TABLE_COURSES, $id);
        $message = $this->message;
        $cascade = $this->_delete(TABLE_USER_COURSES, $id, 'courseid');
        $this->message = $message;
        return $cascade && $result;
    }
    
    function get_course($id) 
    {
        $course = $this->_get_record($id, TABLE_COURSES);
        $course->members = $this->get_members($id);
        
        return $course;
    }
    
    /**
	 * Получить информацию обо всех студентах курса
	 * @param int $id идентификатор курса
	 * @return массив пользователей
	 */
	function get_members($id)
	{
		$this->db
				->select(TABLE_USERS . '.id, name_'.lang().' as name, surname_'.lang().' as surname, patronymic_'.lang().' as patronymic')
				->from(TABLE_USER_COURSES)
				->join(TABLE_USERS, TABLE_USERS.'.id = ' . TABLE_USER_COURSES. '.userid')
				->where('courseid = ' . $id);
        return $this->db->get()->result();
	}
    
    public function get_view_extra() {
        $this->load->model(MODEL_USER);
        $extra->users = $this->{MODEL_USER}->get_short();
        return $extra;
    }
    
    function exists($id)
    {
        return $this->_record_exists(TABLE_COURSES, $id);
    }

}

?>
