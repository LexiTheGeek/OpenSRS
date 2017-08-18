<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Layout Container
if(!isset($config['layouts'])){
	$config['layouts'] = array();
}

//Layout Container
$config['layouts']['gentallela'] = array();

//Variables (Can use in layout view as $this->template->[VARIABLE] )
$config['layouts']['gentallela']['title'] = 'Open Ed';
$config['layouts']['gentallela']['site_header'] = 'CCRI SRS';
$config['layouts']['gentallela']['site_icon_class'] = 'fa fa-book';

 
//Meta Tags
$config['layouts']['gentallela']['meta'] = array(); 