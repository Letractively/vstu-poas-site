<?php
echo anchor('/admin/publications/add', 'Добавить публикацию');
echo br(2);

if (count($publications) > 0)
{
    $data['rows'] = array();
    $data['classes'] = array('','publication', 'count','','','','','','delete');
    $data['headers'] = array('id','Публикация', 'Авторов', '','Рус. текст','Рус. аннотац.','Анг. текст','Анг. аннотац.','');
//    $args = '';
//    // upload_path
//    $args .= "'./uploads/publications/',";
//    // allowed_types
//    $args .= "'pdf|doc|docx|odt|rtf|txt',";
//    // max_size
//    $args .= "'10000',";
//    // max_width
//    $args .= "'1024',";
//    // max_height
//    $args .= "'800',";
//    //table_name
//    $args .= "'" . TABLE_PUBLICATIONS . "',";
    //field_name
    ////$args .= "'image',";
    foreach($publications as $publication)
    {
        $tablerow = array();
        $button_delete = anchor('/admin/publications/delete/' . $publication->id,
                img( '/images/admin/buttons/delete.png'),
                array(	'class' => 'button_delete',
                        'title' => 'Удалить публикацию ' . $publication->name)
        );
        $button_users = anchor(
            '#',
            img( '/images/admin/buttons/users.png'),
                array(	'class' => 'button_users',
                        'title' => 'Редактировать состав авторов публикации',
                        'onclick' => 'usersSelector(\'Авторы публикации\', \''
                                     . TABLE_PUBLICATION_AUTHORS
                                     . '\',\'userid\', \'publicationid\', \''.$publication->id.'\')')
        );
        $text_ru = anchor('#',
            img( '/images/admin/buttons/document.png'),
            array(	'class' => 'button_edit_file',
                    'title' => 'Изменить файл русской публикации '.$publication->id,
                    'onclick' => "advFileLoader('publication_fulltext_ru', '$publication->id')"
                 )
        );
        $abstract_ru = anchor('#',
            img( '/images/admin/buttons/document.png'),
            array(	'class' => 'button_edit_file',
                    'title' => 'Изменить файл русской аннотации '.$publication->id,
                    'onclick' => "advFileLoader('publication_abstract_ru', '$publication->id')"
                 )
        );
        $text_en = anchor('#',
            img( '/images/admin/buttons/document.png'),
            array(	'class' => 'button_edit_file',
                    'title' => 'Изменить файл английской публикации '.$publication->id,
                    'onclick' => "advFileLoader('publication_fulltext_en', '$publication->id')"
                 )
        );
        $abstract_en = anchor('#',
            img( '/images/admin/buttons/document.png'),
            array(	'class' => 'button_edit_file',
                    'title' => 'Изменить файл русской аннотации '.$publication->id,
                    'onclick' => "advFileLoader('publication_abstract_en', '$publication->id')"
                 )
        );
        $text_ru = $text_ru;
        $text_en = $text_en;
        $abstract_ru = $abstract_ru;
        $abstract_en = $abstract_en;
        $tablerow[] = $publication->id;
        $tablerow[] = anchor('admin/publications/edit/' . $publication->id ,$publication->name);
        $tablerow[] = $publication->authorscount;
        $tablerow[] = $button_users;
        $tablerow[] = $text_ru;
        $tablerow[] = $abstract_ru;
        $tablerow[] = $text_en;
        $tablerow[] = $abstract_en;
        $tablerow[] = $button_delete;
        $data['rows'][] = $tablerow;
    }
$this->load->view('admin/table_view', $data);
}
else
{
    echo 'Нет записей';
}
/* End of file publications_view.php */
/* Location: ./application/views/admin/publications_view.php */
