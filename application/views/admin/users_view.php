<?php
$groups = array('Не определено', 'Администратор', 'Студент', 'Преподаватель');
echo anchor('/admin/users/add', 'Добавить пользователя');
echo br(2);
$data['rows'] = array();
$data['classes'] = array('users', '', '', '');
$data['headers'] = array('ФИО','Группа','','');
foreach($users as $user)
{
    $tablerow = array();
	$button_delete = anchor('/admin/users/delete/'.$user->id,
        img( '/images/admin/buttons/delete.png'),
            array(	'class' => 'button_delete',
                    'title' => 'Удалить пользователя '.$user->id)
        );
    $button_edit_photo = anchor('/admin/users/edit_photo/'.$user->id,
        img( '/images/admin/buttons/user.png'),
            array(	'class' => 'button_edit_file',
                    'title' => 'Изменить фотографию пользователя '.$user->id)
        );
    $tablerow[] = anchor(   'admin/users/edit/' . $user->id, 
                                $user->surname . ' '.
                                $user->name . ' ' .
                                $user->patronymic);
    if (!isset($user->group_id))
        $user->group_id = 0;
    $tablerow[] = $groups[$user->group_id];
    $tablerow[] = $button_edit_photo;
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);
/* End of file cities_view.php */
/* Location: ./application/views/admin/cities_view.php */