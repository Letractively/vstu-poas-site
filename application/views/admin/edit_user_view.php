<div id="form_edit">
<?php
    if(!isset($user->id)){
        $action = 'add';
        $submit = 'Добавить запись';
        
        $user->id               = null;
        $user->login            = '';
        $user->password         = '';
        $user->surname_ru       = '';
        $user->name_ru          = '';
        $user->patronymic_ru    = '';
        $user->surname_en       = '';
        $user->name_en          = '';
        $user->patronymic_en    = '';
                        
    }
    else {
        $action = 'edit';
        $submit = 'Применить изменения';
    }
    $user->passconf = $user->password;
    if (!isset($user->rank_ru))     $user->rank_ru = '';
    if (!isset($user->rank_en))     $user->rank_en = '';
    if (!isset($user->post_ru))     $user->post_ru = '';
    if (!isset($user->post_en))     $user->post_en = '';
    if (!isset($user->email))       $user->email = '';
    if (!isset($user->phone))       $user->phone = '';
    if (!isset($user->cabinet))     $user->cabinet = '';
    if (!isset($user->url))         $user->url = '';
    if (!isset($user->skype))       $user->skype = '';
    if (!isset($user->address_ru))  $user->address_ru = '';
    if (!isset($user->address_en))  $user->address_en = '';
    
    if (!isset($user->cv_ru))       $user->cv_ru = '';
    if (!isset($user->cv_en))       $user->cv_en = '';
    
    if (!isset($user->info_ru))     $user->info_ru = '';
    if (!isset($user->info_en))     $user->info_en = '';
    if (!isset($user->interests))   $users->interests = array();
    for($i = 0; $i < 5; $i++)
    {
        $obj = new stdClass();
        $obj->short = '';
        $obj->full = '';
        if (!isset($user->interests[$i]))   $user->interests[$i] = $obj;
    }
    if (!isset($user->teaching_ru))     $user->teaching_ru = '';
    if (!isset($user->teaching_en))     $user->teaching_en = '';
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
    echo form_password('user_password', set_value('user_password', $user->password), 'maxlength="15" class="short"');
    echo form_error('user_password'); 
    echo br(); 

    echo form_label('Подтверждение пароля*', 'user_passconf', array('class' => 'inline-block'));
    echo form_password('user_passconf', set_value('user_passconf', $user->passconf), 'maxlength="15" class="short"');
    echo form_error('user_passconf'); 
    echo br(2); 

    echo form_label('Фамилия*', 'user_surname_ru', array('class' => 'inline-block'));
    echo form_input('user_surname_ru', set_value('user_surname_ru', $user->surname_ru), 'maxlength="30" class="short"');
    echo form_error('user_surname_ru'); 
    echo br(2); 

    echo form_label('Имя*', 'user_name_ru', array('class' => 'inline-block'));
    echo form_input('user_name_ru', set_value('user_name_ru', $user->name_ru), 'maxlength="30" class="short"');
    echo form_error('user_name_ru'); 
    echo br(2); 

    echo form_label('Отчество*', 'user_patronymic_ru', array('class' => 'inline-block'));
    echo form_input('user_patronymic_ru', set_value('user_patronymic_ru', $user->patronymic_ru), 'maxlength="30" class="short"');
    echo form_error('user_patronymic_ru'); 
    echo br(2); 

    echo form_label('Фамилия (en)*', 'user_surname_en', array('class' => 'inline-block'));
    echo form_input('user_surname_en', set_value('user_surname_en', $user->surname_en), 'maxlength="30" class="short"');
    echo form_error('user_surname_en'); 
    echo br(2); 

    echo form_label('Имя (en)*', 'user_name_en', array('class' => 'inline-block'));
    echo form_input('user_name_en', set_value('user_name_en', $user->name_en), 'maxlength="30" class="short"');
    echo form_error('user_name_en'); 
    echo br(2); 

    echo form_label('Отчество (en)*', 'user_patronymic_en', array('class' => 'inline-block'));
    echo form_input('user_patronymic_en', set_value('user_patronymic_en', $user->patronymic_en), 'maxlength="30" class="short"');
    echo form_error('user_patronymic_en'); 
    echo br(2);     
    
    echo form_label('Роль*', 'user_group', array('class'=>'inline-block'));
    echo '<select name="user_group">';
    foreach ($groups as $groupid => $group) {
        echo '<option value="'.$groupid.'"'.set_select('user_group', $groupid).'>'.$group.'</option>';
    }
    echo '</select>';
    echo br(2);
    
    echo form_error('user_group'); 
    echo br(2);
?>
<div class="rank post">
<a href="#" class="showhide">Звание и должность</a>
<div class="hideble">
<hr>
<?php

    echo form_label('Звание', 'user_rank_ru', array('class' => 'inline-block'));
    echo form_input('user_rank_ru', set_value('user_rank_ru', $user->rank_ru), 'maxlength="100" class="long"');
    echo form_error('user_rank_ru');
    echo br(2);  
    
    echo form_label('Звание (en)', 'user_rank_en', array('class' => 'inline-block'));
    echo form_input('user_rank_en', set_value('user_rank_en', $user->rank_en), 'maxlength="100" class="long"');
    echo form_error('user_rank_en');
    echo br(2);  
    
    echo form_label('Должность', 'user_post_ru', array('class' => 'inline-block'));
    echo form_input('user_post_ru', set_value('user_post_ru', $user->post_ru), 'maxlength="100" class="long"');
    echo form_error('user_post_ru');
    echo br(2);  
    
    echo form_label('Должность (en)', 'user_post_en', array('class' => 'inline-block'));
    echo form_input('user_post_en', set_value('user_post_en', $user->post_en), 'maxlength="100" class="long"');
    echo form_error('user_post_en');
    echo br(2);  
