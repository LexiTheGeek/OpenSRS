<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| JSON Manager Config
|--------------------------------------------------------------------------
| This file will contain the settings for JSON_MANAGER 
|
|	Paths : An Array of Paths w/ Keys as Aliases
|
|	Will Autoload These Paths Into the JSON_MANAGER Object
|
*/

$config['json_manager'] = array();
$config['json_manager']['paths'] = array();
$config['json_manager']['paths']['pages'] = module_path(__FILE__) . '/config/pages';