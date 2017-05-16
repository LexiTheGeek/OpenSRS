<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Community Auth - Crons Controller
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2017, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

class Crons 
{
	
    public function auth_sessions_gc(){
        $auth_model = $this->authentication->auth_model;

        $this->{$auth_model}->auth_sessions_gc();
    }
	
	//Explode ACL File Into It's Components
	public static function explode_acl_file($p_filename){
		$l_fields = array('views', 'acl', 'config', 'data');
		$l_success = file_exists($p_filename);
		
		if(!$l_success){
			//Error
		}
		
		get_instance()->json_manager->split($l_fields, $p_filename);
	}
    
    // -----------------------------------------------------------------------
}

/* End of file Crons.php */
/* Location: /auth/controllers/Crons.php */
