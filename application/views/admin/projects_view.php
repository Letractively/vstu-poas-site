<?php
echo anchor('/admin/projects/add', 'Добавить проект');
echo br(2);
$data['classes'] = array('','count','','','');
$data['headers'] = array('Проект','Участников','','','');
$data['rows'] = array();
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
    $tablerow[] = anchor('admin/projects/edit/'.$project->id, 
                            $project->name);
    $tablerow[] = $project->memberscount;
    $tablerow[] = $button_users;
    $tablerow[] = 'image';
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);
/* End of file projects_view.php */
/* Location: ./application/views/admin/projects_view.php */