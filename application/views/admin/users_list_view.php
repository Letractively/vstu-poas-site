<?php
$label = 'Юзеры';
$id = 'users';
$users = array(
    'user_1' => 'Вася',
    'user_2' => 'Петя',
    'user_3' => 'Коля',
    'user_4' => 'Сережа');
echo form_label($label, $id, array('class'=>'inline-block'));
echo form_dropdown($id, $users, null, 'multiple');