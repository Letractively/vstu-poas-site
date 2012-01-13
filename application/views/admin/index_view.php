<div class="form_edit">
<?php

echo form_open('admin', array('class' => 'gray_form'));

echo form_label('Выключить сайт', 'turn_off', array('class'=>'inline-block'));
echo form_checkbox('turn_off').br(2);

echo form_label('Включить режим отладки', 'turn_on_debug', array('class'=>'inline-block'));
echo form_checkbox('turn_on_debug').br(2);

echo form_label('Отключить RSS новости', 'turn_off_rss', array('class'=>'inline-block'));
echo form_checkbox('turn_off_rss').br(2);


echo form_submit('admin_submit', 'Сохранить');
echo form_close();
?>
</div>