<?php
echo anchor('/admin/publications/add', 'Добавить публикацию');
echo br(2);

if (count($publications) > 0)
{
    $data['rows'] = array();
    $data['classes'] = array('publication', 'count','','','','','','delete');
    $data['headers'] = array('Публикация', 'Авторов', '','Рус. текст','Рус. аннотац.','Анг. текст','Анг. аннотац.','');
    $args = '';
    // upload_path
    $args .= "'./uploads/publications/',";
    // allowed_types
    $args .= "'pdf|doc|docx|odt|rtf|txt',";
    // max_size
    $args .= "'10000',";
    // max_width
    $args .= "'1024',";
    // max_height
    $args .= "'800',";
    //table_name
    $args .= "'" . TABLE_PUBLICATIONS . "',";
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
            img( '/images/admin/buttons/user.png'),
            array(	'class' => 'button_edit_file',
                    'title' => 'Изменить файл русской публикации '.$publication->id,
                    'onclick' => 'fileLoader(' .
                                    $args .
                                    "'fulltext_ru_file'," .
                                    "'" .
                                    $publication->id .
                                    "','" .
                                    $this->config->item('base_url') .
                                    $this->{MODEL_PUBLICATION}->get_file($publication->id,'fulltext_ru_file') .
                                    "')"
                 )
        );
        $abstract_ru = anchor('#',
            img( '/images/admin/buttons/user.png'),
            array(	'class' => 'button_edit_file',
                    'title' => 'Изменить файл русской аннотации '.$publication->id,
                    'onclick' => 'fileLoader(' .
                                    $args .
                                    "'abstract_ru_file'," .
                                    "'" .
                                    $publication->id .
                                    "','" .
                                    $this->config->item('base_url') .
                                    $this->{MODEL_PUBLICATION}->get_file($publication->id,'abstract_ru_file') .
                                    "')"
                 )
        );
        $text_en = anchor('#',
            img( '/images/admin/buttons/user.png'),
            array(	'class' => 'button_edit_file',
                    'title' => 'Изменить файл английской публикации '.$publication->id,
                    'onclick' => 'fileLoader(' .
                                    $args .
                                    "'fulltext_en_file'," .
                                    "'" .
                                    $publication->id .
                                    "','" .
                                    $this->config->item('base_url') .
                                    $this->{MODEL_PUBLICATION}->get_file($publication->id,'fulltext_en_file') .
                                    "')"
                 )
        );
        $abstract_en = anchor('#',
            img( '/images/admin/buttons/user.png'),
            array(	'class' => 'button_edit_file',
                    'title' => 'Изменить файл русской аннотации '.$publication->id,
                    'onclick' => 'fileLoader(' .
                                    $args .
                                    "'abstract_en_file'," .
                                    "'" .
                                    $publication->id .
                                    "','" .
                                    $this->config->item('base_url') .
                                    $this->{MODEL_PUBLICATION}->get_file($publication->id,'abstract_en_file') .
                                    "')"
                 )
        );
        $tablerow[] = anchor('admin/publications/edit/' . $publication->id,$publication->name);
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
