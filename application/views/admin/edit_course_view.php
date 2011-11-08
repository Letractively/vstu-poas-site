<?php

if (!isset($course->members))   $course->members = array();
if (!isset($extra->users))      $extra->users = array();

echo form_open('admin/courses/edit/action');

$data['label'] = 'Студенты';
$data['id'] = 'course_members';
$data['users'] = array();
foreach($extra->users as $user)
{
    $data['users'][$user->id] = $user->surname.' '.$user->name.' '.$user->patronymic;
}
$data['select'] = array();
foreach($course->members as $member)
{
    $data['select'][] = $member->id;
}
$this->load->view('admin/users_list_view', $data);
echo br(2);

if( isset($course->id) )
{
	echo form_hidden('course_id', $course->id);
}
echo br(2);
echo form_submit('course_submit', 'Сохранить');
echo form_close();
