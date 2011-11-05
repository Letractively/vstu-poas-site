<?php
echo anchor('/admin/directions/add', 'Добавить направление');
echo br(2);
foreach($directions as $direction)
{
	$button_delete = anchor('/admin/directions/delete/' . $direction->id,
			img( '/images/admin/buttons/delete.png'),
			array(	'class' => 'button_delete',
					'title' => 'Удалить направление ' . $direction->name)
	);
	echo anchor('admin/directions/edit/' . $direction->id,
			$direction->name,
			array('class' => 'direction_short_view')) . $button_delete.br();
}
/* End of file directions_view.php */
/* Location: ./application/views/admin/directions_view.php */