<?php
echo anchor('/admin/directions/add', 'Добавить направление');
echo br(2);
$data['rows'] = array();
$data['headers'] = array('Направление','Участников','','');
$data['classes'] = array('direction','count','','');
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
    $tablerow[] = anchor('admin/directions/edit/' . $direction->id,$direction->name);
    $tablerow[] = $direction->memberscount;
    $tablerow[] = $button_edit_photo;
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);