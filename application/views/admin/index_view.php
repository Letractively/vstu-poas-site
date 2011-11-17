<div class="form_edit">
<?php

echo form_open('admin');

echo form_label('Выключить сайт', 'turn_off', array('class'=>'inline-block'));
echo form_checkbox('turn_off').br(2);

echo form_submit('admin_submit', 'Сохранить');
echo form_close();
?>
</div>