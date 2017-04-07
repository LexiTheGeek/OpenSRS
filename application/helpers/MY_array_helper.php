<?php defined('BASEPATH') OR exit('No direct script access allowed');

//array_to_object by Jacob Relkin
//http://stackoverflow.com/questions/4790453/php-recursive-array-to-object
if( ! function_exists('array_to_object') ){
	function array_to_object($array) {
		$obj = new stdClass;
		foreach($array as $k => $v) {
			if(strlen($k)) {
				if(is_array($v)) {
				   $obj->{$k} = array_to_object($v); //RECURSION
				} else {
				   $obj->{$k} = $v;
				}
			}
		}
		return $obj;
	} 
}

//Stack Overload Original Poster Not Named
//http://stackoverflow.com/questions/4345554/convert-php-object-to-associative-array
if( ! function_exists('object_to_array') ){
	function object_to_array($data)
	{
		if (is_array($data) || is_object($data))
		{
			$result = array();
			foreach ($data as $key => $value)
			{
				$result[$key] = object_to_array($value);
			}
			return $result;
		}
		return $data;
	}
}