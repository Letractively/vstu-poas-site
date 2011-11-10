<?php
$config = array(
    'admin/users/add' => array(
        array(
            'field' => 'user_login',
            'label' => 'Логин',
            'rules' => 'trim|required|alpha_dash|callback__login_unique'
        ),
        array(
            'field' => 'user_password',
            'label' => 'Пароль',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'user_passconf',
            'label' => 'Подтверждение пароля',
            'rules' => 'trim|required||matches[user_password]'
        ),
        array(
            'field' => 'user_name',
            'label' => 'Имя',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'user_surname',
            'label' => 'Фамилия',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'user_patronymic',
            'label' => 'Отчество',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'user_group',
            'label' => 'Роль',
            'rules' => 'required'
        ),
        array(
            'field' => 'user_email',
            'label' => 'Адрес электроннй почты',
            'rules' => 'valid_email'
        ),
        array(
            'field' => 'user_phone',
            'label' => 'Телефон',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_cabinet',
            'label' => 'Кабинет',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_url',
            'label' => 'Сайт',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_skype',
            'label' => 'Skype',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_address',
            'label' => 'Адрес',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_cv_ru',
            'label' => 'CV на русском',
            'rules' => 'trim|numeric'
        ),
        array(
            'field' => 'user_photo',
            'label' => 'Фотография',
            'rules' => 'callback__validate_photo'
        ),
        array(
            'field' => 'user_id',
            'label' => 'User id',
            'rules' => ''
        )
    )   
);
$admin_users_edit = $config['admin/users/add'];
$admin_users_edit[0] = array(
    'field' => 'user_login',
    'label' => 'Логин',
    'rules' => ''
);
$config['admin/users/edit'] = $admin_users_edit;
?>
