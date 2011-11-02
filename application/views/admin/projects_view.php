<?php
echo anchor('/admin/projects/add', 'Добавить проект');
echo br(2);

foreach($projects as $project)
{
	$button_delete = anchor('/admin/projects/delete/' . $project->id,
	img( '/images/admin/buttons/delete.png'),
		array(	'class' => 'button_delete',
				'title' => 'Удалить проект ' . $project->name)
	);
	echo anchor('admin/projects/edit/' . $project->id, 
					$project->name, 
					array('class' => 'project_short_view')) . $button_delete.br();
}

/* End of file projects_view.php */
/* Location: ./application/views/admin/projects_view.php */