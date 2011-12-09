<?php
echo anchor('/admin/directions/add', 'Добавить направление');
echo br(2);
$data['rows'] = array();
$data['headers'] = array('Направление','Участников','');
$data['classes'] = array('direction','count','');
foreach($directions as $direction)
{
    $tablerow = array();
	$button_delete = anchor('/admin/directions/delete/' . $direction->id,
			img( '/images/admin/buttons/delete.png'),
			array(	'class' => 'button_delete',
					'title' => 'Удалить направление ' . $direction->name)
	);
    $tablerow[] = anchor('admin/directions/edit/' . $direction->id,$direction->name);
    $tablerow[] = $direction->memberscount;
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);