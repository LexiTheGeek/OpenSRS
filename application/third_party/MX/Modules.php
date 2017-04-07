<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

require_once 'MX_Modules.php';

class Modules extends MX_Modules{
	
	public static $settings;
	
	//Check if Module is Disabled
	private static function _is_disabled($p_path){
		//Extract Module
		$module = explode('\\', str_replace(APPPATH . 'modules\\', '', str_replace('/', DIRECTORY_SEPARATOR, $p_path)))[0];
		
		//Load Settings
		self::settings();
		
		//Check if Disabled
		return in_array($module, self::$settings['disabled']);
	}
	
	//Get Settings
	public static function settings(){
		//Get Settings Once
		if(!isset(self::$settings)){
			self::$settings = self::_modules_config();
		}
		
		return self::$settings;
	}
	
		/***Get APPPATH.'config/modules.php'***/
	private static function _modules_config(){
		if (file_exists(APPPATH.'config/modules.php'))
		{
			include(APPPATH.'config/modules.php');
		}
		
		if (file_exists(APPPATH.'config/'.ENVIRONMENT.'/modules.php')){
			include(APPPATH.'config/'.ENVIRONMENT.'/modules.php');
		}
		
		if ( ! isset($modules)){
			show_error('File Not Found');
		}
		
		return $modules;
	}
	
	/** Load a module file **/
	public static function load_file($file, $path, $type = 'other', $result = TRUE)	
	{
		//Check If Module is Disabled
		if(self::_is_disabled($path)){
			show_error('Module \'' . $path . '\' is Disabled.');
		}
		
		return parent::load_file($file, $path, $type, $result);	
	}

}