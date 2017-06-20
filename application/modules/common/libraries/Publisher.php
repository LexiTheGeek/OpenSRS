<?php
/**
 * @name        CodeIgniter Template Publisher
 * @author      Alexia Hurley
 *
 * Library that simplifies the use of Jenn Segers Template Library
 *
 * Dependencies: Jens Segers Template Library
 *
 * Classes:
 *		Page
 *		Publisher
 *
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Publisher {
	
	//Instance Variables
	private $_ci;
	private $_config;
	
	//Constructor
	public function __construct($config = array()) {
		//Get CI reference
		$this->_ci = & get_instance();	

		$this->_config = $config;
    }
	
	//Get Object Settings
	private function _settings($p_which){
		return $this->_config[$p_which];
	}
	
	/*Public Access to $this->_publish*/
	public function publish($p_page, $p_settings = null){	
		//Determine call signiture
		
		//String
		if( is_string($p_page) ){
			$l_page = $this->page($p_page, $p_settings);
		
		//Page Model
		}elseif($p_page instanceof Page){
			$l_page = $p_page;
			
			//Settings Provided
			if(isset($p_settings)){
				$l_page->merge($this->page($p_settings));
			}
		}else{
			show_error('Unrecognized Function Signature: publisher->publish');
		}
	
		//Validate Page Members
		$l_args = $this->_validate_publish_args($l_page->views, $l_page->config, $l_page->layout, $l_page->data);
		
		//Publish Page
		$this->_publish($l_args['views'], $l_args['config'], $l_args['layout'], $l_args['data']);
	}
	
	//Validate Args Passed to Publish - Returns Correctly Formatted Args
	private function _validate_publish_args($p_views = array(), $p_config = array(), $p_layout = null, $p_data = array()){
		//Local Variables
		$l_parsed = false;
		$l_validKeys = ['views', 'layout', 'config', 'data'];
		$l_args = array();
		$r_args = array();
		
		//Do Arguments Need Parsing
		if	( 	func_num_args() == 1 && is_array($p_views) && count($p_views) > 0
				&& count(array_diff(array_keys($p_views), $l_validKeys)) == 0	//No Invalid Keys
			){
			
			//Parse Arguments
			$l_args['views'] = isset($p_views['views']) ? $p_views['views'] : array();
			$l_args['config'] = isset($p_views['config']) ? (array)$p_views['config'] : array();
			$l_args['data'] = isset($p_views['data']) ? (array)$p_views['data'] : array();
			$l_args['layout'] = isset($p_views['layout']) ? $p_views['layout'] : null;
			
			$l_parsed = true;
		}
		
		//UnParsed
		if(!$l_parsed){
			$r_args['views'] = $p_views; 
			$r_args['config'] = (array)$p_config;
			$r_args['data'] = (array)$p_data;
			$r_args['layout'] = $p_layout;
		
		//Parsed
		}else{
			$r_args['views'] = $l_args['views']; 
			$r_args['config'] = $l_args['config'];
			$r_args['data'] = $l_args['data'];
			$r_args['layout'] = $l_args['layout'];
		}
		
		return $r_args;
	}
	
	/*Build and Output Webpage*/
	private function _publish($p_views = array(), $p_config = null, $p_layout = null, $p_data = null){
		//Choose Layout or Use Default
		if(isset($p_layout)){
			$this->_layout($this->_settings('layout_config') . '/' . $p_layout);
		}

		//Build Path
		$this->_layout	(	'../../'
							. module_from_path(__FILE__)
							. '/views/' 
							. $this->_layout() //Layout File
						);
		
		//Configure Display Settings
		$this->_display_settings($p_config);

		//Load Content
        foreach($p_views as $i_view){
			$this->_ci->template->content->view($i_view->path, isset($i_view->data) ? $i_view->data : array());
		}
		
		// Publish the template
		$this->_ci->template->publish((array)$p_data);
	}
	
	//Get or Set Current Layout
	private function _layout($p_layout = null){
		//Set
		if(isset($p_layout)){
			$this->_ci->template->set_template($p_layout);
			
			return true;
		
		//Get
		}else{
			return $this->_ci->template->current_template();
		}
		
	}
	
	/***Get Display Settings From Config***/
	private function _display_settings($p_config = array()){
		//Determine Which Layout Variables to Load
		$l_layout = explode('/', $this->_ci->template->current_template());
		$l_layout = array_pop($l_layout);
		
		//Get Config For Layout
		$this->_ci->load->config($this->_settings('layout_config') . '\\' . $l_layout);
		$l_config = $this->_ci->config->item($l_layout, $this->_settings('layout_config'));
	
		//Merge Defaults With P_CONFIG
		$l_config = $this->_merge_settings($l_config, $p_config);
	
		//Config Not Found For Layout
		if(!isset($l_config)){
			throw new Exception('Layout settings not found for layout: "' . $l_layout . '"');
		}
		
		//Get Config Fields
		$l_fields = array_keys($l_config);
		
		//Set Fields
		foreach($l_fields as $i_field){
				
			switch(strtolower($i_field)){
				//Meta Tags
				case 'meta' :
					foreach($l_config[$i_field] as $i_tag => $i_val){
						$this->_ci->template->meta->add($i_tag, $i_val);
					}
					
					break;
				
				//Javascript Includes
				case 'stylesheet' :
				case 'javascript' :
					foreach($l_config[$i_field] as $i_src){
						$this->_ci->template->$i_field->add($i_src);
					}
					
					break;
				
				//Set Variables
				default :
					$this->_ci->template->$i_field->set(isset($p_config[$i_field]) ? $p_config[$i_field] : $l_config[$i_field]);
					
					break;
			}			
		}
	}
	
	//Merge Defaults and Custom Config
	private function _merge_settings($p_set1, $p_set2 = array()){
		//Local Variables
		$l_collections = array('javascript', 'stylesheet');
	
		//Merge Collections
		foreach($l_collections as $i_which){
			//Merge
			$p_set1[$i_which] = $this->_merge_collection(
									isset($p_set1[$i_which]) ? $p_set1[$i_which] : array(), 
									isset($p_set2[$i_which]) ? $p_set2[$i_which] : array()
								);
			
			//Remove Merged
			unset($p_set2[$i_which]);
		}
	
		//Merge 
		return array_merge($p_set1, $p_set2);
	}
	
	//Merge Setting Collection (1 key in config object)
	private function _merge_collection($p_set1, $p_set2 = array()){
		//Local Variables
		$l_matches = array();
		$l_merged = false;

		//Add Records
		if( isset($p_set2['add']) ){
			$p_set1 = array_merge($p_set1, $p_set2['add']); 
			
			$l_merged = true;
		}
		
		//Remove Records
		if( isset($p_set2['remove']) ){
			
			//Find Records to Be Removed
			$l_matches = array_intersect(
				array_map('strtolower', $p_set1), 
				array_map('strtolower', $p_set2['remove'])
			);

			//Remove Each Record
			foreach($l_matches as $i_file){
				unset($p_set1[array_search($i_file, array_map('strtolower', $p_set1))]);	
			}
			
			//Reindex
			$p_set1 = array_values($p_set1);
			
			//Flag As Merged
			$l_merged = true;
		}
		
		//Object Has Been Processed And Should Be Removed Prior to Merging
		//If p_set2[FIELD] Was Array, Skip Step
		if($l_merged){
			$p_set2 = array();
		}
	
		//Merge Values
		return array_merge(isset($p_set2) ? $p_set2 : array(), $p_set1);
	}
	
	//Load JSON File
	private function _page_defaults($p_filename){	
		//Return Variable
		$r_defaults = array();
		
		//Find dir we want to search
		$l_dir = module_path(__FILE__) . '/config/' . $this->_settings('page_config');
		
		//Defaults to Find
		$l_required = array('views');
		$l_optional = array('config', 'data');
		
		//Flag
		$l_req_ind = true;
		
		//Loop Over Default to Find
		foreach(array_merge($l_required, $l_optional) as $i_file){
			
			//Detect When We Begin Processing Optional Files
			if($l_req_ind && !in_array($i_file, $l_required) ){		
				$l_req_ind = false;
			}
			
			//Add Defaults to Collection
			if($l_req_ind){
				//Required
				$r_defaults[$i_file] = $this->_ci->json_manager->get($l_dir, $p_filename . '.' . $i_file);
			}else{
				//Optional
				$r_defaults[$i_file] = $this->_ci->json_manager->optional($l_dir, $p_filename . '.' . $i_file);
			}
			
		}
		
		return $r_defaults;
	}
	
	//Factory for Model 'Page'
	public function page($p_filename, $p_data = null){			
		//Parse Arguments		
		$l_defaults = is_string($p_filename) ? $this->_page_defaults($p_filename): null;
		$l_data = 	isset($p_data) 
						? $p_data 
						: (isset($p_filename) && !is_string($p_filename) 
							? $p_filename 
							: null);
		
		//Build Page Based on Args
		switch( (isset($l_defaults) ? 1 : 0) + (isset($l_data) ? 2 : 0) ){
				//Filename Only
				case 1 :
					$r_page = new Page($l_defaults);
					break;
				
				//Data Only
				case 2 :
					$r_page = new Page($l_data);
					break;
				
				//Filename & Data
				case 3 :
					$r_page = (new Page($l_defaults))->merge(new Page($l_data));
					break;
				
				default : 
					show_error('Invalid Arguments Passed to publisher::page');
		}
		
		return $r_page;		
	}
}

