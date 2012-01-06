<?php
$groups = array('Не определено', 'Администратор', 'Студент', 'Преподаватель');
echo anchor('/admin/users/add', 'Добавить пользователя');
echo br(2);

    $args = '';
    // upload_path
    $args .= "'./uploads/users/',";
    // allowed_types
    $args .= "'gif|jpg|png|jpeg',";
    // max_size
    $args .= "'1000',";
    // max_width
    $args .= "'800',";
    // max_height
    $args .= "'600',";
    //table_name
    $args .= "'" . TABLE_USERS . "',";
    //field_name
    $args .= "'photo',";

    // +
    // record_id
    // id пользователя добавляется для каждого пользователя
    // full_url ссылка на файл, если он существует

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
    /*$button_edit_photo = anchor('/admin/users/edit_photo/'.$user->id,
        img( '/images/admin/buttons/user.png'),
            array(	'class' => 'button_edit_file',
                    'title' => 'Изменить фотографию пользователя '.$user->id)
        );*/
    $button_edit_photo = anchor('#',
        img( '/images/admin/buttons/user.png'),
            array(	'class' => 'button_edit_file',
                    'title' => 'Изменить фотографию пользователя '.$user->id,
                    'onclick' => 'fileLoader(' .
                                    $args .
                                    "'" .
                                    $user->id .
                                    "','" .
                                    $this->config->item('base_url') .
                                    $this->{MODEL_USER}->get_photo($user->id) .
                                    "')")
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