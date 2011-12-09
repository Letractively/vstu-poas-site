<div id="form_edit">
<?php
if( !isset($publication->id) )
{
	$action = 'add';
	$button_title = 'Создать публикацию';
    $publication->name_ru = '';
    $publication->year = '';
}
else
{
	$action = 'edit';
	$button_title = 'Внести изменения в публикацию';
}
if (!isset($publication->name_en)) 			{$publication->name_en = '';}
if (!isset($publication->fulltext_ru))      {$publication->fulltext_ru = '';}
if (!isset($publication->fulltext_en))      {$publication->fulltext_en = '';}
if (!isset($publication->abstract_ru))      {$publication->abstract_ru = '';}
if (!isset($publication->abstract_en))      {$publication->abstract_en = '';}
if (!isset($publication->info_ru))          {$publication->info_ru = '';}
if (!isset($publication->info_en))          {$publication->info_en = '';}


echo form_open('admin/publications/'.$action.'/action');

// Вывод названия публикации на русском (обязательный параметр)
echo form_label('Название публикации (русское)*', 'publication_name_ru', array('class' => 'inline-block'));
echo form_textarea('publication_name_ru', set_value('publication_name_ru', $publication->name_ru), 'maxlength="300" class="long"');
echo form_error('publication_name_ru');
echo br(2);

// Вывод года публикации (обязательный параметр)
echo form_label('Год публикации*', 'publication_year', array('class' => 'inline-block'));
echo form_input('publication_year', set_value('publication_year', $publication->year), 'maxlength="4" style = width:50px');
echo form_error('publication_year');
echo br(2);

// Вывод ссылки на полный текст публикации на русском языке
echo form_label('Ссылка, по которой можно найти текст публикации (на русском)', 'publication_fulltext_ru', array('class'=>'inline-block'));
echo form_input('publication_fulltext_ru', set_value('publication_fulltext_ru', $publication->fulltext_ru), 'maxlength="300" class=long');
echo form_error('publication_fulltext_ru');
echo br(2);

// Вывод ссылки на аннотацияю публикации на русском языке
echo form_label('Ссылка, по которой можно найти аннотацию публикации (на русском)', 'publication_abstract_ru', array('class'=>'inline-block'));
echo form_input('publication_abstract_ru', set_value('publication_abstract_ru', $publication->fulltext_ru), 'maxlength="300" class=long');
echo form_error('publication_abstract_ru');
echo br(2);

// Вывод дополнительной информации о публикации на русском языке
echo form_label('Дополнительная информация (на русском)', 'publication_info_ru', array('class'=>'inline-block'));
echo form_textarea('publication_info_ru', set_value('publication_info_ru', $publication->info_ru), 'class="short elrte_editor_mini"');
echo form_error('publication_info_ru');
echo br(2);

echo '<div class="english-version">';
echo '<a href="#" class="showhide">Английская версия</a>';
echo '<div class="hideble">';
echo '<hr>';
// Вывод названия публикации на английском языке
echo form_label('Название публикации (английское)', 'publication_name_en', array('class' => 'inline-block'));
echo form_textarea('publication_name_en', set_value('publication_name_en', $publication->name_en), 'maxlength="300" class="long"');
echo form_error('publication_name_en');
echo br(2);

// Вывод ссылки на полный текст публикации на английском языке
echo form_label('Ссылка, по которой можно найти текст публикации (на английском)', 'publication_fulltext_en', array('class'=>'inline-block'));
echo form_input('publication_fulltext_en', set_value('publication_fulltext_en', $publication->fulltext_ru), 'maxlength="300" class=long');
echo form_error('publication_fulltext_en');
echo br(2);

// Вывод ссылки на аннотацияю публикации на английском языке
echo form_label('Ссылка, по которой можно найти аннотацию публикации (на английском)', 'publication_abstract_en', array('class'=>'inline-block'));
echo form_input('publication_abstract_en', set_value('publication_abstract_en', $publication->fulltext_ru), 'maxlength="300" class=long');
echo form_error('publication_abstract_en');
echo br(2);

// Вывод дополнительной информации о публикации на английском языке
echo form_label('Дополнительная информация (на английском)', 'publication_abstract_en', array('class'=>'inline-block'));
echo form_textarea('publication_abstract_en', set_value('publication_abstract_en', $publication->info_ru), 'class="short elrte_editor_mini"');
echo form_error('publication_abstract_en');
echo br(2);
echo '</div></div>';

if( isset($publication->id) )
{
	echo form_hidden('publication_id', $publication->id);
}
echo br(2);
echo form_submit('user_submit', $button_title);
echo form_close();
?>
</div>