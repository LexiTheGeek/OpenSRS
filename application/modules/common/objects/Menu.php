<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Menu{
	//Instance Variables
	private $_anchors;
	private $_format;
	
	//Constructor
	public function __construct($p_nav) {
		$this->_initialize($p_nav);
    }
	
	//Init
	private function _initialize($p_nav){
		//Defaults
		$this->_anchors = array();
		$this->_format = '[CONTENT]';
		
		//Fill Collection
		foreach($p_nav as $i_link){
			array_push($this->_anchors, new Anchor($i_link->url, $i_link->text));
		}
	}
	
	//Set Wrapper For Each Anchor
	public function format($p_format){
		//Format Must Be Function or String That Includes Substr of '[CONTENT]'
		if( is_callable($p_format) || (is_string($p_format) && strpos($p_format, '[CONTENT]') !== FALSE) ){
			$this->_format = $p_format;
		}else{
			show_error('Invalid Argument Passed to menu::format');
		}
		
		return $this;
	}
	
	//Return Menu String
	public function write($p_delimiter = ''){
		//Local Variables
		$r_anchors = array();
		
		//Add Formatting to Each Link
		foreach($this->_anchors as $i_anchor){
			
			//String Replace [CONTENT]
			if(is_string($this->_format)){
				
				array_push	( 	$r_anchors, 
								str_replace(	'[CONTENT]', 
												$i_anchor->write(), 
												$this->_format
											) 
							);
			
			//Function Output
			}else{
				array_push	(	$r_anchors, 
								call_user_func($this->_format, $i_anchor)
							);
			}
		}
		
		//Return Menu
		return implode($p_delimiter, $r_anchors);
	}
}

class Anchor{
	//Instance Variables
	public $href;
	public $text;
	
	//Constructor
	public function __construct($p_href, $p_text) {
		$this->href = $p_href;
		$this->text = $p_text;
    }
	
	//Write Anchor
	public function write(){
		echo $this->href . '<br>';
		
		
		return '<a href="' . str_replace('.', '/', $this->href) . '">' . $this->text . '</a>';
	}
	
}