class Page {
	
	//Instance Variables
	public $layout;
	public $config;
	public $views;
	public $data;
	
	//Constructor
	public function __construct($p_settings = null) {
		//Initialize Object
		return $this->initialize($p_settings);	
    }

	//Configure Object
	private function initialize($p_settings = array()){
		//Force Arg to stdClass
		$l_settings = is_array($p_settings) ? (object)$p_settings : $p_settings;
		
		//Set Layout
		$this->layout = isset($l_settings->layout) ? $l_settings->layout : null; 
		
		//Set Config
		$this->config = isset($l_settings->config) ? (object)$l_settings->config : new StdClass();
		
		//Set Template Data
		$this->data = isset($l_settings->data) ? (object)$l_settings->data : new StdClass();
		
		//Set Views
		$this->views = array();
		
		if(isset($l_settings->views)){
			foreach($l_settings->views as $i_view){	
				//Data Provided in JSON?
				if(!isset($i_view->data)){
					$i_view->data =  new stdClass(); //Default data to empty object
				}
				
				//Append to Collection
				array_push($this->views, $i_view);
			}
		}	
		
		return $this;
	}
	
	//Return a view
	public function view($p_indexOrPath){
		return $this->views[$this->find_view($p_indexOrPath)];
	}
	
	//Length of View Array
	public function length(){
		return count($this->views);
	}
	
