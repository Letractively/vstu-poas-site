<?php
echo anchor('/admin/partners/add', 'Добавить партнера');
echo br(2);
$data['rows'] = array();
foreach($partners as $partner)
{
    $tablerow = array();
	$button_delete = anchor('/admin/partners/delete/' . $partner->id,
	img( '/images/admin/buttons/delete.png'),
		array(	'class' => 'button_delete',
				'title' => 'Удалить партнера ' . $partner->name)
	);
    $tablerow[] = anchor('admin/partners/edit/' . $partner->id,$partner->name);
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);