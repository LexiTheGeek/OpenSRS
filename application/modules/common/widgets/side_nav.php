<?php

//Menu Object
require_once APPPATH . 'modules\common\objects\menu.php';

//Left Panel Navigation
class Side_Nav extends Widget {

    public function display($data) {
	
		//Create Menu
		$l_menu = new Menu( $this->_ci->navigation->get('side_menu') );

		//Set Display Template
		$l_menu->format(	
			function($p_anchor){
				return '<li ' . (is_current_url($p_anchor->href) ? ' class="active"' : '') . '>' . $p_anchor->write() . '</li>';
			}
		);
		
		//Display Widget View
		$this->view(
			'widgets/side_nav', 
			array(	"p_nav" => $l_menu->write()	)
		);
		
	}
				   
}
			



