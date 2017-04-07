<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Layout Container
if(!isset($config['layouts'])){
	$config['layouts'] = array();
}

//Layout Container
$config['layouts']['main'] = array();

//Variables (Can use in layout view as $this->template->[VARIABLE] )
$config['layouts']['main']['title'] = 'Open Ed';
$config['layouts']['main']['brand'] = 'CCRI Open Ed';
$config['layouts']['main']['header'] = 'CCRI';
$config['layouts']['main']['subheader'] = 'Dashboard';

//Style Sheets to Include
$config['layouts']['main']['stylesheet'] = array();
$config['layouts']['main']['stylesheet'][0] = asset_url() . 'css/bootstrap.min.css';
$config['layouts']['main']['stylesheet'][1] = asset_url() . 'css/sb-admin.css';

//Javascript to Include
$config['layouts']['main']['javascript'] = array();
$config['layouts']['main']['javascript'][0] = asset_url() . 'css/js/jquery.js';
$config['layouts']['main']['javascript'][1] = asset_url() . 'js/bootstrap.min.js';

//Meta Tags
$config['layouts']['main']['meta'] = array();
//$config['layouts']['main']['meta']['robots'] = 'index,follow';