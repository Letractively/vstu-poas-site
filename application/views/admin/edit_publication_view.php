<div id="form_edit">
<?php
if( !isset($publication->id) )
{
	$action = 'add';
	$button_title = 'Создать публикацию';
}
else 
{
	$action = 'edit';
	$button_title = 'Внести изменения в публикацию';
}
if (!isset($publication->name_ru)) 			{$publication->name_ru = '';};
if (!isset($publication->name_en)) 			{$publication->name_en = '';};
if (!isset($publication->fulltext_ru))      {$publication->fulltext_ru = '';};
if (!isset($publication->fulltext_en))      {$publication->fulltext_en = '';};
if (!isset($publication->abstract_ru))      {$publication->abstract_ru = '';};
if (!isset($publication->abstract_en))      {$publication->abstract_en = '';};
if (!isset($publication->info_ru))          {$publication->info_ru = '';};
if (!isset($publication->info_en))          {$publication->info_en = '';};
if (!isset($publication->year)) 			{$publication->year = '';};

if (!isset($errors->nameforgotten))         {$errors->nameforgotten = false;}
if (!isset($errors->yearforgotten))         {$errors->yearforgotten = false;}





echo form_open('admin/publications/'.$action.'/action');

echo form_label_adv('Название публикации (русское)*', 'publication_name_ru', 'inline-block not-null', $errors->nameforgotten, ' forgotten');
echo form_textarea('publication_name_ru', $publication->name_ru, 'class="short"');
echo br(2);

echo form_label_adv('Год публикации*', 'publication_year', 'inline-block not-null', $errors->yearforgotten, ' forgotten');
echo form_input('publication_year', $publication->year, 'maxlength="4" style = width:50px');
echo br(2);

echo form_label('Ссылка, по которой можно найти текст публикации (на русском)', 'publication_fulltext_ru', array('class'=>'inline-block'));
echo form_input('publication_fulltext_ru', $publication->fulltext_ru, 'maxlength="300" style = width:400px');
echo br(2);

echo form_label('Ссылка, по которой можно найти аннотацию публикации (на русском)', 'publication_abstract_ru', array('class'=>'inline-block'));
echo form_input('publication_abstract_ru', $publication->abstract_ru, 'maxlength="300" style = width:400px');
echo br(2);

echo form_label('Дополнительная информация (на русском)', 'publication_info_ru', array('class'=>'inline-block'));
echo form_textarea('publication_info_ru', $publication->info_ru, 'class="short"');
echo br(2);

echo '<a href="#" id="showhide_en">Английская версия</a>';
echo '<div class="hideble">';
echo '<hr>';
echo form_label('Название публикации (английское)', 'publication_name_en', array('class'=>'inline-block'));
echo form_textarea('publication_name_en', $publication->name_en, 'class="short"');
echo br(2);

echo form_label('Ссылка, по которой можно найти текст публикации (на английском)', 'publication_fulltext_en', array('class'=>'inline-block'));
echo form_input('publication_fulltext_en', $publication->fulltext_en, 'maxlength="300" style = width:400px');
echo br(2);

echo form_label('Ссылка, по которой можно найти аннотацию публикации (на английском)', 'publication_abstract_en', array('class'=>'inline-block'));
echo form_input('publication_abstract_en', $publication->abstract_en, 'maxlength="300" style = width:400px');
echo br(2);

echo form_label('Дополнительная информация (на английском)', 'publication_info_en', array('class'=>'inline-block'));
echo form_textarea('publication_info_en', $publication->info_en, 'class="short"');
echo br(2);
echo '</div>';

if( isset($publication->id) )
{
	echo form_hidden('publication_id', $publication->id);
}
echo br(2);
echo form_submit('user_submit', $button_title);
echo form_close();
?>
</div>