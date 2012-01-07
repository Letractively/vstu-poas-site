<?php
echo anchor('/admin/partners/add', 'Добавить партнера');
echo br(2);
$data['rows'] = array();
$data['headers'] = array('id', 'Название', 'Изображение', '');
    $args = '';
    // upload_path
    $args .= "'./uploads/partners/',";
    // allowed_types
    $args .= "'gif|jpg|png|jpeg',";
    // max_size
    $args .= "'1000',";
    // max_width
    $args .= "'1024',";
    // max_height
    $args .= "'800',";
    //table_name
    $args .= "'" . TABLE_PARTNERS . "',";
    //field_name
    $args .= "'image',";

    // +
    // record_id
    // id пользователя добавляется для каждого пользователя
    // full_url ссылка на файл, если он существует
foreach($partners as $partner)
{
    $tablerow = array();
	$button_delete = anchor('/admin/partners/delete/' . $partner->id,
        img( '/images/admin/buttons/delete.png'),
            array(	'class' => 'button_delete',
                    'title' => 'Удалить партнера ' . $partner->name)
        );
//    $button_edit_photo = anchor('#',
//        img( '/images/admin/buttons/user.png'),
//            array(	'class' => 'button_edit_file',
//                    'title' => 'Изменить изображение для партнера ' . $partner->id,
//                    'onclick' => 'fileLoader(' .
//                                    $args .
//                                    "'" .
//                                    $partner->id .
//                                    "','" .
//                                    $this->config->item('base_url') .
//                                    $this->{MODEL_PARTNER}->get_image($partner->id) .
//                                    "')")
//        );
    $button_edit_photo = 'редактировать изображение';
    $tablerow[] = $partner->id;
    $tablerow[] = anchor('admin/partners/edit/' . $partner->id,$partner->name);
    $tablerow[] = $button_edit_photo;
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);