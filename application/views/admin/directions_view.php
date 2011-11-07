<?php
echo anchor('/admin/directions/add', 'Добавить направление');
echo br(2);
echo '<table>';
foreach($directions as $direction)
{
    echo '<tr><td>';
	$button_delete = anchor('/admin/directions/delete/' . $direction->id,
			img( '/images/admin/buttons/delete.png'),
			array(	'class' => 'button_delete',
					'title' => 'Удалить направление ' . $direction->name)
	);
	echo anchor('admin/directions/edit/' . $direction->id,
			$direction->name,
			array('class' => 'direction_short_view')) . '</td><td>' . $button_delete.br();
    echo '</td></tr>';
}
echo '</table>';
/* End of file directions_view.php */
/* Location: ./application/views/admin/directions_view.php */