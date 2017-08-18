<?php defined('BASEPATH') OR exit('No direct script access allowed');

//URL to CSS, JS, etc 
if ( ! function_exists('asset_url')){
	function asset_url(){
		return base_url().'assets/';
	}
}

//Build HMVC Url
if( ! function_exists('hmvc_url') ){
	function hmvc_url($p_module = null, $p_controller = null, $p_method = null){
		$r_url = site_url() . '/' . $p_module . '/' . $p_controller . '/' . $p_method;
		return preg_replace('~(\/)\1+~', '/', $r_url);
	}
}

//Build HMVC Path
if( ! function_exists('hmvc_path') ){
	function hmvc_path(){
		return APPPATH . 'modules' . DIRECTORY_SEPARATOR;
	}
}

//Find Module Name From Path
if( ! function_exists('module_from_path') ){
	function module_from_path($p_path){
		return explode('\\', str_replace(hmvc_path(), '', str_replace('/', DIRECTORY_SEPARATOR, $p_path)))[0];
	}
} 

//Find Module Name From Path
if( ! function_exists('module_path') ){
	function module_path($p_path){
		return hmvc_path() . module_from_path($p_path);
	}
}

//Is $p_url the same path as current_url() .... (catches appended 'index')
if( ! function_exists('is_current_url') ){
	function is_current_url($p_url){
		//Cleanup Regexp
		$l_regexp = '~(\/?(index)?)+\/?$~';
		
		//Determine Arg
		$l_url = strtolower(strpos($p_url, site_url()) === FALSE ? (site_url() . '/' . $p_url) : $p_url);
		$l_curr = strtolower(current_url());
		
		//Cleanup Paths
		$l_url = preg_replace($l_regexp, '', $l_url);
		$l_curr = preg_replace($l_regexp, '', $l_curr);
		
		//Paths Match
		return $l_url == $l_curr;
	}	
}