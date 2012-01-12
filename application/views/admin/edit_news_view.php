<div id="elfinder"></div>
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
$is_photo_show = TRUE;
if( ! isset($news->url)) 		$news->url 		= '';
if( ! isset($news->name_ru)) 	$news->name_ru 	= '';
if( ! isset($news->notice_ru)) 	$news->notice_ru = '';
if( ! isset($news->text_ru)) 	$news->text_ru = '';
if( ! isset($news->text_en)) 	$news->text_en = '';
if( ! isset($news->name_en)) 	$news->name_en = '';
if( ! isset($news->is_photo_show) || $news->is_photo_show == 0) $is_photo_show = FALSE;	
if( ! isset($news->category)) 	$news->category = '0';
if( ! isset($news->notice_en) || $news->notice_en == '' ) { $news->notice_en = ''; $is_there_en = FALSE; }
if( !isset($news->id)) $news->directory = 'error'; else $news->directory = 'news/'.$news->id;

echo form_open('admin/news/'.$action.'/action', array('class' => 'gray_form'));
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

echo form_label('Категория', 'news_category', array('class' => 'inline-block'));
echo form_dropdown('news_category',
	array(
	'1'  => 'Для всех',
	'2'  => 'Для студентов и преподавателей',
	'3'  => 'Для преподавателей'
	), 
	$news->category);
	
$data_for_checkbox = array( 
	'name'		=> 'news_is_photo_show',
	'id'		=> 'news_is_photo_show',
	'value'		=> 'news_is_photo_show',
	'checked'	=> $is_photo_show,
	);

echo form_label('Показать прикреплённые фотографии в конце новости', 'news_is_photo_show', array('class'=>'inline-block'));
echo form_checkbox($data_for_checkbox).br().br();
	

echo form_label('Анонс', 'news_notice_ru', array('class'=>'inline-block', 'style'=>'height:21px'));
echo form_textarea('news_notice_ru', $news->notice_ru, 'class="elrte_editor_news_mini"').br();

echo form_label('Текст статьи', 'news_text_ru', array('class'=>'inline-block', 'style'=>'height:21px'));
echo form_textarea('news_text_ru', $news->text_ru, 'class="elrte_editor_news"').br();


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

// Поля для английской версии новости. Если английской версии нет, поля скрываем
if( !$is_there_en )
{
	echo '<script>	
	$(document).ready(function(){
		$("#news_en_version").css("display", "none");
	});
	</script>';
}
echo '<div id="news_en_version" class="news_en_version js_obj_hidden">';

echo form_label('Name', 'news_name_en', array('class'=>'inline-block'));
echo form_input('news_name_en', $news->name_en, 'maxlength="40"').br();

echo form_label('Notice', 'news_notice_en', array('class'=>'inline-block', 'style'=>'height:21px'));
echo form_textarea('news_notice_en', $news->notice_en, 'class="elrte_editor_news_mini"').br();

echo form_label('Text of news', 'news_text_en', array('class'=>'inline-block', 'style'=>'height:21px'));
echo form_textarea('news_text_en', $news->text_en, 'class="elrte_editor_news"').br();
echo '</div>';


if( isset($news->id) )
{
	echo form_hidden('news_id', $news->id);
}
echo form_submit('news_submit', $button_title);
echo form_close();
?>
</div>

<script>
/** Подключение HTML редактора в к объектам с классом "elrte_editor" */
var dialog;
<?php if($news->directory != 'error'): ?>
function open_elfinder_news(callback)
{
	if (typeof dialog === "undefined")
	{
		dialog = $('#elfinder').dialogelfinder({
			url: '/elfinder_connector',
			customData: {
				dir: '<?=$news->directory;?>',
				obj_type: <?=OBJ_TYPE_NEWS;?>,
				obj_id: <?=$news->id;?>
			},
			commandsOptions: {getfile: {oncomplete : 'close'}},
			getFileCallback: callback
		});
	} else {dialog.dialogelfinder('open');}
};
<? endif;?>

var elrte_options_news = {
	lang         : 'ru',
	styleWithCSS : false,
	height       : 320,
	fmAllow		 : true,
	toolbar      : 'maxi' 
	<?php if($news->directory != 'error'): ?>
	, fmOpen : open_elfinder_news
	<? endif;?>
};
var elrte_options_news_mini = {
		lang         : 'ru',
		styleWithCSS : false,
		height       : 140,
		fmAllow		 : true,
		toolbar      : 'maxi' 
		<?php if($news->directory != 'error'): ?>
		, fmOpen : open_elfinder_news
		<? endif;?>
	};
$('.elrte_editor_news').elrte(elrte_options_news);
$('.elrte_editor_news_mini').elrte(elrte_options_news_mini);
</script>