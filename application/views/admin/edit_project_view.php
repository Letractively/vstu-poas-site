<div id="form_edit">
<?php
$action = 'add';
$button_title = 'Создать проект';
$project->name_ru = '';
$project->name_en = '';
$project->description_ru = '';
$project->description_en = '';
$project->url = '';
$project->image = '';

echo form_open('admin/projects/'.$action.'/action');

echo form_label('Название проекта (русское)', 'project_name_ru', array('class'=>'inline-block'));
echo form_input('project_name_ru', $project->name_ru, 'maxlength="150" style = width:400px');

echo br(2);
echo form_label('Описание проекта (русское)', 'project_description_ru', array('class'=>'inline-block'));
echo form_textarea('project_description_ru', $project->description_ru);

echo br(2);
echo form_label('Ссылка на проект', 'project_url', array('class'=>'inline-block'));
echo form_input('project_url', $project->url, 'style = width:400px');

echo br(2);
echo form_label('Название проекта (английское)', 'project_name_en', array('class'=>'inline-block'));
echo form_input('project_name_en', $project->name_en, 'maxlength="150" style = width:400px');

echo br(2);
echo form_label('Описание проекта (английское)', 'project_description_en', array('class'=>'inline-block'));
echo form_textarea('project_description_en', $project->description_en);

echo br(2);
echo form_label('Изображение для проекта', 'project_image', array('class'=>'inline-block'));
// @todo изображение

echo br(2);
echo form_submit('user_submit', $button_title);
echo form_close();
?>
</div>