<?php
require_once('super.php');
class Course_model extends Super{

    /**
     * Получить список записей для панели администратора
     * @param int $page страница
     * @param int $amount_on_page количество записей на странице
     * @return array массив записей
     */
    public function get_records_for_admin_view($page = 1, $amount_on_page = 20)
    {
        $result = $this->db
                ->select('id, course, year')
                ->order_by('year DESC, course DESC')
                ->get(TABLE_COURSES, $amount_on_page, ($page - 1) * $amount_on_page)
                ->result();
        if (is_array($result)) {
            foreach($result as $record){
                $record->studentscount = $this->get_students_count($record->id);
            }
        }
        return $result;
    }

    public function get_students_count($id)
    {
        $this->db
            ->from(TABLE_USER_COURSES)
            ->where('courseid', $id);

        return $this->db->count_all_results();
    }

    /**
     * Добавить запись в БД, параметры которой переданы через POST-запросы
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @return boolean TRUE, если запись была успешно добавлена, иначе - FALSE
     */
    public function add_from_post()
    {
        $course->course = $this->input->post('course_course', TRUE);
        $course->course = (string)$course->course;
        $course->year = $this->input->post('course_year', TRUE);

        if ($course->year == '')
        {
            $this->admin_message = 'Не указан год';
            return FALSE;
        }

        if (!is_numeric($course->year))
        {
            $this->admin_message = 'Неправильный год';
            return FALSE;
        }
        if ($course->course == 'all')
        {
            $courses = array('1','2','3','4','5','6','pg1','pg2','pg3','pg4','d1','d2','d3');
            foreach ($courses as $c)
            {
                $this->add_course($c, $course->year);
            }
        }
        else
        {
            return $this->add_course($course->course, $course->year);
        }
    }

    /**
     * Добавить в базу курс
     * @param string $course курс
     * @param int $year год
     * @return mixed идентификатор добавленной записи | FALSE
     */
    private function add_course($course, $year)
    {
        $this->db
            ->from(TABLE_COURSES)
            ->where('course', $course)
            ->where('year', $year);

        if ($this->db->count_all_results() > 0)
        {
            $this->admin_message = "Такой курс уже существует ($course, $year)";
            return FALSE;
        }
        else
        {
            $record->course = $course;
            $record->year = $year;
            return parent::add(TABLE_COURSES, $record);
        }
    }

    /**
     * Проверить, существует ли запись в БД
     * @param int $id идентифиактор искомой записи
     * @return boolean TRUE, если запись существует, иначе - FALSE
     */
    public function exists($id)
    {
        return parent::record_exists(TABLE_COURSES, $id);
    }

    /**
     * Удалить запись из БД
     * В случае возникновения ошибок, сообщение заносится в поле $admin_message
     * @param int $id идентификатор удаляемой записи
     * @return boolean TRUE, если запись существовала и была успешно удалена, иначе - FALSE
     */
    public function delete($id)
    {
        // Удаление студентов с курса
        parent::delete_record(TABLE_USER_COURSES, $id, 'courseid');
        // Удаление записи
        return parent::delete_record(TABLE_COURSES, $id);
    }

    /**
     * Получить все года, в которых есть студенты определенной формы обучения
     * @param string form Форма обучения
     * @return упорядоченный по убыванию массив лет
     */
    function get_years_by_form($form)
    {
        $where = $this->get_sql_where_to_form($form);
        $records = $this->db
                    ->select('year')
                    ->distinct()
                    ->from(TABLE_COURSES)
                    ->join(TABLE_USER_COURSES, TABLE_USER_COURSES.'.courseid='.TABLE_COURSES.'.id')
                    ->where($where, NULL, FALSE)
                    ->order_by('year DESC')
                    ->get()
                    ->result();
        $years = array();
        foreach ($records as $record)
        {
            $years[] = $record->year;
        }
        return $years;
    }

    /**
     * Получить SQL - запрос для условия выборки из таблицы по форме обучения
     * @param string $form форма обучения {bachelor, master, pg, doc}
     * @return string SQL-запрос вида course='1' OR course='2' ...
     */
    function get_sql_where_to_form($form)
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
        return $where;
    }

    /**
     * Получить данные студентов курса для карточки пользователя на сайте
     * @param string $form форма обучения
     * @param int $year год обучения
     * @return array студенты
     */
    function get_user_cards($form, $year)
    {
        $where = '(' . $this->get_sql_where_to_form($form) . ')';
        if ($year != '' && $year != null)
            $where .= ' AND ' . TABLE_COURSES . '.year=' . $year;
        $users = $this->db
                        ->select(   'name_'.lang().' as name,'.
                                    'surname_'.lang().' as surname,'.
                                    'patronymic_'.lang().' as patronymic,'.
                                    'rank_'.lang().' as rank,'.
                                    'post_'.lang().' as post,'.
                                    'email,'.
                                    TABLE_USERS.'.id')
                        ->distinct()
                        ->from(TABLE_USERS)
                        ->join(TABLE_USER_COURSES, TABLE_USERS.'.id = '.TABLE_USER_COURSES.'.userid')
                        ->join(TABLE_COURSES, TABLE_USER_COURSES.'.courseid='.TABLE_COURSES.'.id')
                        ->where($where, NULL, FALSE)
                        ->order_by('surname,name,patronymic')
                        ->get()
                        ->result();
        if (!$users)
            return array();
        else
        {
            $this->load->model(MODEL_USER);
            foreach ($users as $user)
            {
                $interests = $this->{MODEL_USER}->get_user_interests($user->id);
                if(is_array($interests))
                {
                    foreach ($interests as $interest)
                    {
                        // на всякий случай, если в базе не достает метки или расшифровки
                        if ($interest->short == '' || $interest->short == null)
                            $interest->short = $interest->full;
                        if ($interest->full == '' || $interest->full == null)
                            $interest->full = $interest->short;
                        $user->interests[$interest->short] = $interest->full;
                    }
                }
                else
                    $user->interests = array();
                $user->photo = $this->{MODEL_USER}->get_image_path($user->id);
            }
            return ($users);
        }
    }
}

/* End of file course_model.php */
/* Location: ./application/models/course_model.php */
