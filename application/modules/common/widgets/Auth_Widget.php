<?php

class Auth_Widget extends Widget {

	//Extract Auth Data From Authentication 
	protected function _getAuth(){
		//Local Variables
		$l_user = $this->authentication->check_login(1); /*Get User Information*/
		$l_auth = array();
		
		//Data to Pass to View
		$l_auth['logged_in'] = isset($l_user->user_id);
		$l_auth['username'] = $l_auth['logged_in'] ? $l_user->username : null;
		$l_auth['user_id'] = $l_auth['logged_in'] ? $l_user->user_id : null;
		
		return $l_auth;
	}
	
	//Call View
	protected function _view($p_template, $p_view, $p_data = array()){
		$this->view(
			'widgets/' . $p_template . '/' . $p_view, 
			$p_data
		);
	}
	
	//Checked If Logged In
	protected function _isLoggedIn(){
		return $this->_getAuth()['logged_in'];
	}
}