	//Does view exist in collection
	public function exists($p_indexOrPath){
		return $this->find_view($p_indexOrPath) != -1;
	}
	
	//Find view in $this->views
	private function find_view($p_indexOrPath){		
		$l_searchFor = strtolower($p_indexOrPath);
		$r_location = -1;
		
		//Find By Index
		if(is_numeric($l_searchFor)){

			if(isset($this->views[$l_searchFor])){
				$r_location = $l_searchFor;
			}
		
		//Find By Path
		}else{
			
			foreach($this->views as $i_index => $i_view){
				if($l_searchFor == strtolower($i_view->path)){
					$r_location = $i_index;
					break;
				}
			}
		}
		
		return $r_location;
	}
	
	//Add view to page
	public function add_view($p_path, $p_data = null, $p_index = null){
		//Find insert index
		$l_index = isset($p_index) ? $p_index : count($this->views);
		
		//Build View
		$l_view = (object)array(
			'path' => $p_path,
			'data' => isset($p_data) ? $p_data : new stdClass()
		);
		
		//Insert placeholder at index* 
		//  *array_splice cannot handle nested stdClass() objects
		//   this is a workaround
		array_splice(	$this->views, 
						$l_index, 
						0, 
						'[PLACE_HOLDER]'
					);
		
		//Replace Placeholder
		$this->views[$l_index] = $l_view;
		
		return $this;
	}
	
