<?php

$data['rows'] = array();
$data['classes'] = array('course','year','count','delete');
$data['headers'] = array('Курс','Год','Количество студентов','');
foreach($courses as $course)
{
    $tablerow = array();
    $button_delete = anchor('/admin/courses/delete/' . $course->id,
	img( '/images/admin/buttons/delete.png'),
		array(	'class' => 'button_delete',
				'title' => 'Удалить курс ')
	);
    $tablerow[] = $course->course;
    $tablerow[] = $course->year;
    $tablerow[] = $course->studentscount;
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);
