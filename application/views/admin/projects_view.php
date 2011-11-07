<?php
echo anchor('/admin/projects/add', 'Добавить проект');
echo br(2);

$data['rows'] = array();
foreach($projects as $project)
{
    $tablerow = array();
	$button_delete = anchor('/admin/projects/delete/' . $project->id,
	img( '/images/admin/buttons/delete.png'),
		array(	'class' => 'button_delete',
				'title' => 'Удалить проект ' . $project->name)
	);
    $tablerow[] = anchor('admin/projects/edit/'.$project->name, $project->name);
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);
/* End of file projects_view.php */
/* Location: ./application/views/admin/projects_view.php */