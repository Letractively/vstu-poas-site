<?php
$coursesnames = array(
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            'pg1' => '1 - аспирантура',
            'pg2' => '2 - аспирантура',
            'pg3' => '3 - аспирантура',
            'pg4' => '4 - аспирантура',
            'd1' => '1 - докторантура',
            'd2' => '2 - докторантура',
            'd3' => '3 - докторантура',
            'all' => 'все'
            );
function add_form($coursesnames){
    $html = form_open('admin/courses/add/', array('class' => 'gray_form'));
    $html .= form_label('Курс ', 'course_course', array('class'=>'inline-block'));
    $html .= form_dropdown('course_course', $coursesnames);
    $html .= ' ';
    $html .= form_label('Год ', 'course_year', array('class'=>'inline-block'));
    $html .= form_input('course_year', '', 'maxlength="4"');
    $html .= ' ';
    $html .= form_submit('course_submit', 'Добавить курс');
    $html .= form_close();
    return $html;
}
echo anchor('about/students/', 'Страница студентов на сайте').br(2);
echo add_form($coursesnames);
$data['rows'] = array();
$data['classes'] = array('','course','year','count','edit','delete');
$data['headers'] = array('id','Курс','Год','Cтудентов','','');
foreach($courses as $course)
{
    $tablerow = array();
    $button_delete = anchor('/admin/courses/delete/' . $course->id,
	img( '/images/admin/buttons/delete.png'),
		array(	'class' => 'button_delete',
				'title' => 'Удалить курс')
	);
    $button_users = anchor(
        '#',
        img( '/images/admin/buttons/users.png'),
            array(	'class' => 'button_users',
                    'title' => 'Редактировать состав курса',
                    'onclick' => 'usersSelector(\'Cостав курса\', \'' . TABLE_USER_COURSES . '\',\'userid\', \'courseid\', \''.$course->id.'\')')
	);
    $tablerow[] = $course->id;
    $tablerow[] = $coursesnames[$course->course];
    $tablerow[] = $course->year;
    $tablerow[] = $course->studentscount;
    $tablerow[] = $button_users;
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);
if (count($courses) > 10)
    echo add_form($coursesnames);
