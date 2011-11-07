<div id="form_edit">
<?php
//@todo получить из контроллера 
$roles = array('admin' => 'Администратор', 
			   'student' => 'Студент',
			   'teacher' => 'Преподаватель');
$permissions = array ('news_editor' => 'Редактор новостей',
					  'students_manager' => 'Менеджер студентов');

if( !isset($user->id) )
{
	$action = 'add';
	$button_title = 'Создать пользователя';
}
else 
{
	$action = 'edit';
	$button_title = 'Изменить данные пользователя';
}
if(!isset($user->login))		{ $user->login = ''; }
if(!isset($user->password))		{ $user->password = ''; }
if(!isset($user->email))		{ $user->email = ''; }
if(!isset($user->name))			{ $user->name = ''; }
if(!isset($user->surname))		{ $user->surname = ''; }
if(!isset($user->patronymic))	{ $user->patronymic = ''; }
if(!isset($user->role))			{ $user->role = 'student'; }
if(!isset($user->cab))          { $user->cab = ''; }
if(!isset($user->phone))        { $user->phone = ''; }
if(!isset($user->site))         { $user->site = ''; }


if(!isset($errors->loginforgotten))         {$errors->loginforgotten = FALSE;}
if(!isset($errors->passwordforgotten))      {$errors->passwordforgotten = FALSE;}
if(!isset($errors->password2forgotten))     {$errors->password2forgotten = FALSE;}
if(!isset($errors->nameforgotten))          {$errors->nameforgotten = FALSE;}
if(!isset($errors->surnameforgotten))       {$errors->surnameforgotten = FALSE;}
if(!isset($errors->patronymicforgotten))    {$errors->patronymicforgotten = FALSE;}
if(!isset($errors->loginused))              {$errors->loginused = FALSE;}
if(!isset($errors->differentpasswords))     {$errors->differentpasswords = FALSE;}

$user->password2 = '';

if ($action == 'edit')
{
    $user->password2 = $user->password;
}
        

$user->permission_news_editor = FALSE;
$user->permission_students_manager = FALSE;

echo form_open('admin/users/'.$action.'/action');

echo form_label_adv('Логин*', 'user_login', 'inline-block not-null', $errors->loginforgotten, 'forgotten');
echo form_input('user_login', $user->login, 'maxlength="40"');
if ($errors->loginused)
    echo form_label('Логин занят', 'user_login_used', array('class'=>'inline-block wrong-data'));
echo br(2);

echo form_label_adv('Пароль*', 'user_password', 'inline-block not-null', $errors->passwordforgotten, 'forgotten');
echo form_password('user_password', $user->password, 'maxlength="40"');
if ($errors->differentpasswords)
    echo form_label('Введенные пароли не совпадают', 'user_passwords_different', array('class'=>'inline-block wrong-data'));
echo br();

echo form_label_adv('Повторите пароль*', 'user_password2', 'inline-block not-null', $errors->password2forgotten, 'forgotten');
echo form_password('user_password2', $user->password2, 'maxlength="40"').br(2);



echo form_label_adv('Фамилия*', 'user_surname', 'inline-block not-null', $errors->surnameforgotten, 'forgotten');
echo form_input('user_surname', $user->surname, 'maxlength="40"').br();

echo form_label_adv('Имя*', 'user_name', 'inline-block not-null', $errors->nameforgotten, 'forgotten');
echo form_input('user_name', $user->name, 'maxlength="40"').br();

echo form_label_adv('Отчество*', 'user_patronymic', 'inline-block not-null', $errors->patronymicforgotten, 'forgotten');
echo form_input('user_patronymic', $user->patronymic, 'maxlength="40"').br(2);

echo form_label('Адрес электроннй почты', 'user_email', array('class'=>'inline-block'));
echo form_input('user_email', $user->email, 'maxlength="40"').br(2);

if (count($roles) > 0)
{
	echo form_label('Роль', 'user_role', array('class'=>'inline-block'));
	echo form_dropdown('user_role', $roles, $user->role).br(2);
}
foreach($permissions as $name => $string) {
	$permission = 'permission_' . $name;
	echo form_label($string, 'user_permission_' . $name, array('class'=>'inline-block'));
	echo form_checkbox('user_permission_' . $name, 'grant', $user->$permission).br();
}
echo br(2);
if( isset($user->id) )
{
	echo form_hidden('user_id', $user->id);
}
echo form_submit('user_submit', $button_title);
echo form_close();
?>
</div>