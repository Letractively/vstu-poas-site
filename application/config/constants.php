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

/*
|--------------------------------------------------------------------------
| User model
|--------------------------------------------------------------------------
*/
define('USER_GROUP_GUEST', 0);			/// неавторизованный пользователь
define('USER_GROUP_ADMIN', 555100);		/// администраторы
define('USER_GROUP_GENERAL', 555101);	/// обычный авторизованный пользователь

/* End of file constants.php */
/* Location: ./application/config/constants.php */