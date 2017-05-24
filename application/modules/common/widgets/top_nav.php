<?php

require_once 'Auth_Widget.php';

//Top Navigation
class Top_Nav extends Auth_Widget {

    public function display($p_template) {
		$this->_view($p_template, 'top_nav', $this->_getAuth());
	}
				   
}
			



