<div id="form_edit">
<?php
    if(!isset($user)){
        $action = 'add';
        $button = 'Добавить запись';
        
        $user->id           = null;
        $user->login        = '';
        $user->password     = '';
        $user->passconf     = '';
        $user->surname      = '';
        $user->name         = '';
        $user->patronymic   = '';
        $user->email        = '';
        $user->phone        = '';
        $user->cabinet      = '';
        $user->url          = '';
        $user->skype        = '';
        $user->address      = '';
        
        $user->cv_ru      = '';
        $user->cv_en      = '';
        
    }
    else {
        $action = 'edit';
        $button = 'Применить изменения';
    }
    if(!isset($groups)) {
        $groups = array('Администратор','Препрдаватель','Студент');
    }
?>
    
<?php
    echo form_open('admin/users/'.$action.'/action'); 

    echo form_label('Логин*', 'user_login', array('class' => 'inline-block'));
    echo form_input('user_login', set_value('user_login', $user->login), 'maxlength="20"');
    echo form_error('user_login'); 
    echo br(2); 

    echo form_label('Пароль*', 'user_password', array('class' => 'inline-block'));
    echo form_password('user_password', set_value('user_password', $user->password), 'maxlength="15"');
    echo form_error('user_password'); 
    echo br(); 

    echo form_label('Подтверждение пароля*', 'user_passconf', array('class' => 'inline-block'));
    echo form_password('user_passconf', set_value('user_passconf', $user->passconf), 'maxlength="15"');
    echo form_error('user_passconf'); 
    echo br(2); 

    echo form_label('Фамилия*', 'user_surname', array('class' => 'inline-block'));
    echo form_input('user_surname', set_value('user_surname', $user->surname), 'maxlength="40"');
    echo form_error('user_surname'); 
    echo br(2); 

    echo form_label('Имя*', 'user_name', array('class' => 'inline-block'));
    echo form_input('user_name', set_value('user_name', $user->name), 'maxlength="40"');
    echo form_error('user_name'); 
    echo br(2); 

    echo form_label('Отчество*', 'user_patronymic', array('class' => 'inline-block'));
    echo form_input('user_patronymic', set_value('user_patronymic', $user->patronymic), 'maxlength="40"');
    echo form_error('user_patronymic'); 
    echo br(2); 
    
    echo form_label('Роль*', 'user_group', array('class'=>'inline-block'));
    echo '<select name="user_group">';
    foreach ($groups as $groupid => $group) {
        echo '<option value="'.$groupid.'"'.set_select('user_group', $groupid).'>'.$group.'</option>';
    }
    echo '</select>';
    echo form_error('user_group'); 
    echo br(2);
?>

<div class="contacts">
    
    <a href="#" class="showhide">Контакты</a>
<div class="hideble">
<hr>
<?php
    echo form_label('Адрес электроннй почты', 'user_email', array('class' => 'inline-block'));
    echo form_input('user_email', set_value('user_email', $user->email), 'maxlength="40"');
    echo form_error('user_email'); 
    echo br(2);
    
    echo form_label('Телефон', 'user_phone', array('class' => 'inline-block'));
    echo form_input('user_phone', set_value('user_phone', $user->phone), 'maxlength="20"');
    echo form_error('user_phone'); 
    echo br(2);
    
    echo form_label('Кабинет', 'user_cabinet', array('class' => 'inline-block'));
    echo form_input('user_cabinet', set_value('user_cabinet', $user->cabinet), 'maxlength="10"');
    echo form_error('user_cabinet'); 
    echo br(2);
    
    echo form_label('Веб-сайт', 'user_url', array('class' => 'inline-block'));
    echo form_input('user_url', set_value('user_url', $user->url), 'maxlength="150"');
    echo form_error('user_url'); 
    echo br(2);
    
    echo form_label('Skype', 'user_skype', array('class' => 'inline-block'));
    echo form_input('user_skype', set_value('user_skype', $user->skype), 'maxlength="40"');
    echo form_error('user_skype'); 
    echo br(2);
    
    echo form_label('Адрес', 'user_address', array('class' => 'inline-block'));
    echo form_input('user_address', set_value('user_address', $user->address), 'maxlength="150"');
    echo form_error('user_address'); 
    echo br(2);
?>
</div>
</div>

<div class="cv">
<a href="#" class="showhide">CV</a>
<div class="hideble">
<hr>
<?php
    echo form_label('CV', 'user_cv_ru', array('class' => 'inline-block'));
    echo form_textarea('user_cv_ru', set_value('user_cv_ru', $user->cv_ru), 'maxlength="40"');
    echo form_error('user_cv_ru'); 
    echo br(2);
?>
</div>
</div>
    
<?php
    echo form_hidden('user_id', $user->id); 

    echo br(2); 
    echo form_submit('user_submit', $button); 
    echo form_close(); 
?>

<?php
/*
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
if(!isset($user->name))			{ $user->name = ''; }
if(!isset($user->surname))		{ $user->surname = ''; }
if(!isset($user->patronymic))	{ $user->patronymic = ''; }
if(!isset($user->role))			{ $user->role = 'student'; }


// Контакты
if(!isset($user->cab))          { $user->cab = ''; }
if(!isset($user->email))		{ $user->email = ''; }
if(!isset($user->skype))        { $user->skype = '';}
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

if ($errors->passwordforgotten)
    $user->password = '';
if ($action == 'edit' && !$errors->differentpasswords && !$errors->password2forgotten)
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

echo '<div class="contacts">';
echo '<a href="#" class="showhide">Контакты</a>';
echo '<div class="hideble">';
echo '<hr>';
echo form_label('Адрес электроннй почты', 'user_email', array('class'=>'inline-block'));
echo form_input('user_email', $user->email, 'maxlength="40"').br(2);
echo '</div></div><br>';

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
 * 
 */
?>
</div>