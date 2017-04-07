<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {

	/*** Will call the module/config/autoload.php for defined modules***/
	/***Autoloader w/ module autoload***/
	protected function _ci_autoloader(){
		//Call CI Autoloader
		parent::_ci_autoloader();
		
		//Call Module Autoloader
		$this->_modules_autoload();
	}

	/*** Autoload Modules ***/
	private function _modules_autoload(){
		//Variables
		$modules = Modules::settings();
		$location = $this->_module; 
		
		//Config Found
		if(isset($modules)){
			
			//Autoload Each Module
			foreach($modules['autoload'] as $module){
				
				//Make sure module is enabled
				if( !in_array($module, $modules['disabled']) ){
					//Define Module to Autoload
					$this->_module = $module;
					
					//Autoload Module
					$this->_autoloader(array());
				}

			}
			
			//Restore Location
			$this->_module = $location;
			
		}
	}
	
	//Load library - Now supports cross module loading
	public function library($library, $params = NULL, $object_name = NULL){	
		//Save Current Loaction
		$location = $this->_module;
		
		//Target Module
		$this->_module = isset($module) ? $module : $location;
		
		//Get Class Name
		$class = strtolower(basename($library));
		
		//Get Library
		$result = parent::library($library, $params, $object_name); //Bug Fix. Ensures is_loaded works

		//Bug Fix. Added ucfirst class name to ensure is_loaded() will find library
		$this->_ci_classes[$class] = ucfirst($this->_ci_classes[$class]);
		
		//Restore Location
		$this->_module = $location;
		
		return $result;
    }
	
}