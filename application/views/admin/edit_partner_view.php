<div id="form_edit">
<?php
//print_r($errors);
if( !isset($partner->id) )
{
	$action = 'add';
	$button_title = 'Добавить данные партнера';
}
else 
{
	$action = 'edit';
	$button_title = 'Изменить данные партнера';
}
if (!isset($partner->name_ru)) 			{$partner->name_ru = '';};
if (!isset($partner->name_en)) 			{$partner->name_en = '';};
if (!isset($partner->short_ru))         {$partner->short_ru = '';};
if (!isset($partner->short_en))         {$partner->short_en = '';};
if (!isset($partner->full_ru))          {$partner->full_ru = '';};
if (!isset($partner->full_en))          {$partner->full_en = '';};
if (!isset($partner->url)) 				{$partner->url = '';};
if (!isset($partner->image)) 			{$partner->image = '';};

if (!isset($errors->nameforgotten))     {$errors->nameforgotten = false;};
if (!isset($errors->shortforgotten))    {$errors->shortforgotten = false;};
if (!isset($errors->fullforgotten))     {$errors->fullforgotten = false;};

echo form_open('admin/partners/' . $action . '/action');

// Ввод русского имени партнера (обязательный параметр)
$nameclass = 'inline-block not-null';
if ($errors->nameforgotten)
    $nameclass .= ' forgotten';
echo form_label('Имя партнера (русское) *', 'partner_name_ru', array('class'=>$nameclass));
echo form_input('partner_name_ru', $partner->name_ru, 'maxlength="300" style = width:400px');
echo br(2);

// Ввод краткого русского описания партнера (обязательный параметр)
$shortclass = 'inline-block not-null';
if ($errors->shortforgotten)
    $shortclass .= ' forgotten';
echo form_label('Краткое описание партнера (русское) *', 'partner_short_ru', array('class'=>$shortclass));
echo form_textarea('partner_short_ru', $partner->short_ru);
echo br(2);

// Ввод русского описания партнера
$fullclass = 'inline-block not-null';
if ($errors->fullforgotten)
    $fullclass .= ' forgotten';
echo form_label('Описание партнера (русское)', 'partner_full_ru', array('class'=>$fullclass));
echo form_textarea('partner_full_ru', $partner->full_ru);
echo br(2);

// Ввод ссылки на сайт партнера
echo form_label('Ссылка на сайт партнера', 'partner_url', array('class'=>'inline-block'));
echo form_input('partner_url', $partner->url, 'maxlength="300" style = width:400px');
echo br(2);

// Ввод изображения
echo form_label('Изображение', 'partner_image', array('class'=>'inline-block'));
echo form_upload('partner_image', $partner->image);
echo br(2);

echo '<a href="#" id="showhide_en">Английская версия</a>';
echo '<div class="hideble">';

// Ввод английского имени партнера
echo form_label('Имя партнера (английское)', 'partner_name_en', array('class'=>'inline-block'));
echo form_input('partner_name_en', $partner->name_en, 'maxlength="150" style = width:400px');
echo br(2);

// Ввод краткого английского описания партнера
echo form_label('Краткое описание партнера (английское)', 'partner_short_en', array('class'=>'inline-block'));
echo form_textarea('partner_short_en', $partner->short_en);
echo br(2);

// Ввод английского описания партнера
echo form_label('Описание партнера (английское)', 'partner_full_en', array('class'=>'inline-block'));
echo form_textarea('partner_full_en', $partner->full_en);
echo br(2);
echo '</div>';

if( isset($partner->id) )
{
	echo form_hidden('partner_id', $partner->id);
}
echo br(2);
echo form_submit('user_submit', $button_title);
echo form_close();
?>
</div>
