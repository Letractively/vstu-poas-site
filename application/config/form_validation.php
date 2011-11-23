<?php
$config = array(
    'admin/users/add' => array(
        array(
            'field' => 'user_username',
            'label' => 'Логин',
            'rules' => 'trim|required|alpha_dash|callback__username_unique'
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
            'field' => 'user_name_ru',
            'label' => 'Имя',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'user_name_en',
            'label' => 'Имя (en)',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'user_surname_ru',
            'label' => 'Фамилия',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'user_surname_en',
            'label' => 'Фамилия (en)',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'user_patronymic_ru',
            'label' => 'Отчество',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'user_patronymic_en',
            'label' => 'Отчество (en)',
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
            'field' => 'user_address_ru',
            'label' => 'Адрес',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_address_en',
            'label' => 'Адрес (en)',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_cv_ru',
            'label' => 'CV на русском',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_cv_en',
            'label' => 'CV (en)',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_id',
            'label' => 'User id',
            'rules' => ''
        ),
        array(
            'field' => 'user_rank_ru',
            'label' => 'Звание',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_rank_en',
            'label' => 'Звание (en)',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_post_ru',
            'label' => 'Должность',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_post_en',
            'label' => 'Должность (en)',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_info_ru',
            'label' => 'Дополнительная информация',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_info_en',
            'label' => 'Дополнительная информация (en)',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_teaching_ru',
            'label' => 'Преподавание',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_teaching_en',
            'label' => 'Преподавание (en)',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_interest_short_0',
            'label' => 'Краткое название интереса',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_interest_full_0',
            'label' => 'Полное название интереса',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_interest_short_1',
            'label' => 'Краткое название интереса',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_interest_full_1',
            'label' => 'Полное название интереса',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_interest_short_2',
            'label' => 'Краткое название интереса',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_interest_full_2',
            'label' => 'Полное название интереса',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_interest_short_3',
            'label' => 'Краткое название интереса',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_interest_full_3',
            'label' => 'Полное название интереса',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_interest_short_4',
            'label' => 'Краткое название интереса',
            'rules' => 'trim'
        ),
        array(
            'field' => 'user_interest_full_4',
            'label' => 'Полное название интереса',
            'rules' => 'trim'
        )
        
    )   
);
$admin_users_edit = $config['admin/users/add'];
$admin_users_edit[0] = array(
    'field' => 'user_username',
    'label' => 'Логин',
    'rules' => ''
);
$config['admin/users/edit'] = $admin_users_edit;

$config['admin/partners'] = array(
    array(
        'field' => 'partner_name_ru',
        'label' => 'Имя партнера (русское)',
        'rules' => 'trim|required'
    ),
    array(
        'field' => 'partner_short_ru',
        'label' => 'Краткое описание партнера (русское)',
        'rules' => 'trim|required'
    ),
    array(
        'field' => 'partner_full_ru',
        'label' => 'Описание партнера (русское)',
        'rules' => 'trim|required'
    ),
    array(
        'field' => 'partner_url',
        'label' => 'Ссылка на сайт партнера',
        'rules' => 'trim'
    ),
    array(
        'field' => 'partner_name_en',
        'label' => 'Имя партнера (английское)',
        'rules' => 'trim|callback__partner_en'
    ),
    array(
        'field' => 'partner_short_en',
        'label' => 'Краткое описание партнера (английское)',
        'rules' => 'trim|callback__partner_en'
    ),
    array(
        'field' => 'partner_full_en',
        'label' => 'Описание партнера (английское)',
        'rules' => 'trim|callback__partner_en'
    )
);
$config['admin/projects'] = array(
    array(
        'field' => 'project_name_ru',
        'label' => 'Название проекта (русское)',
        'rules' => 'trim|required'
    ),
    array(
        'field' => 'project_description_ru',
        'label' => 'Описание проекта (русское)',
        'rules' => 'trim|required'
    ),
    array(
        'field' => 'project_url',
        'label' => 'Ссылка на проект',
        'rules' => 'trim'
    ),
    array(
        'field' => 'project_members[]',
        'label' => 'Участники проекта',
        'rules' => ''
    ),
    array(
        'field' => 'project_name_en',
        'label' => 'Название проекта (английское)',
        'rules' => 'trim|callback__project_en'
    ),
    array(
        'field' => 'project_description_en',
        'label' => 'Описание проекта (английское)',
        'rules' => 'trim|callback__project_en'
    )    
);
?>
