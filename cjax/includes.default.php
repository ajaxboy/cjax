<?php

define('AJAX_INCLUDES', true);
/**
 * Here you may include any dependencies that you may need for authentication 
 * or others files or dependencies you may need.
 */

## Your includes go here.
//eg. require_once 'your/file.php';

/**
* Clean input function:
* here you may filter any input that is passed through parameters or inputs in general.
* You may change or replace this function as you see fit, the code here is just minimal filtering.
 */
function cleanInput($input,$type = null)
{
	switch($type) {
		//these are the parameters passed through function parameters, a,b,c,d etc..
		case 'args':
			if(is_array($input)) {
				foreach($input as $k => $kv ) {
					if(!is_array($kv)) {
						$return[$k] =  addslashes($kv);
					} else {
						foreach($kv as $k_level => $v_level2) {
							$return[$k][$k_level] = $v_level2;
						}
					}
				}
				$input = $return;
			} else {
				$input = addslashes($v);
			}
		break;
		case '_REQUEST':
			//
		break;
		case '_POST':
			//
		break;
		case '_GET':
			//
		break;
		default:
			//other inputs
	}
	
	return $input;
}