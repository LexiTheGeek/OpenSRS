<?php

//Menu Object
require_once APPPATH . 'modules\common\objects\menu.php';

//Left Panel Navigation
class Side_Nav extends Widget {

    public function display($data) {
	
		//Create Menu
		$l_menu = new Menu( $this->_ci->navigation->get('side_menu') );
		
		//Display Widget View
		$this->view(
			'widgets/side_nav', 
			array(	"p_nav" => $l_menu->html('nav navbar-nav side-nav')	)
		);
		
	}
				   
}
			



