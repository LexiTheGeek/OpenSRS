<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class API extends MY_Controller {
    
	//Check Access to Requested Resource
	public function hasAccess(){		
		//Local Variables
		$r_json = new stdClass();
		$r_json->loggedIn = $this->verify_min_level(1);
		$r_json->hasAccess = false;	
		$r_json->userID = '';
		
		//Get Access
		if($r_json->loggedIn){
			$r_json->hasAccess = $this->has_access($this->input->post('acl'));
			$r_json->userID = $this->auth_user_id;
			
		}
		
		//Output is JSON
		header('Content-Type: application/json');
		echo json_encode($r_json);	
	}
	
}