<?php 
/** 
 * @todo Запретить загрузку php файлов
 * Коннектор для файлового менеджера Elfinder.
 * Для записи результатов работы с менеджером файлов служит модель "elfinder_sql_logger_model"
 * */
error_reporting(0); // Set E_ALL for debuging
include_once '/js/elfinder2/php/elFinderConnector.class.php';
include_once '/js/elfinder2/php/elFinder.class.php';
include_once '/js/elfinder2/php/elFinderVolumeDriver.class.php';
include_once '/js/elfinder2/php/elFinderVolumeLocalFileSystem.class.php';

class Elfinder_connector extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database('default');
		$this->load->model('elfinder_sql_logger_model');
		//$this->user_model->check_admin();	// Запрос логина и пароля, если пользователь не администратор
	}	
	
	function index()
	{
		// Отпределяем директорию для файлов (из js-параметров)
		$dir = '';
		if( isset($_GET['dir']) ) $dir = $_GET['dir'];
		else if( isset( $_POST['dir'] )) $dir = $_POST['dir'];
		$this->elfinder_sql_logger_model->set_dir($dir);
		
		// определяем тип объекта, к котормоу привязаны файлы (из js-параметров)
		$obj_type = 0;
		if( isset($_GET['obj_type']) ) $obj_type = $_GET['obj_type'];
		else if( isset( $_POST['obj_type'] )) $obj_type = $_POST['obj_type'];
		$this->elfinder_sql_logger_model->set_obj_type($obj_type);
		
		// определяем id объекта, к которому привязаны файл (из js-параметров)
		$obj_id = 0;
		if( isset($_GET['obj_id']) ) $obj_id = $_GET['obj_id'];
		else if( isset( $_POST['obj_id'] )) $obj_id = $_POST['obj_id'];
		$this->elfinder_sql_logger_model->set_obj_id($obj_id);
		
		$opts = array(
			//'debug' => true,
			'bind' => array(
				'mkdir mkfile rename duplicate upload rm paste' => array($this->elfinder_sql_logger_model, 'log'),
			),
			'roots' => array(
				array(
					'driver'        => 'LocalFileSystem',	// driver for accessing file system (REQUIRED)
					'path'          => 'uploads/'.$dir,		// path to files (REQUIRED)
					'URL'           => '/uploads/'.$dir,		//dirname($_SERVER['PHP_SELF']) . '', // URL to files (REQUIRED)
					'accessControl' => 'access'				// disable and hide dot starting files (OPTIONAL)
				)
			)
		);
		
		$connector = new elFinderConnector(new elFinder($opts), true);
		$connector->run();
	}
}

/**
 * Функция контроля доступа к файлам в файловом менеджере. Можно запретить операции с файлами, можно их скрывать.
 * На данный момент:
 * Скрывает все папки и файлы, начинающиеся с точки.
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool
 **/
function access($attr, $path, $data, $volume)
{
	return strpos(basename($path), '.') === 0   // if file/folder begins with '.' (dot)
		? !($attr == 'read' || $attr == 'write')  // set read+write to false, other (locked+hidden) set to true
		: ($attr == 'read' || $attr == 'write');  // else set read+write to true, locked+hidden to false
}

// Контроллер не стандартный, автоматически не запускается. Запускаем его вручную.
$x = new Elfinder_connector();
$x->index();