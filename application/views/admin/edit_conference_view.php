<div id="form_edit">
    <?php
    if(!isset($conference->id)){
        $action = 'add';
        $submit = 'Добавить запись';

        $conference->name_ru      = '';
        $conference->info_ru     = '';
        $conference->begin      = '';
        $conference->end     = '';
        $en_version_started = false;
    }
    else {
        $action = 'edit';
        $submit = 'Применить изменения';
        // Заполнено ли хотя бы одно поле английской версии
        $en_version_started =   $conference->name_en !== null ||
                                $conference->info_en !== null;
    }
    if (!isset($conference->name_en))       $conference->name_en = '';
    if (!isset($conference->info_en))       $conference->info_en = '';
    if (!isset($conference->url))           $conference->url = '';

?>
<?php

    echo form_open('admin/conferences/' . $action . '/action', array('class' => 'gray_form'));

// Название конференции (русское)*
    echo form_label('Название конференции (русское)*', 'conference_name_ru', array('class' => 'inline-block'));
    echo form_textarea('conference_name_ru', set_value('conference_name_ru', $conference->name_ru), 'maxlength="300" class="short"');
    echo form_error('conference_name_ru');
    echo br(2);

// Информация о конференции (русская)*
    echo form_label('Информация о конференции (русская)*', 'conference_info_ru', array('class' => 'inline-block'));
    echo form_textarea('conference_info_ru', set_value('conference_info_ru', $conference->info_ru), 'class="short elrte_editor_mini"');
    echo form_error('conference_info_ru');
    echo br(2);

// Дата открытия конференции*
    echo form_label('Дата открытия конференции*', 'conference_begin', array('class' => 'inline-block'));
    echo form_input('conference_begin', set_value('conference_begin', $conference->begin), 'class="date" maxlength="10"');
    echo form_error('conference_begin');
    echo br(2);

// Дата закрытия конференции*
    echo form_label('Дата закрытия конференции*', 'conference_end', array('class' => 'inline-block'));
    echo form_input('conference_end', set_value('conference_end', $conference->end), 'class="date" maxlength="10"');
    echo form_error('conference_end');
    echo br(2);

// Ссылка с дополнительной информацией
    echo form_label('Ссылка с дополнительной информацией', 'conference_url', array('class' => 'inline-block'));
    echo form_input('conference_url', set_value('conference_url', $conference->url), 'maxlength="300" class="long"');
    echo form_error('conference_url');
    echo br(2);

echo '<div class="english-version">';
echo '<a href="#" class="showhide">Английская версия</a>';
if ($en_version_started)
    echo '<div class="hideble" style = "display:block;">';
else
    echo '<div class="hideble">';
echo '<hr>';

// Название конференции (английское)
    echo form_label('Название конференции (английское)', 'conference_name_en', array('class' => 'inline-block'));
    echo form_textarea('conference_name_en', set_value('conference_name_en', $conference->name_en), 'maxlength="300" class="short"');
    echo form_error('conference_name_en');
    echo br(2);

// Информация о конференции (английская)
    echo form_label('Информация о конференции (английская)', 'conference_info_en', array('class' => 'inline-block'));
    echo form_textarea('conference_info_en', set_value('conference_info_en', $conference->info_en), 'class="short elrte_editor_mini"');
    echo form_error('conference_info_en');
    echo br(2);

echo '</div></div>';

if( isset($conference->id) )
{
	echo form_hidden('conference_id', $conference->id);
}
echo br(2);
echo form_submit('conference_submit', $submit);
echo form_close();
?>
</div>
