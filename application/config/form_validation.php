<?php
$config = array(
    'admin/users' => array(
        array(
            'field' => 'user_login',
            'label' => 'Логин',
            'rules' => 'trim|required|callback__login_unique'
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
        )
    )   
);
?>
