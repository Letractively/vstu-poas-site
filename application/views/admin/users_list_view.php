<?php
if (!isset($label)) {$label = 'Юзеры';}
if (!isset($id)) {$id = 'users';}
if (!isset($users)) {$users = array(1,2,3);}
if (!isset($select)) {$select = array();}
echo form_label($label, $id, array('class'=>'inline-block'));
echo form_dropdown($id, $users, $select, 'multiple');