?>
</div>
</div>
    
<div class="interests">
<a href="#" class="showhide">Интересы</a>
<div class="hideble">
<hr>
<?php
    for($i = 0; $i < 5; $i++)
    {
        $interest = $user->interests[$i];
        echo form_label('Краткое название интереса', 'user_interest_short_' . $i, array('class' => 'inline-block'));
        echo form_input('user_interest_short_' . $i, set_value('user_interest_short_' . $i, $interest->short), 'maxlength="10" class="short"');
        echo form_error('user_interest_short_' . $i); 
        echo br();
        echo form_label('Полное название интереса', 'user_interest_full_' . $i, array('class' => 'inline-block'));
        echo form_input('user_interest_full_' . $i, set_value('user_interest_full_' . $i, $interest->full), 'maxlength="100" class="long"');
        echo form_error('user_interest_full_' . $i); 
        echo br(2);
    }
?>
</div>
</div>
    
<div class="contacts">
    
    <a href="#" class="showhide">Контакты</a>
<div class="hideble">
<hr>
<?php
    
    echo form_label('Адрес электроннй почты', 'user_email', array('class' => 'inline-block'));
    echo form_input('user_email', set_value('user_email', $user->email), 'maxlength="40" class="short"');
    echo form_error('user_email'); 
    echo br(2);
    
    echo form_label('Телефон', 'user_phone', array('class' => 'inline-block'));
    echo form_input('user_phone', set_value('user_phone', $user->phone), 'maxlength="20" class="short"');
    echo form_error('user_phone'); 
    echo br(2);
    
    echo form_label('Кабинет', 'user_cabinet', array('class' => 'inline-block'));
    echo form_input('user_cabinet', set_value('user_cabinet', $user->cabinet), 'maxlength="10" class="short"');
    echo form_error('user_cabinet'); 
    echo br(2);
    
    echo form_label('Веб-сайт', 'user_url', array('class' => 'inline-block'));
    echo form_input('user_url', set_value('user_url', $user->url), 'maxlength="150" class="long"');
    echo form_error('user_url'); 
    echo br(2);
    
    echo form_label('Skype', 'user_skype', array('class' => 'inline-block'));
    echo form_input('user_skype', set_value('user_skype', $user->skype), 'maxlength="40" class="short"');
    echo form_error('user_skype'); 
    echo br(2);
    
    echo form_label('Адрес', 'user_address_ru', array('class' => 'inline-block'));
    echo form_textarea('user_address_ru', set_value('user_address_ru', $user->address_ru), 'maxlength="300" class="short"');
    echo form_error('user_address_ru'); 
    echo br(2);
    
    echo form_label('Адрес (en)', 'user_address_en', array('class' => 'inline-block'));
    echo form_textarea('user_address_en', set_value('user_address_en', $user->address_en), 'maxlength="300" class="short"');
    echo form_error('user_address_en'); 
    echo br(2);
?>
</div>
</div>

<div class="cv">
<a href="#" class="showhide">CV</a>
<div class="hideble">
<hr>
<?php
    echo form_label('CV на русском', 'user_cv_ru', array('class' => 'inline-block'));
    echo form_textarea('user_cv_ru', set_value('user_cv_ru', $user->cv_ru), 'class="elrte_editor"');
    echo form_error('user_cv_ru'); 
    echo br(2);
    
    echo form_label('CV на английском', 'user_cv_en', array('class' => 'inline-block'));
    echo form_textarea('user_cv_en', set_value('user_cv_en', $user->cv_en), 'class="elrte_editor"');
    echo form_error('user_cv_en'); 
    echo br(2);
?>
</div>
</div>

<div class="teaching">
<a href="#" class="showhide">Преподавание</a>
<div class="hideble">
<hr>
<?php
    echo form_label('На русском', 'user_teaching_ru', array('class' => 'inline-block'));
    echo form_textarea('user_teaching_ru', set_value('user_teaching_ru', $user->teaching_ru), 'class="elrte_editor"');
    echo form_error('user_teaching_ru'); 
    echo br(2);
    
    echo form_label('На английском', 'user_teaching_en', array('class' => 'inline-block'));
    echo form_textarea('user_teaching_en', set_value('user_teaching_en', $user->teaching_en), 'class="elrte_editor"');
    echo form_error('user_teaching_en'); 
    echo br(2);
?>
</div>
</div>
    
<div class="info">
<a href="#" class="showhide">Дополнительная информация</a>
<div class="hideble">
<hr>
<?php
    echo form_label('На русском', 'user_info_ru', array('class' => 'inline-block'));
    echo form_textarea('user_info_ru', set_value('user_info_ru', $user->info_ru), 'class="elrte_editor"');
    echo form_error('user_info_ru'); 
    echo br(2);
    
    echo form_label('На английском', 'user_info_en', array('class' => 'inline-block'));
    echo form_textarea('user_info_en', set_value('user_info_en', $user->info_en), 'class="elrte_editor"');
    echo form_error('user_info_en'); 
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