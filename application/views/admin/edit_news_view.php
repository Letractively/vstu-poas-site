<div id="form_edit">
<?php
if(!isset($news->name_ru)) 
{
	$news->name_ru = '';
	$sdfsdfsf->sdad = '';
	$button_title = 'Добавить';
	$action = 'add';
} 
else 
{
	$button_title = 'Сохранить';
	$action = 'edit';
}

$is_there_en = TRUE;
if( ! isset($news->url)) 		$news->url 		= '';
if( ! isset($news->name_ru)) 	$news->name_ru 	= '';
if( ! isset($news->notice_ru)) 	$news->notice_ru = '';
if( ! isset($news->text_ru)) 	$news->text_ru = '';
if( ! isset($news->text_en)) 	$news->text_en = '';
if( ! isset($news->name_en)) 	$news->name_en = '';
if( ! isset($news->notice_en) || $news->notice_en == '' ) { $news->notice_en = ''; $is_there_en = FALSE; }

echo form_open('admin/news/'.$action.'/action');
echo form_label('Название', 'news_name_ru', array('class'=>'inline-block'));
echo form_input('news_name_ru', $news->name_ru, 'maxlength="40"').br();
if( $action == 'edit' )
{
	echo form_label('Url-адрес', 'news_url', array('class'=>'inline-block'));
	echo form_input('news_url', $news->url, 'disabled class="js_obj_visability valid_url"');
	echo form_label('Не изменять url-адрес', 'news_url_not_change', array('class'=>'inline'));
	echo form_checkbox('news_url_not_change', 'url_not_change', TRUE, 'class="js_checkbox_visability"');
}
else 
{
	echo form_label('Url-адрес', 'news_url', array('class'=>'inline-block'));
	echo form_input('news_url', $news->url, 'class="valid_url"');
}
echo br();


echo form_label('Анонс', 'news_notice_ru', array('class'=>'inline-block', 'style'=>'height:21px'));
echo form_textarea('news_notice_ru', $news->notice_ru, 'class="elrte_editor_mini"').br();

echo form_label('Текст статьи', 'news_text_ru', array('class'=>'inline-block', 'style'=>'height:21px'));
echo form_textarea('news_text_ru', $news->text_ru, 'class="elrte_editor"').br();


echo '<hr/>';



$data_for_checkbox = array( 
	'name'		=> 'is_news_en',
	'id'		=> 'is_news_en',
	'value'		=> 'is_news_en',
	'checked'	=> $is_there_en,
	'class'		=> 'js_checkbox_hidden'
	);

echo form_label('Английская версия статьи', 'is_news_en', array('class'=>'inline'));
echo form_checkbox($data_for_checkbox).br().br();

if( $is_there_en )
{
	echo '<div class="news_en_version js_obj_hidden">';
}
else 
{
	echo '<div class="news_en_version js_obj_hidden" style="display:none">';
}
echo form_label('Name', 'news_name_en', array('class'=>'inline-block'));
echo form_input('news_name_en', $news->name_en, 'maxlength="40"').br();

echo form_label('Notice', 'news_notice_en', array('class'=>'inline-block', 'style'=>'height:21px'));
echo form_textarea('news_notice_en', $news->notice_en, 'class="elrte_editor_mini"').br();

echo form_label('Text of news', 'news_text_en', array('class'=>'inline-block', 'style'=>'height:21px'));
echo form_textarea('news_text_en', $news->text_en, 'class="elrte_editor"').br();
echo '</div>';


if( isset($news->id) )
{
	echo form_hidden('news_id', $news->id);
}
echo form_submit('news_submit', $button_title);
echo form_close();
?>
</div>