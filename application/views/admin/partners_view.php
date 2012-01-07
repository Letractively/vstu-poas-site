<?php
echo anchor('/admin/partners/add', 'Добавить партнера');
echo br(2);
$data['rows'] = array();
$data['headers'] = array('id', 'Название', '', '');
foreach($partners as $partner)
{
    $tablerow = array();
	$button_delete = anchor('/admin/partners/delete/' . $partner->id,
        img( '/images/admin/buttons/delete.png'),
            array(	'class' => 'button_delete',
                    'title' => 'Удалить партнера ' . $partner->name)
        );
    $button_edit_photo = anchor('#',
        img( '/images/admin/buttons/image.png'),
            array(	'class' => 'button_edit_file',
                    'title' => 'Изменить изображение для партнера ' . $partner->name,
                    'onclick' => "advFileLoader('partner', '$partner->id')")
        );
    $tablerow[] = $partner->id;
    $tablerow[] = anchor('admin/partners/edit/' . $partner->id, $partner->name);
    $tablerow[] = $button_edit_photo;
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);