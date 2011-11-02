<div id="form_edit">
<?php


if( !isset($project->id) )
{
	$action = 'add';
	$button_title = 'Создать проект';
}
else 
{
	$action = 'edit';
	$button_title = 'Внести изменения в проект';
}
if (!isset($project->name_ru)) 			{$project->name_ru = '';};
if (!isset($project->name_en)) 			{$project->name_en = '';};
if (!isset($project->description_ru)) 	{$project->description_ru = '';};
if (!isset($project->description_en)) 	{$project->description_en = '';};
if (!isset($project->url)) 				{$project->url = '';};
if (!isset($project->image)) 			{$project->image = '';};







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

if( isset($project->id) )
{
	echo form_hidden('project_id', $project->id);
}
echo br(2);
echo form_submit('user_submit', $button_title);
echo form_close();
?>
</div>