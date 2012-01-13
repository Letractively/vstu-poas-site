<div id="form_edit">
<?php
if( !isset($direction->id) )
{
	$action = 'add';
	$button_title = 'Создать направление';
    $direction->name_ru = '';
    $direction->short_ru = '';
    $en_version_started = FALSE;
}
else
{
	$action = 'edit';
	$button_title = 'Внести изменения в направление';
    // Заполнено ли хотя бы одно поле английской версии
    $en_version_started =   $direction->name_en !== null ||
                            $direction->short_en !== null ||
                            $direction->full_en !== null;
}

if (!isset($direction->full_ru)) 			{	$direction->full_ru = ''; };
if (!isset($direction->name_en)) 			{	$direction->name_en = ''; };
if (!isset($direction->short_en))           {	$direction->short_en = ''; };
if (!isset($direction->full_en))            {	$direction->full_en = ''; };



echo form_open('admin/directions/'.$action.'/action', array('class' => 'gray_form'));

// Ввод русского названия направления (обязательный параметр)
echo form_label('Название направления (русское)*', 'direction_name_ru', array('class' => 'inline-block'));
echo form_input('direction_name_ru', set_value('direction_name_ru', $direction->name_ru), 'maxlength="150" class="long"');
echo form_error('direction_name_ru');
echo br(2);

// Ввод русского краткого описания направления (обязательный параметр)
echo form_label('Краткое описание направления (русское)*', 'direction_short_ru', array('class' => 'inline-block'));
echo form_textarea('direction_short_ru', set_value('direction_short_ru', $direction->short_ru), 'class="elrte_editor_mini"');
echo form_error('direction_short_ru');
echo br(2);

// Ввод русского подробного описания направления
echo form_label('Подробное описание направления (русское)', 'direction_full_ru', array('class' => 'inline-block'));
echo form_textarea('direction_full_ru', set_value('direction_full_ru', $direction->full_ru), 'class="elrte_editor_mini"');
echo form_error('direction_full_ru');
echo br(2);

echo '<div class="english-version">';
echo '<a href="#" class="showhide">Английская версия</a>';
if ($en_version_started)
    echo '<div class="hideble" style = "display:block;">';
else
    echo '<div class="hideble">';
echo '<hr>';

// Ввод английского названия направления (обязательный параметр)*
echo form_label('Название направления (английское)*', 'direction_name_en', array('class' => 'inline-block'));
echo form_input('direction_name_en', set_value('direction_name_en', $direction->name_en), 'maxlength="150" class="long"');
echo form_error('direction_name_en');
echo br(2);

// Ввод английского краткого описания направления (обязательный параметр)*
echo form_label('Краткое описание направления (английское)*', 'direction_short_en', array('class' => 'inline-block'));
echo form_textarea('direction_short_en', set_value('direction_short_en', $direction->short_en), 'class="elrte_editor_mini"');
echo form_error('direction_short_en');
echo br(2);

// Ввод английского подробного описания направления
echo form_label('Подробное описание направления (английское)', 'direction_full_en', array('class' => 'inline-block'));
echo form_textarea('direction_full_en', set_value('direction_full_en', $direction->full_en), 'class="elrte_editor_mini"');
echo form_error('direction_full_en');
echo br(2);

echo '</div></div>';
if( isset($direction->id) )
{
	echo form_hidden('direction_id', $direction->id);
}
echo br(2);
echo form_submit('user_submit', $button_title);
echo form_close();
?>
</div>
