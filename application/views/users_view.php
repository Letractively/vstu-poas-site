<?php // Отобразить пользователей

foreach($users as $user)
{
    echo anchor('/users/' . $user->id, $user->surname . ' ' . $user->name).br();
    //print_r($user);
}

