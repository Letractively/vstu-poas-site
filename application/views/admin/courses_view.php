<?php

function add_form(){
    $html = form_open('admin/courses/add/');
    $html .= form_label('Курс ', 'course_course', array('class'=>'inline-block'));
    $html .= form_dropdown('course_course', array(1,2,3,4,5,6,'все'));
    $html .= ' ';
    $html .= form_label('Год ', 'course_year', array('class'=>'inline-block'));
    $html .= form_input('course_year', '', 'maxlength="4"');
    $html .= ' ';
    $html .= form_submit('course_submit', 'Добавить курс');
    $html .= form_close();
    return $html;
}
echo add_form();
$data['rows'] = array();
$data['classes'] = array('course','year','count','edit','delete');
$data['headers'] = array('Курс','Год','Количество студентов','','');
foreach($courses as $course)
{
    $tablerow = array();
    $button_delete = anchor('/admin/courses/delete/' . $course->id,
	img( '/images/admin/buttons/delete.png'),
		array(	'class' => 'button_delete',
				'title' => 'Удалить курс')
	);
    $button_users = anchor('/admin/courses/edit/' . $course->id,
	img( '/images/admin/buttons/users.png'),
		array(	'class' => 'button_users',
				'title' => 'Редактировать состав курса')
	);
    $tablerow[] = $course->course;
    $tablerow[] = $course->year;
    $tablerow[] = $course->studentscount;
    $tablerow[] = $button_users;
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);
if (count($courses) > 10)
    echo add_form();
