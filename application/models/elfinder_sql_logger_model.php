<?php

/**
* Обработчик событий для файлового менеджера Elfinder
*
* @package elFinder
* @author Dmitry (dio) Levashov
**/
class Elfinder_sql_logger_model extends CI_Model {
	protected $obj_type = null;
	protected $obj_id = null;
	protected $dir = null;
	
	function set_obj_type($obj_type)
	{
		$this->obj_type = $obj_type;
	}
	
	function set_obj_id($obj_id)
	{
		$this->obj_id = $obj_id;
	}
	
	function set_dir($dir)
	{
		$this->dir = $dir;	
	}
	
	/**
	* Отловить и обработать события
	*
	* @param string $cmd command name
	* @param array $result command result
	* @param array $args command arguments from client
	* @param elFinder $elfinder elFinder instance
	* @return void|true
	* @author Dmitry (dio) Levashov
	**/
	public function log($cmd, $result, $args, $elfinder)
	{
		$ci = &get_instance();
	/*
		if (!empty($result['error'])) {
			$log .= "\tERROR: ".implode(' ', $result['error'])."\n";
		}
	
		if (!empty($result['warning'])) {
			$log .= "\tWARNING: ".implode(' ', $result['warning'])."\n";
		}
	*/
		if (!empty($result['removed'])) {
			foreach ($result['removed'] as $file)
			{
				$deleted_filename = $file['realpath'];
				$deleted_filename = str_replace( '\\', '/', $deleted_filename );
				$this->db->delete(TABLE_FILES_ELFINDER, array('filename' => $deleted_filename), 1);
				
				$mime = explode("/", $file['mime']);
				$mime = $mime[0];
				if( $mime == 'directory')
				{
					// Все файлы внутри папки удалены, удалим их и из БД (ПЛОХО ВОТ ЧТО: если сервер внезапно отключится, то они останутся как мусор)
					$this->db->like('filename', $deleted_filename, 'after'); 
					$this->db->delete(TABLE_FILES_ELFINDER);	
				}
			}
		}
		
		if (!empty($result['added']))
		{
			$file_to_add->obj_type = $this->obj_type;
			$file_to_add->obj_id = $this->obj_id;
			foreach ($result['added'] as $file)
			{
				$file_to_add->filename = $elfinder->realpath($file['hash']);
				$file_to_add->size = $file['size'];
				$file_to_add->mime = explode("/", $file['mime']);
				$file_to_add->mime = $file_to_add->mime[0];
				$file_to_add->filename = str_replace( '\\', '/', $file_to_add->filename );
				$ci->db->insert(TABLE_FILES_ELFINDER, $file_to_add);
			}
		}
	 
		//if (!empty($result['changed']))
		//{
		//	foreach ($result['changed'] as $file)
		//	{
		//		debug(serialize($file));
		//		//$log .= "\tCHANGED: ".$elfinder->realpath($file['hash'])."\n";
		//	}
		//}
		
		//debug(serialize($result));
		return TRUE;
	}
	
	
	function is_image_filename($filename)
	{
		if( strlen($filename) < 3 )
		{
			return FALSE;
		}
		
		$file_ext = substr($filename, count($filename) - 5);
		if( $file_ext == '.jpg' || $file_ext == '.png' || $file_ext == '.jpg' )
		{
			return TRUE;
		}
		
		return FALSE;
	}
} // END class 