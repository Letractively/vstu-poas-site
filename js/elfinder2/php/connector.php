<?php /** @todo Добавить проверку - есть ли права к файловому менеджеру у пользователя 
			@todo Запретить загрузку php файлов
			@todo Вообще почитать про безопасность в этом вопросе
			*/
error_reporting(0); // Set E_ALL for debuging

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeLocalFileSystem.class.php';
// Required for MySQL storage connector
//include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeMySQL.class.php';


/**
* Simple logger function.
* Demonstrate how to work with elFinder event api.
*
* @package elFinder
* @author Dmitry (dio) Levashov
**/
class mySqlAdding {

	/**
	* Log file path
	*
	* @var string
	**/
	protected $file = '';
	
	/**
	* constructor
	*
	* @return void
	* @author Dmitry (dio) Levashov
	**/
	public function __construct($path) {
		$this->file = $path;
		$dir = dirname($path);
		if (!is_dir($dir)) {
			mkdir($dir);
		}
	}
	
	/**
	* Create log record
	*
	* @param string $cmd command name
	* @param array $result command result
	* @param array $args command arguments from client
	* @param elFinder $elfinder elFinder instance
	* @return void|true
	* @author Dmitry (dio) Levashov
	**/
	public function log($cmd, $result, $args, $elfinder) {
		$log = $cmd.' ['.date('d.m H:s')."]\n".serialize($args)."\n";
	
		if (!empty($result['error'])) {
			$log .= "\tERROR: ".implode(' ', $result['error'])."\n";
		}
	
		if (!empty($result['warning'])) {
			$log .= "\tWARNING: ".implode(' ', $result['warning'])."\n";
		}
	
		if (!empty($result['removed'])) {
			foreach ($result['removed'] as $file) {
				// removed file contain additional field "realpath"
				$log .= "\tREMOVED: ".$file['realpath']."\n";
			}
		}
	
		if (!empty($result['added'])) {
		
			foreach ($result['added'] as $file) {
				$log .= "\tADDED: ".$elfinder->realpath($file['hash'])."\n";
			}
		}
	
		if (!empty($result['changed'])) {
			foreach ($result['changed'] as $file) {
			$log .= "\tCHANGED: ".$elfinder->realpath($file['hash'])."\n";
			}
		}
		$this->write($log);
		
		return TRUE;
	}
	
	/**
	* Write log into file
	*
	* @param string $log log record
	* @return void
	* @author Dmitry (dio) Levashov
	**/
	protected function write($log) {
		if (($fp = @fopen($this->file, 'a'))) {
			fwrite($fp, $log."\n");
			fclose($fp);
		}
	}

} // END class 













/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from  '.' (dot)
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool
 **/
function access($attr, $path, $data, $volume) {
	return strpos(basename($path), '.') === 0   // if file/folder begins with '.' (dot)
		? !($attr == 'read' || $attr == 'write')  // set read+write to false, other (locked+hidden) set to true
		: ($attr == 'read' || $attr == 'write');  // else set read+write to true, locked+hidden to false
}

$dir = '';
if( isset($_GET['dir']) ) $dir = $_GET['dir'];
else if( isset( $_POST['dir'] )) $dir = $_POST['dir'];
		
$logger = new elFinderSimpleLogger('../files/temp/log.txt');


$opts = array(
	// 'debug' => true,
	'bind' => array(
		'mkdir mkfile rename duplicate upload rm paste' => array($logger, 'log'), // upload
	),
	
	'roots' => array(
		array(
			'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
			'path'          => '../../../files/'.$dir,  // path to files (REQUIRED)
			'URL'           => '/files/'.$dir,	//dirname($_SERVER['PHP_SELF']) . '', // URL to files (REQUIRED)
			'accessControl' => 'access'         // disable and hide dot starting files (OPTIONAL)
		)
	)
);

//$bd_in = new elFinderVolumeMySQL();
//$bd_in->init();
// run elFinder
$connector = new elFinderConnector(new elFinder($opts), true);
$connector->run();