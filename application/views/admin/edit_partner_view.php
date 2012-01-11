<div id="form_edit">
    <?php
    if(!isset($partner->id))
    {
        $action = 'add';
        $submit = 'Добавить запись';

        $partner->name_ru      = '';
        $partner->short_ru     = '';
        $partner->full_ru      = '';
        $en_version_started = false;
    }
    else
    {
        $action = 'edit';
        $submit = 'Применить изменения';
        // Заполнено ли хотя бы одно поле английской версии
        $en_version_started =   $partner->name_en !== null ||
                                $partner->short_en !== null ||
                                $partner->full_en !== null;
    }
    if (!isset($partner->name_en))      $partner->name_en = '';
    if (!isset($partner->short_en))     $partner->short_en = '';
    if (!isset($partner->full_en))      $partner->full_en = '';
    if (!isset($partner->url))          $partner->url = '';
    if (!isset($partner->image))        $partner->image = '';


?>
<?php

    echo form_open('admin/partners/' . $action . '/action', array('class' => 'gray_form'));

// Ввод русского имени партнера (обязательный параметр)
    echo form_label('Имя партнера (русское)*', 'partner_name_ru', array('class' => 'inline-block'));
    echo form_input('partner_name_ru', set_value('partner_name_ru', $partner->name_ru), 'maxlength="300" class="long"');
    echo form_error('partner_name_ru');
    echo br(2);

// Ввод краткого русского описания партнера (обязательный параметр)
    echo form_label('Краткое описание партнера (русское)*', 'partner_short_ru', array('class' => 'inline-block'));
    echo form_textarea('partner_short_ru', set_value('partner_short_ru', $partner->short_ru), 'maxlength="800" class="short elrte_editor_mini"');
    echo form_error('partner_short_ru');
    echo br(2);

// Ввод русского описания партнера
    echo form_label('Описание партнера (русское)*', 'partner_full_ru', array('class' => 'inline-block'));
    echo form_textarea('partner_full_ru', set_value('partner_full_ru', $partner->full_ru), 'class="short elrte_editor_mini"');
    echo form_error('partner_full_ru');
    echo br(2);

// Ввод ссылки на сайт партнера
    echo form_label('Ссылка на сайт партнера', 'partner_url', array('class' => 'inline-block'));
    echo form_input('partner_url', set_value('partner_url', $partner->url), 'maxlength="300" class="long"');
    echo form_error('partner_url');
    echo br(2);

echo '<div class="english-version">';
echo '<a href="#" class="showhide">Английская версия</a>';
if ($en_version_started)
    echo '<div class="hideble" style = "display:block;">';
else
    echo '<div class="hideble">';
echo '<hr>';

// Ввод английского имени партнера
    echo form_label('Имя партнера (английское)', 'partner_name_en', array('class' => 'inline-block'));
    echo form_input('partner_name_en', set_value('partner_name_en', $partner->name_en), 'maxlength="300" class="long"');
    echo form_error('partner_name_en');
    echo br(2);

// Ввод краткого английского описания партнера
    echo form_label('Краткое описание партнера (английское)', 'partner_short_en', array('class' => 'inline-block'));
    echo form_textarea('partner_short_en', set_value('partner_short_en', $partner->short_en), 'maxlength="800" class="short elrte_editor_mini"');
    echo form_error('partner_short_en');
    echo br(2);

// Ввод английского описания партнера
    echo form_label('Описание партнера (английское)', 'partner_full_en', array('class' => 'inline-block'));
    echo form_textarea('partner_full_en', set_value('partner_full_en', $partner->full_en), 'class="short elrte_editor_mini"');
    echo form_error('partner_full_en');
    echo br(2);
echo '</div></div>';

if( isset($partner->id) )
{
	echo form_hidden('partner_id', $partner->id);
}
echo br(2);
echo form_submit('partner_submit', $submit);
echo form_close();
?>
</div>
