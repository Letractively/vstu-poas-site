<?php
echo anchor('/admin/directions/add', 'Добавить направление');
echo br(2);
$data['rows'] = array();
$data['headers'] = array('Направление','Всего','Уч.','Рук.','','');
$data['classes'] = array('direction','count','','','','');
$args = '';
    // upload_path
    $args .= "'./uploads/direction/',";
    // allowed_types
    $args .= "'gif|jpg|png|jpeg',";
    // max_size
    $args .= "'1000',";
    // max_width
    $args .= "'1024',";
    // max_height
    $args .= "'800',";
    //table_name
    $args .= "'" . TABLE_DIRECTIONS . "',";
    //field_name
    $args .= "'image',";
foreach($directions as $direction)
{
    $tablerow = array();
	$button_delete = anchor('/admin/directions/delete/' . $direction->id,
			img( '/images/admin/buttons/delete.png'),
			array(	'class' => 'button_delete',
					'title' => 'Удалить направление ' . $direction->name)
	);
    $button_edit_photo = anchor('#',
        img( '/images/admin/buttons/user.png'),
            array(	'class' => 'button_edit_file',
                    'title' => 'Изменить изображение для направления '.$direction->id,
                    'onclick' => 'fileLoader(' .
                                    $args .
                                    "'" .
                                    $direction->id .
                                    "','" .
                                    $this->config->item('base_url') .
                                    $this->{MODEL_DIRECTION}->get_image($direction->id) .
                                    "')")
        );
    $button_users = anchor(
        '#',
        img( '/images/admin/buttons/users.png'),
            array(	'class' => 'button_users',
                    'title' => 'Редактировать состав участников направления',
                    'onclick' => 'advancedUsersSelector(\'Cостав участников направления\', \''
                                 . TABLE_DIRECTION_MEMBERS
                                 . '\',\'userid\', \'directionid\', \''.$direction->id.'\', \'ishead\',\'0\')')
	);
    $button_users_2 = anchor(
        '#',
        img( '/images/admin/buttons/users.png'),
            array(	'class' => 'button_users',
                    'title' => 'Редактировать состав руководителей направления',
                    'onclick' => 'advancedUsersSelector(\'Cостав участников направления\', \''
                                 . TABLE_DIRECTION_MEMBERS
                                 . '\',\'userid\', \'directionid\', \''
                                 .$direction->id.'\', \'ishead\', \'1\')')
	);
    $tablerow[] = anchor('admin/directions/edit/' . $direction->id,$direction->name);
    $tablerow[] = $direction->memberscount;
    $tablerow[] = $button_users;
    $tablerow[] = $button_users_2;
    $tablerow[] = $button_edit_photo;
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);