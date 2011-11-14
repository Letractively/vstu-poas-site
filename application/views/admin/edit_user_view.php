<div id="form_edit">
<?php
    if(!isset($user->id)){
        $action = 'add';
        $submit = 'Добавить запись';
        
        $user->id           = null;
        $user->login        = '';
        $user->password     = '';
        $user->surname      = '';
        $user->name         = '';
        $user->patronymic   = '';
                        
    }
    else {
        $action = 'edit';
        $submit = 'Применить изменения';
    }
    $user->passconf = $user->password;
    if (!isset($user->photo))       $user->photo = '';
    if (!isset($user->email))       $user->email = '';
    if (!isset($user->phone))       $user->phone = '';
    if (!isset($user->cabinet))     $user->cabinet = '';
    if (!isset($user->url))         $user->url = '';
    if (!isset($user->skype))       $user->skype = '';
    if (!isset($user->address))     $user->address = '';

    if (!isset($user->cv_ru))     $user->cv_ru = '';
    if (!isset($user->cv_en))     $user->cv_en = '';
    
    if(!isset($groups)) {
        $groups = array('Администратор','Препрдаватель','Студент');
    }
?>
    
<?php
    echo form_open_multipart('admin/users/'.$action.'/action'); 

    // Редактирование логина недопустимо
    echo form_label('Логин*', 'user_login', array('class' => 'inline-block'));
    if ($action === 'add')
        echo form_input('user_login', set_value('user_login', $user->login), 'maxlength="20"');
    else
    {
        echo $user->login;
        echo form_hidden('user_login',$user->login);
    }
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
    $data['path'] = isset($user->photo_name) ? $user->photo_name : null;
    $data['field'] = 'user_photo';
    $data['fileid'] = $user->photo;
    $data['label'] = 'Фотография';
    $this->load->view('admin/subview/file_upload_view',$data);
    
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
<a href="#" class="showhide js_check_error">CV</a>
<div class="hideble">
<hr>
<?php
    echo form_label('CV на русском', 'user_cv_ru', array('class' => 'inline-block'));
    echo form_textarea('user_cv_ru', set_value('user_cv_ru', $user->cv_ru), 'maxlength="40"');
    echo form_error('user_cv_ru'); 
    echo br(2);
?>
</div>
</div>
    
<?php
    echo form_hidden('user_id', $user->id); 

    echo br(2); 
    echo form_submit('user_submit', $submit); 
    echo form_close(); 
?>

</div>