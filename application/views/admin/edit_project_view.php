<div id="form_edit">
<?php
if( !isset($project->id) )
{
	$action = 'add';
	$button_title = 'Создать проект';
    $project->name_ru = '';
    $project->short_ru = '';
    $project->full_ru = '';

    $en_version_started = FALSE;
}
else
{
	$action = 'edit';
	$button_title = 'Внести изменения в проект';
    // Заполнено ли хотя бы одно поле английской версии
    $en_version_started =   $project->name_en !== '' ||
                            $project->short_en !== '' ||
                            $project->full_en !== '';
}

if (!isset($project->name_en)) 			{$project->name_en = '';};
if (!isset($project->short_en))         {$project->short_en = '';};
if (!isset($project->full_en))          {$project->full_en = '';};
if (!isset($project->url)) 				{$project->url = '';};

echo form_open_multipart('admin/projects/'.$action.'/action', array('class' => 'gray_form'));

echo form_label('Название проекта (русское)*', 'project_name_ru', array('class' => 'inline-block'));
echo form_input('project_name_ru', set_value('project_name_ru', $project->name_ru), 'class="long"');
echo form_error('project_name_ru');
echo br(2);


echo form_label('Краткое описание проекта (русское)*', 'project_short_ru', array('class' => 'inline-block'));
echo form_textarea('project_short_ru', set_value('project_short_ru', $project->short_ru), 'class="short"');
echo form_error('project_short_ru');
echo br(2);

echo form_label('Подробное описание проекта (русское)*', 'project_full_ru', array('class' => 'inline-block'));
echo form_textarea('project_full_ru', set_value('project_full_ru', $project->full_ru), 'class="short"');
echo form_error('project_full_ru');
echo br(2);

echo form_label('Ссылка на проект', 'project_url', array('class'=>'inline-block'));
echo form_input('project_url', set_value('project_url', $project->url), 'class = "long"');
echo form_error('project_url');
echo br(2);

echo '<div class="english-version">';
echo '<a href="#" class="showhide">Английская версия</a>';
if ($en_version_started)
    echo '<div class="hideble" style = "display:block;">';
else
    echo '<div class="hideble">';
echo '<hr>';

echo form_label('Название проекта (английское)', 'project_name_en', array('class' => 'inline-block'));
echo form_input('project_name_en', set_value('project_name_en', $project->name_en), 'class="long"');
echo form_error('project_name_en');
echo br(2);

echo form_label('Краткое описание проекта (английское)', 'project_short_en', array('class' => 'inline-block'));
echo form_textarea('project_short_en', set_value('project_short_en', $project->short_en), 'class="short"');
echo form_error('project_short_en');
echo br(2);

echo form_label('Подробное описание проекта (английское)', 'project_full_en', array('class' => 'inline-block'));
echo form_textarea('project_full_en', set_value('project_full_en', $project->full_en), 'class="short"');
echo form_error('project_full_en');
echo br(2);

echo '</div></div>';

if( isset($project->id) )
{
	echo form_hidden('project_id', $project->id);
}
echo br(2);
echo form_submit('user_submit', $button_title);
echo form_close();
?>
</div>