<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Navigation Config
|--------------------------------------------------------------------------
| This file will contain the display settings for main navigation
|
|
|
|
*/

//Fall Through Settings
$config['fall_through'] = array(); 
$config['fall_through']['enabled'] = true; 
$config['fall_through']['acl_dir'] = 'pages'; 

//Cookie Settings
$config['cookie'] = array();
$config['cookie']['enabled'] = true;
$config['cookie']['name'] = 'ah_nav';
$config['cookie']['expire'] = 10 * 60; //10 minutes
