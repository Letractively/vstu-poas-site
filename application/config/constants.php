<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/*
|--------------------------------------------------------------------------
| Database model
|--------------------------------------------------------------------------
*/
define('TABLE_NEWS', 'news');
define('TABLE_USERS', 'users');
define('TABLE_PROJECTS', 'projects');
define('TABLE_PROJECT_MEMBERS', 'project_members');
define('TABLE_DIRECTIONS','directions');
define('TABLE_DIRECTION_MEMBERS','direction_members');
define('TABLE_PUBLICATIONS', 'publications');
define('TABLE_PUBLICATION_AUTHORS', 'publication_authors');
define('TABLE_USER_COURSES', 'user_courses');
define('TABLE_COURSES', 'courses');
define('TABLE_PARTNERS', 'partners');
define('TABLE_FILES', 'files');
define('TABLE_INTERESTS', 'interests');

define('TABLE_GROUPS', 'groups');
define('TABLE_USERS_GROUPS', 'users_groups');


/*
|--------------------------------------------------------------------------
| Site
|--------------------------------------------------------------------------
|
| Константы общего назначения
*/
define('SITE_URL', 'http://poas.dip/');
define('URL_NOT_CHANGE', 555000);	/// флаг того, что при обновлении URL требуется оставить прежним


/*
|--------------------------------------------------------------------------
| Models
|--------------------------------------------------------------------------
| Доступные модели
*/
define('MODEL_NEWS', 		'news_model');				/// новости
define('MODEL_USER', 		'user_model');				/// пользователи
define('MODEL_PROJECT', 	'project_model');			/// проекты
define('MODEL_DIRECTION',	'direction_model');			/// научные направления
define('MODEL_PUBLICATION', 'publication_model');       /// публикации
define('MODEL_PARTNER',     'partner_model');           /// партнеры
define('MODEL_COURSE',      'course_model');            /// курсы
define('MODEL_FILE',        'file_model');              /// файлы

define('MODEL_ION_AUTH',    'ion_auth_model');          /// библиотека авторизации

/*
|--------------------------------------------------------------------------
| User model
|--------------------------------------------------------------------------
*/
define('USER_GROUP_GUEST', 0);			/// неавторизованный пользователь
define('USER_GROUP_ADMIN', 555100);		/// администраторы
define('USER_GROUP_GENERAL', 555101);	/// обычный авторизованный пользователь

define('ION_USER_ADMIN', 1);
define('ION_USER_STUDENT', 2);
define('ION_USER_LECTURER', 3);

/* End of file constants.php */
/* Location: ./application/config/constants.php */