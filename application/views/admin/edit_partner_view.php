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

// Заполнено ли хотя бы одно поле английской версии
$en_version_started =   $partner->name_en !== '' ||
                        $partner->short_en !== '' ||
                        $partner->full_en !== '';

if (!isset($errors->nameruforgotten))     {$errors->nameruforgotten = false;};
if (!isset($errors->shortruforgotten))    {$errors->shortruforgotten = false;};
if (!isset($errors->fullruforgotten))     {$errors->fullruforgotten = false;};

if (!isset($errors->nameenforgotten))     {$errors->nameenforgotten = false;};
if (!isset($errors->shortenforgotten))    {$errors->shortenforgotten = false;};
if (!isset($errors->fullenforgotten))     {$errors->fullenforgotten = false;};

echo form_open('admin/partners/' . $action . '/action');

// Ввод русского имени партнера (обязательный параметр)
echo form_label_adv('Имя партнера (русское) *', 
                    'partner_name_ru', 
                    'inline-block not-null', 
                    $errors->nameruforgotten, 
                    ' forgotten');
echo form_input('partner_name_ru', $partner->name_ru, 'maxlength="300" style = width:400px');
echo br(2);

// Ввод краткого русского описания партнера (обязательный параметр)
echo form_label_adv('Краткое описание партнера (русское) *', 
                    'partner_short_ru', 
                    'inline-block not-null', 
                    $errors->shortruforgotten, 
                    ' forgotten');
echo form_textarea('partner_short_ru', $partner->short_ru, 'class = "short"');
echo br(2);

// Ввод русского описания партнера
echo form_label_adv('Описание партнера (русское)*', 
                    'partner_full_ru', 
                    'inline-block not-null', 
                    $errors->fullruforgotten, 
                    ' forgotten');
echo form_textarea('partner_full_ru', $partner->full_ru, 'class = "short"');
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
if ($en_version_started)
    echo '<div class="hideble" style = "display:block;">';
else
    echo '<div class="hideble">';
echo '<hr>';

// Ввод английского имени партнера
echo form_label_adv('Имя партнера (английское)', 
                    'partner_name_en', 
                    'inline-block', 
                    $errors->nameenforgotten, 
                    ' not-null forgotten');
echo form_input('partner_name_en', $partner->name_en, 'maxlength="150" style = width:400px');
echo br(2);

// Ввод краткого английского описания партнера
echo form_label_adv('Краткое описание партнера (английское)', 
                    'partner_short_en', 
                    'inline-block', 
                    $errors->shortenforgotten, 
                    ' not-null forgotten');
echo form_textarea('partner_short_en', $partner->short_en, 'class = "short"');
echo br(2);

// Ввод английского описания партнера
echo form_label_adv('Описание партнера (английское)', 
                    'partner_full_en', 
                    'inline-block', 
                    $errors->fullenforgotten, 
                    ' not-null forgotten');
echo form_textarea('partner_full_en', $partner->full_en, 'class = "short"');
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
