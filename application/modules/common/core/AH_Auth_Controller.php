<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - MY Controller
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2017, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */


require_once APPPATH .'modules/common/core/Auth_Controller.php';

class AH_Auth_Controller extends Auth_Controller
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	public function has_access($p_request){
		//Local Variables
		$r_access = false;
		
		// Check if logged in or if login attempt
		if( is_null( $this->auth_role ) ){
			$this->auth_data = $this->authentication->user_status( 1 );
		}

		// Set user variables if successful login or user is logged in
		if( $this->auth_data )
			$this->_set_user_variables();

		//Trigger Hook
		$this->post_auth_hook();

		// Successful login or user is logged in
		if( $this->auth_data ){
			//Check Permisssions
			$r_access = $this->authorization->has_access($p_request);
		
		//Need Redirect to Login
		}elseif($this->uri->uri_string() != LOGIN_PAGE ){
			$this->_redirect_to_login_page();
		}

		
		return $r_access;
	}
	
}

/* End of file MY_Controller.php */
/* Location: /auth/core/MY_Controller.php */