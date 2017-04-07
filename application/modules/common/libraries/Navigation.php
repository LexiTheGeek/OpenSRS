<?php if (!defined("BASEPATH"))  exit("No direct script access allowed");
/**
 * @name        Navigation
 * @author      Alexia Hurley
 *
 *
 */
 
class Navigation {

	//Instance Variables
	private $_ci;
	private $_data;
	private $_settings;
	
	//Constructor
	public function __construct($p_config) {
		$this->_ci = & get_instance();
		$this->_settings = $p_config;
		$this->_data = new stdClass();
    }

	//Init Object 
	private function _initialize(){	
		if( $this->_cookie_exists() ){
			$this->_data = json_decode($this->_nav_cookie());
		}
	}
	
	//Build Menu
	public function get($p_data, $p_name = null){		
		//Local Variables
		$l_name = isset($p_name) && is_string($p_name) ? $p_name : (is_string($p_data) ? $p_data : null);

		//Name Not Provided
		if(!isset($l_name)){
			show_error('Menu Name is Null');
		}
		
		//Calculate Navigation
		$this->_calc_nav($p_data, $l_name);
			
		//Return Data
		return $this->_data->$l_name;
	}
	
	//Remove User's Nav Cookie
	public function clear(){
		if($this->_config_item('cookie.enabled')){
			delete_cookie($this->_config_item('cookie.name'));
		}else{
			show_error('Cookies Are Disabled');
		}
		
		return $this;
	}

	//Calculate User's Navigation Using their ACL and Menu's Config
	private function _calc_nav($p_data, $p_name){		
		//Local Variables
		$l_calc_nav = true;
		$l_counter = 0;
		$l_fall_through = $this->_config_item('fall_through.enabled');		
					
		//Initalization Cannot Occur Until auth Finishes
		//So We Call Manually When We First Try to Access Library
		if(!$this->_is_init()){
			$this->_initialize();
		}
		
		//2nd+ call to object
		if( $this->_config_item('cookie.enabled') && $this->_cookie_exists() ){
			
			//Already Exists In $this->_data
			if(isset($this->_data->$p_name)){
				$l_calc_nav = false;
			}
		}
		
		//Calculate Navigation For User
		if($l_calc_nav){
			
			//Menu Data Container		
			$this->_data->$p_name = isset($this->_data->$p_name) ? $this->_data->$p_name : array();	
			
			//Load Menu Config
			$l_menu_data = $this->_get_menu_data($p_data);
			
			//Find Fall-Through Directory
			$l_dir = $this->_config_item('fall_through.acl_dir');
			
			//Loop Over Links
			foreach($l_menu_data as $i_link){				
				//Get ACL
				$l_acl = 	is_object($i_link) && isset($i_link->acl) 
							? $i_link->acl 
							: ($l_fall_through ? $this->_ci->json_manager->optional($l_dir, $i_link->url . '.acl') : array());
				
				//Has Access
				if(count(array_keys($this->_ci->authorization->acl_filter($l_acl))) == 1){

					//Get Ref to Menu Data
					$l_data_ref = & $this->_data->$p_name;
					
					//Calc Menu ACL
					$l_data_ref[$l_counter] = new stdClass();	
					$l_data_ref[$l_counter]->url = $i_link->url;	
					$l_data_ref[$l_counter++]->text = $i_link->text;			
				}
				
				
			}
		}
		
		//Save Changes to Cookie
		if( $this->_config_item('cookie.enabled') ){
			$this->_save_to_cookie();
		}	
	}
	
	//Object Initialized?
	private function _is_init(){
		return count(array_keys((array)$this->_data)) > 0;
	}
	
	//Find Menu to Process 
	private function _get_menu_data($p_data){

		//Import File
		if(is_string($p_data)){
			$r_menu_data = json_decode(file_get_contents(module_path(__FILE__). '\config\menus\\' . $p_data . '.json'));
		
		//Object Passed In
		}else if(is_object($p_data)){
			$r_menu_data = $p_data;
		
		}else{
			show_error('Menu Data Not Found');
		}
		
		return $r_menu_data;
	}
	
	
	//Does Nav Cookie Exist
	private function _cookie_exists(){
		return !is_null( $this->_nav_cookie() );
	}
	
	//Get Nav Cookie
	private function _nav_cookie(){
		return get_cookie($this->_config_item('cookie.name'));
	}
	
	//Get Navigation Config Item
	private function _config_item($p_which){
		//Local Variables
		$l_item = explode('.', $p_which);
		$r_val = null;
		
		switch( strtolower($p_which) ){
			case 'fall_through.enabled':
			case 'fall_through.acl_dir' 	:
			case 'cookie.enabled':
			case 'cookie.name':
			case 'cookie.expire':
				$r_val = $this->_settings[$l_item[0]][$l_item[1]];
				break;
			default :
				//Throw Error
				break;
		}
		
		return $r_val;
	}
	
	//Save menu to cookie
	private function _save_to_cookie(){
		//Is Logged In
		if($this->_ci->authentication->check_login(1)){
			
			//Encode for storage
			$l_cookie_str = json_encode($this->_data);
			
			//New cookie or cookie navigation has changed
			if(is_null($this->_nav_cookie()) || $this->_nav_cookie() != $l_cookie_str){
				
				//Save Results to Cookie
				$this->_ci->input->set_cookie($this->_config_item('cookie.name'), $l_cookie_str, $this->_config_item('cookie.expire'));
			}	
		}
	}
	
}
















 



