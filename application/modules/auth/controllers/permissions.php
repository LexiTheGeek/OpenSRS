<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Permissions extends MY_Controller {
    
	//Main Page
	public function index(){		
		if( $this->has_access('auth.permissions.index') ){	
			$this->publisher->publish('auth.permissions.index');	
		}
	}
	
}











