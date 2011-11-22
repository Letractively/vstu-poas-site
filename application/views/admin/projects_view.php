<?php
echo anchor('/admin/projects/add', 'Добавить проект');
echo br(2);
$data['classes'] = array('','count','','','');
$data['headers'] = array('Проект','Участников','','','');
$data['rows'] = array();
    $args = '';
    // upload_path
    $args .= "'./uploads/projects/',";
    // allowed_types
    $args .= "'gif|jpg|png|jpeg',";
    // max_size
    $args .= "'1000',";
    // max_width
    $args .= "'1024',";
    // max_height
    $args .= "'800',";    
    //table_name
    $args .= "'" . TABLE_PROJECTS . "',";
    //field_name
    $args .= "'image',";
    
    // +    
    // record_id
    // id пользователя добавляется для каждого пользователя    
    // full_url ссылка на файл, если он существует
foreach($projects as $project)
{
    $tablerow = array();
	$button_delete = anchor('/admin/projects/delete/' . $project->id,
	img( '/images/admin/buttons/delete.png'),
		array(	'class' => 'button_delete',
				'title' => 'Удалить проект ' . $project->name)
	);
    $button_users = anchor(
        '#',
        img( '/images/admin/buttons/users.png'),
            array(	'class' => 'button_users',
                    'title' => 'Редактировать состав участников проекта',
                    'onclick' => 'usersSelector(\'Cостав участников проекта\', \'' . TABLE_PROJECT_MEMBERS . '\',\'userid\', \'projectid\', \''.$project->id.'\')')
	);
    $button_edit_photo = anchor('#',
        img( '/images/admin/buttons/user.png'),
            array(	'class' => 'button_edit_file',
                    'title' => 'Изменить изображение для проекта '.$project->id,
                    'onclick' => 'fileLoader(' . 
                                    $args . 
                                    "'" . 
                                    $project->id . 
                                    "','" . 
                                    $this->config->item('base_url') . 
                                    $this->{MODEL_PROJECT}->get_image($project->id) .
                                    "')")
        );
    $tablerow[] = anchor('admin/projects/edit/'.$project->id, 
                            $project->name);
    $tablerow[] = $project->memberscount;
    $tablerow[] = $button_users;
    $tablerow[] = $button_edit_photo;
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);
/* End of file projects_view.php */
/* Location: ./application/views/admin/projects_view.php */