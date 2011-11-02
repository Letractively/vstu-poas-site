<div id="form_edit">
<?php
//@todo получить из контроллера 
$roles = array('admin' => 'Администратор', 
			   'student' => 'Студент',
			   'teacher' => 'Преподаватель');
$permissions = array ('news_editor' => 'Редактор новостей',
					  'students_manager' => 'Менеджер студентов');
// end:@todo
//$user = new stdClass();
if(!isset($user->login))		{ $user->login = ''; }
$user->password = '';
$user->password2 = '';
if(!isset($user->email))		{ $user->email = ''; }
if(!isset($user->name))			{ $user->name = ''; }
if(!isset($user->surname))		{ $user->surname = ''; }
if(!isset($user->patronymic))	{ $user->patronymic = ''; }
if(!isset($user->role))			{ $user->role = 'student'; }
if(!isset($user->id))		

//$user->id = 0;

$user->permission_news_editor = FALSE;
$user->permission_students_manager = FALSE;

$button_title = 'Создать';
if(!isset($passwordmessage)) 	{ $passwordmessage = ''; }
if(!isset($loginmessage)) 		{ $loginmessage = ''; }

$action = 'add';
echo form_open('admin/users/'.$action.'/action');

echo form_label('Логин', 'user_login', array('class'=>'inline-block'));
echo form_input('user_login', $user->login, 'maxlength="40"');
echo form_label($loginmessage, 'login_message', array('class'=>'inline-block','style' => 'color:red;'));
echo br(2);

echo form_label('Пароль', 'user_password', array('class'=>'inline-block'));
echo form_password('user_password', $user->password, 'maxlength="40"');
echo form_label($passwordmessage, 'password_message', array('class'=>'inline-block','style' => 'color:red;'));
echo br();

echo form_label('Повторите пароль', 'user_password2', array('class'=>'inline-block'));
echo form_password('user_password2', $user->password2, 'maxlength="40"').br(2);

echo form_label('Адрес электроннй почты', 'user_email', array('class'=>'inline-block'));
echo form_input('user_email', $user->email, 'maxlength="40"').br(2);

echo form_label('Фамилия', 'user_surname', array('class'=>'inline-block'));
echo form_input('user_surname', $user->surname, 'maxlength="40"').br();

echo form_label('Имя', 'user_name', array('class'=>'inline-block'));
echo form_input('user_name', $user->name, 'maxlength="40"').br();

echo form_label('Отчество', 'user_patronymic', array('class'=>'inline-block'));
echo form_input('user_patronymic', $user->patronymic, 'maxlength="40"').br(2);

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