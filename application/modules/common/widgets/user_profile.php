<?php

require_once 'Auth_Widget.php';

//User Profile 
class User_Profile extends Auth_Widget {

    public function display($p_template) {
		if($this->_isLoggedIn()){
			$this->_view($p_template, 'user_profile', $this->_getAuth());
		}
	}
				   
}
			



