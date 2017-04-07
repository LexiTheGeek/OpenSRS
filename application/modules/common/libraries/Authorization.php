<?php if (!defined("BASEPATH"))  exit("No direct script access allowed");
/**
 * @name        Authorization
 * @author      Alexia Hurley
 *
 *
 */
 
class Authorization {
	
	//Instance Variables
	private $_ci;
	private $_acl_dir;
	
	//Constructor
	public function __construct($p_config) {
		$this->_ci = & get_instance();
		$this->_acl_dir = $p_config['acl_dir'];
    }
	
	//Can Current User Execute [Controller]/[Method]
	public function has_access($p_request){

		//Test Permissions
		return count($this->acl_filter($this->_get_acl($p_request))) == 1;
	}

	//Filter Array or StdClass by ACL (Return Only Records User Qualifies For)
	public function acl_filter($p_data){
		$l_success = false;
		$l_data = !is_array($p_data) ? array($p_data) : $p_data;
		$r_records = array();
		
		//Loop Over Links
		foreach($l_data as $i_record){
			//Set Defaults
			$i_record->require = isset($i_record->require) ? $i_record->require : array();
			$i_record->require_one = isset($i_record->require_one) ? $i_record->require_one : array();
		
			//Check ACL Permissions
			if($this->_require($i_record->require) && $this->_require_one($i_record->require_one)){
				//Passed, Save For Output
				array_push($r_records, $i_record);
			}
		}
		
		return $r_records;
	}
	
	//Get Method Permissions
	private function _get_acl($p_request){
		return $this->_ci->json_manager->get($this->_acl_dir, $p_request);
	}
	
	//Require All Permissions in Array
	private function _require($p_permissions = null){
		//Local Variables
		$r_require = true;
		$l_permissions = isset($p_permissions) ? $p_permissions : array();
		$l_counter = 0;
		
		//Test required permissions
		while($r_require && $l_counter < count($l_permissions)){		
			$r_require = acl_permits($l_permissions[$l_counter++]);
		}
		
		return $r_require;
	}
	
	//Require One Permission in Array
	private function _require_one($p_permissions = null){
		//Local Variables
		$r_require_one = true;
		$l_permissions = isset($p_permissions) ? $p_permissions : array();
		$l_counter = 0;
		
		//Does Current Link Have Require One
		$r_require_one = ! count($l_permissions);
		
		//Test 'require_one' permissions
		while(!$r_require_one && $l_counter < count($l_permissions)){
			$r_require_one = acl_permits($l_permissions[$l_counter++]);
		}
		
		return $r_require_one;
	}
}
















 