	//Public Access to Remove Method
	public function remove_view($p_indexOrPath, $p_removeAll = false){
		$this->_remove_view($p_indexOrPath, $p_removeAll);
	}
	
	//Remove view from page
	private function _remove_view($p_indexOrPath, $p_removeAll = false, $p_removed = null){
		//Get Removed Elements
		$l_viewIndex = $this->find_view($p_indexOrPath);
		$l_viewPath = $l_viewIndex > -1 ? $this->views[$l_viewIndex]->path : '';
		$l_nextIndex = null;
		$r_removed = isset($p_removed) ? $p_removed : array();
		
		//View Found
		if(strlen($l_viewPath) > 0){
			//Remove Element & Append to Removed List
			array_push	(	$r_removed, 
							array_splice($this->views, $l_viewIndex, 1)		);
			
			//Remove all instances of this view
			if($p_removeAll){
				
				//Another Instance Exists
				$l_nextIndex = $this->find_view($l_viewPath);

				if($l_nextIndex > -1){
					//Recurse
					$r_removed = $this->remove_view($l_nextIndex, $p_removeAll, $r_removed);	
				}
			}
		}
		
		//Determine Return Type
		switch( count($r_removed) ){
			//Nothing Removed
			case 0 	: 
				$r_removed = false;
				break;
			
			//One Element Removed
			case 1 	:
				$r_removed = $r_removed[0];
				break;
			
			//Else, Multiple Elements Removed
		}
		
		return $r_removed;
	}
	
	//Merge 2 Page Objects together
	public function merge($p_page){
		//Local Variables
		$l_merge_fields = array('config', 'data');
		
		//Validate Arg
		if(! $p_page instanceof Page){
			show_error('Invalid Argument Passed to publisher:merge');
		}

		//Merge Template Field
		$this->layout = isset($p_page->layout) ? $p_page->layout : $this->layout;
		
		//Merge Objects (Overwritting $this with $p_page if conflict)
		foreach($l_merge_fields as $i_field){
			foreach($p_page->$i_field as $k => $v){ 
				$this->$i_field->$k = $v;
			}
		}
		
		//Merge Views
		for($i_counter = 0; $i_counter < $p_page->length(); $i_counter++){
			//Record view to save on lookup overhead
			$l_view = $p_page->view($i_counter);
			
			//Check for matching view in $this
			$l_location = $this->find_view($l_view->path);
			
			//View Not Found in $this
			if( $l_location == -1 ){
				//Copy view
				$this->add_view($l_view->path, $l_view->data);
				
			//Found but no data exists in $this->view
			}elseif( count(array_keys((array)$this->views[$l_location]->data)) == 0 ){
				//Remove existing
				$this->remove_view($l_location);
				
				//Copy
				$this->add_view($l_view->path, $l_view->data, $l_location);	
			
			//Found but no data exists in $l_view->view
			}elseif( count(array_keys((array)$l_view->data)) == 0 ){
				//Do Nothing
			
			//Found, data exists in both
			}else{
				//Merge Data
				foreach($l_view->data as $k => $v){ 
					$this->views[$l_location]->$data->$k = $v;
				}
			}
		}
		
		return $this;
	}
	
}