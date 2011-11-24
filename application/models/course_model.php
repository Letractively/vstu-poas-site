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
        $course->course = $this->input->post('course_course');
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
        $coursesnames = array(
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            'pg1',
            'pg2',
            'pg3',
            'pg4',
            'd1',
            'd2',
            'd3'
            );
        if($course->course == 'all')    // Добавить сразу все курсы за определенный год
        {
            $errors = array();
            foreach($coursesnames as $coursename)
            //for($i = 1; $i <= 6; $i++)
            {
                //$course->course = (string)$i;
                $course->course = $coursename;
                $this->db->from(TABLE_COURSES)->where('course', $coursename)->where('year', $course->year);
                if ($this->db->count_all_results() > 0)
                {
                    $errors[] = $coursename;
                }
                else
                    if (!$this->_add(TABLE_COURSES, $course))
                        $errors[] = $coursename;
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
    /**
     * Получить все года, в которых есть студенты определенной формы обучения
     * @return упорядоченный по убыванию массив лет
     */
    function get_years_by_form($form)
    {
        $where = '1=1';
        switch($form)
        {
            case 'bachelor':
                $where = "course='1' OR course='2' OR course='3' OR course='4'";
                break;
            case 'master':
                $where = "course='5' OR course='6'";
                break;
            case 'pg':
                $where = "course='pg1' OR course='pg2' OR course='pg3' OR course='pg4'";
                break;
            case 'doc':
                $where = "course='d1' OR course='d2' OR course='d3'";
                break;
        }
        $records = $this->db
                    ->select('year')
                    ->distinct()
                    ->from(TABLE_COURSES)
                    ->join(TABLE_USER_COURSES, TABLE_USER_COURSES.'.courseid='.TABLE_COURSES.'.id')
                    ->where($where, NULL, FALSE)
                    ->order_by('year DESC')
                    ->get()
                    ->result();
        /**
         * SELECT DISTINCT year FROM `courses` JOIN user_courses ON courseid=courses.id where course='1' OR course='2' ...
         */
        $years = array();
        foreach ($records as $record)
        {
            $years[] = $record->year;
        }
        return $years;
    }

}

?>
