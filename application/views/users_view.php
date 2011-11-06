<?php // Отобразить пользователей

foreach($users as $user)
{
    echo anchor('/users/' . $user->id, $user->username).br();
    //print_r($user);
}

