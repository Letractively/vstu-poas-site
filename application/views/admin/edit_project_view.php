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
if (!isset($project->members))          {$project->members = array();};
// Заполнено ли хотя бы одно поле английской версии
$en_version_started =   $project->name_en !== '' ||
                        $project->description_en !== '';

if (!isset($errors->nameruforgotten))           {$errors->nameruforgotten = false;};
if (!isset($errors->descriptionruforgotten))    {$errors->descriptionruforgotten = false;};

if (!isset($errors->nameenforgotten))           {$errors->nameenforgotten = false;};
if (!isset($errors->descriptionenforgotten))    {$errors->descriptionenforgotten = false;};

echo form_open_multipart('admin/projects/'.$action.'/action');

echo form_label_adv('Название проекта (русское)*', 
                    'project_name_ru', 
                    'inline-block not-null', 
                    $errors->nameruforgotten, 
                    'forgotten');
echo form_input('project_name_ru', $project->name_ru, 'maxlength="300" style = width:400px');
echo br(2);

echo form_label_adv('Описание проекта (русское)*', 
                    'project_description_ru', 
                    'inline-block not-null', 
                    $errors->descriptionruforgotten, 
                    'forgotten');
echo form_textarea('project_description_ru', $project->description_ru, 'class="short"');
echo br(2);

echo form_label('Ссылка на проект', 'project_url', array('class'=>'inline-block'));
echo form_input('project_url', $project->url, 'style = width:400px');
echo br(2);

echo form_label('Изображение для проекта', 'project_image', array('class'=>'inline-block'));
echo form_upload('project_image', $project->image);
echo br(2);

$data['label'] = 'Участники проекта';
$data['id'] = 'project_members';
$data['users'] = array();
foreach($extra->users as $user)
{
    $data['users'][$user->id] = $user->surname.' '.$user->name.' '.$user->patronymic;
}
$data['select'] = array();
if ($project->members)
    foreach($project->members as $member)
    {
        if(isset($member->id))
            $data['select'][] = $member->id;
        else
            $data['select'][] = $member;
    }
$this->load->view('admin/users_list_view', $data);
echo br(2);

echo '<a href="#" id="showhide_en">Английская версия</a>';
if ($en_version_started)
    echo '<div class="hideble" style = "display:block;">';
else
    echo '<div class="hideble">';
echo '<hr>';

echo form_label_adv('Название проекта (английское)', 
                    'project_name_en', 
                    'inline-block', 
                    $errors->nameenforgotten, 
                    'not-null forgotten');
echo form_input('project_name_en', $project->name_en, 'maxlength="300" style = width:400px');
echo br(2);

echo form_label_adv('Описание проекта (английское)', 
                    'project_description_en', 
                    'inline-block', 
                    $errors->descriptionenforgotten, 
                    'not-null forgotten');
echo form_textarea('project_description_en', $project->description_en, 'class="short"');
echo br(2);

echo '</div>';

if( isset($project->id) )
{
	echo form_hidden('project_id', $project->id);
}
echo br(2);
echo form_submit('user_submit', $button_title);
echo form_close();
?>
</div>