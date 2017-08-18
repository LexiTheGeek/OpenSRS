<?php

require_once 'Auth_Widget.php';

//Top Navigation
class Menu_Widget extends Auth_Widget {

	public function display($p_template, $p_view, $p_menu_name, $p_format = null) {			
		//Local variables
		$l_doc;
		
		//Is Logged In
		if( $this->_isLoggedIn() ){
			
			//Get Menu DOM
			$l_doc = $this->_menuDOM($p_menu_name); //Build Base Menu 
			$l_doc = isset($p_format) ? $p_format($l_doc) : $l_doc;
			
			//Send HTML to View
			$this->_view($p_template, $p_view, array( $p_menu_name =>  $l_doc->saveHTML() ));
		}
	}
	
	//Convert Menu Into HTML DOM
	protected function _menuDOM($p_menu_name){
		//Return HTML
		return $this->_menuToDOM($this->_menu($p_menu_name));
	}
	
	//Get Menu From Navigation
	private function _menu($p_menu_name){
		return $this->_ci->navigation->get($p_menu_name);
	}
	
	//Convert Menu to HTML
	private function _menuToDOM($p_menu){
		//Local Variables
		$r_html = new DOMDocument();
		$l_html_ul = $r_html->createElement('ul');
		$l_html_a;
		$l_html_li;
		$l_html_sub;
		
		//Build List
		foreach($p_menu as $i_link){
			
			//Create List Item
			$l_html_li = $r_html->createElement('li');

			//Add Anchor to List Item
			$l_html_li->appendChild( $this->_createElementA($r_html, $i_link) );
			
			//Has Sub Menu
			if(isset($i_link->sub) && count($i_link->sub)){
				
				//Build Sub Menu
				$l_html_sub = $this->_menuToDOM($i_link->sub); //Recurse

				//Extract Top Element
				$l_html_sub = $r_html->importNode($l_html_sub->documentElement, true);
				
				//Append to Current List Item
				$l_html_li->appendChild($l_html_sub);
				
			}
			
			//Add List Item to List
			$l_html_ul->appendChild($l_html_li);
		}
		
		//Append List to DOM
		$r_html->appendChild($l_html_ul);
		
		return $r_html;
	}
	
	//Create Anchor Element
	private function _createElementA($p_dom, $p_link){
		//Local Variables
		$l_html_a = $p_dom->createElement('a'); //Build Anchor
		$l_html_i = isset($p_link->icon) ? $this->_icon($p_dom, $p_link->icon) : null; //Build Icon
		
		//Anchor HREF
		if(isset($p_link->url)){
			$l_html_a->setAttribute('href', site_url(str_replace('.', '/', $p_link->url)) ); 
		}

		//Insert ICON (Chance #1)
		if( !is_null($l_html_i) && $l_html_i->getAttribute('position') == 'BEFORE_TEXT' ){	
			$l_html_i->removeAttribute('position');
			$l_html_a->appendChild($l_html_i);	
		}
		
		//Add Text
		$l_html_a->appendChild($p_dom->createTextNode($p_link->text)); //Add Anchor Text
	
		//Insert ICON (Chance #2)
		if( !is_null($l_html_i) && $l_html_i->getAttribute('position') == 'AFTER_TEXT' ){	
			$l_html_i->removeAttribute('position');
			$l_html_a->appendChild($l_html_i);	
		}
	
		return $l_html_a;
	}
	
	//Create Icon Element
	private function _icon($p_dom, $p_icon){
		//Local Variables
		$l_icon;
		$l_class;
		$l_position;
		$l_defaultPos = "BEFORE_TEXT";
	
		//Icon = String
		if(is_string($p_icon)){
			$l_class= $p_icon;
			$l_position = $l_defaultPos;
		
		//Icon = Object
		}else{
			$l_class = isset($p_icon->class) ? $p_icon->class : null;
			$l_position = isset($p_icon->position) ? $p_icon->position : $l_defaultPos;
		}
		
		//Create Icon
		$l_icon = $p_dom->createElement('i');
		$l_icon->setAttribute('class', $l_class);
		$l_icon->setAttribute('position', $l_position);
		
		return $l_icon;
	}
}


