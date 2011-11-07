<div id="form_edit">
<?php
if( !isset($direction->id) )
{
	$action = 'add';
	$button_title = 'Создать направление';
}
else
{
	$action = 'edit';
	$button_title = 'Внести изменения в направление';
}

if (!isset($direction->name_ru)) 			{	$direction->name_ru = ''; };
if (!isset($direction->name_en)) 			{	$direction->name_en = ''; };
if (!isset($direction->description_ru)) 	{	$direction->description_ru = ''; };
if (!isset($direction->description_en)) 	{	$direction->description_en = ''; };

if (!isset($errors->nameruforgotten))       {   $errors->nameruforgotten = false;};
if (!isset($errors->nameenforgotten))       {   $errors->nameenforgotten = false;};

$en_version_started = $direction->name_en !== '' || $direction->description_en !== '';

echo form_open('admin/directions/'.$action.'/action');

echo form_label_adv(    'Название направления (русское)*', 
                        'direction_name_ru', 
                        'inline-block not-null', 
                        $errors->nameruforgotten, 
                        'forgotten');
echo form_input('direction_name_ru', $direction->name_ru, 'maxlength="150" style = width:400px');
echo br(2);

echo form_label('Описание направления (русское)', 'direction_description_ru', array('class'=>'inline-block'));
echo form_textarea('direction_description_ru', $direction->description_ru, 'class="short"');
echo br(2);

echo '<a href="#" id="showhide_en">Английская версия</a>';
if ($en_version_started)
    echo '<div class="hideble" style = "display:block;">';
else
    echo '<div class="hideble">';
echo '<hr>';
echo form_label_adv(    'Название направления (английское)', 
                        'direction_name_en', 
                        'inline-block', 
                        $errors->nameenforgotten, 
                        'not-null forgotten');
echo form_input('direction_name_en', $direction->name_en, 'maxlength="150" style = width:400px');
echo br(2);
echo form_label('Описание направления (английское)', 'direction_description_en', array('class'=>'inline-block'));
echo form_textarea('direction_description_en', $direction->description_en, 'class="short"');
echo '</div>';
if( isset($direction->id) )
{
	echo form_hidden('direction_id', $direction->id);
}
echo br(2);
echo form_submit('user_submit', $button_title);
echo form_close();
?>
</div>
