<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Menu{
	//Instance Variables
	private $_data;
	
	//Constructor
	public function __construct($p_nav) {
		$this->_data = $p_nav;
    }
	
	//Get Menu HTML
	public function html($p_ul_class = null, $p_li_class = null, $p_data = null){
		//Open List
		$l_data = isset($p_data) ? $p_data : $this->_data;
		$l_content = isset($p_ul_class) ? '<ul class="' . $p_ul_class . '">' : '<ul>';
		
		//Loop Over Links
		foreach($l_data as $i_link){
			//Open List Item
			$l_content = $l_content . '<li>';
			
			//Write Anchor
			$l_content = $l_content . (new Anchor($i_link->url, $i_link->text))->write();
			
			//Check For Sub-Menus
			if(isset($i_link->sub) && count($i_link->sub) > 0){
				//Recurse
				$l_content = $l_content . $this->html(null, null, $i_link->sub);
			}
			
			//Close List Item
			$l_content = $l_content . '</li>';
		}
		
		//Close List
		$l_content = $l_content . '</ul>';
		
		return $l_content;
	}
}

class Anchor{
	//Instance Variables
	public $href;
	public $text;
	
	//Constructor
	public function __construct($p_href, $p_text, $p_children = array()) {
		$this->href = $p_href;
		$this->text = $p_text;
    }
	
	//Write Anchor
	public function write(){
		return '<a href="' . str_replace('.', '/', $this->href) . '">' . $this->text . '</a>';
	}
	
}