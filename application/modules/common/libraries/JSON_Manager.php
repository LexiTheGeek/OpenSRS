<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

class JSON_Manager{
	
	//Instance Variables
	private $_dir; 
	private $_paths;
	
	//Constructor
	public function __construct($config = array()){
		$this->_paths = count($config) > 0 ? $config['json_manager']['paths'] : array();
	}
	
	//Split JSON Files into Component Parts
	public function split($p_reserved, $p_json, $l_path = array(), $p_dir = null){
	
		//Parse Args
		$l_reserved = !is_array($p_reserved) ? array($p_reserved) : $p_reserved;
		$l_json = is_string($p_json) ? json_decode(file_get_contents($p_json), true) : $p_json;
		$l_dir = isset($p_dir) ? $p_dir : $this->_extract_dir($p_json);

		//Loop Over Keys Recursively 
		foreach($l_json as $key => $val){
			
			//Create File
			if( in_array($key, $l_reserved) || count(array_keys($val)) == 0 ){
				//Get File Path
				$filepath = $l_dir . '\\' . implode('\\', $l_path);
				
				//Create Containing Directory
				@mkdir($filepath, 0777, true);
				
				//No Children, Create Empty Directory
				if(count(array_keys($val)) == 0){
					@mkdir($filepath . '\\' . $key, 0777, true);
				
				//Otherwise, Create File
				}else{
					file_put_contents($filepath . '\\' . $key . '.json', json_encode($val));
				}
			
			//Drill to Next Level
			}else{
				array_push($l_path, $key);
				$this->split($l_reserved, $val, $l_path, $l_dir);
				array_pop($l_path);
			}
		}	
	}
	
	//Get JSON Data
	public function get($p_path_or_alias, $p_request, $p_decode = true, $p_convert_to_array = false, $p_suppress_err = false){
		//Path to file
		$l_dir = isset($this->_paths[$p_path_or_alias]) ? $this->_paths[$p_path_or_alias] : $p_path_or_alias;
		$l_path = $this->_to_path($l_dir, $p_request);
		
		//Get File
		if($this->exists($l_path)){
			$l_file = file_get_contents($l_path); 
		}
		
		//File Not Found 
		if(!isset($l_file)){

			//Default to Empty Object
			$l_file = '{}';
			
			//Throw Error if Not Suppressed
			if(!$p_suppress_err){
				show_error('File Not Found');
			}
		}
		
		return $p_decode ? json_decode($l_file, $p_convert_to_array) : $l_file;
	}
	
	//Get JSON, suppress error if file does not exist
	public function optional($p_dir, $p_request, $p_decode = true, $p_convert_to_array = false){
		return $this->get($p_dir, $p_request, $p_decode, $p_convert_to_array, true);
	}
	
	//JSON File Exists
	public function exists($p_dir, $p_request = null){
		return isset($p_request) ? file_exists($this->_to_path($p_dir, $p_request)) : file_exists($p_dir);
	}
	
	//Register a Path
	public function add_path($p_path, $p_alias, $p_overwrite = false){
		
		//Check If We Are Overwriting Something
		if(!$p_overwrite && isset($this->_paths[$p_alias])){
			show_error('Attempting to Overwrite Path. Access Denied.');
		}
		
		//Add Path
		$this->_paths[$p_alias] = preg_replace('~(\\|\/)$~', '', $p_path);
		
		//Return For Chaining
		return $this;
	}
	
	//Remove a Path
	public function remove_path($p_alias){
		$r_success = isset($this->_paths[$p_alias]);
		
		unset($this->_paths[$p_alias]);
		
		return $r_success;
	}
	
	//Convert Args to Filepath
	private function _to_path($p_dir, $p_request){
		return $p_dir . '\\' . implode('\\', explode('.', $p_request)) . '.json';
	}
	
	//Extract Directory Name From File Name
	private function _extract_dir($p_filename){
		$r_dir = explode('\\', $p_filename);
		array_pop($r_dir);
		
		return implode('\\', $r_dir);
	}
}
