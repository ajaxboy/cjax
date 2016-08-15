<?php
/** ################################################################################################**
 * CJ Galindo Copyright (c) .
 * Permission is granted to copy, distribute and/or modify this document
 * under the terms of the GNU Free Documentation License, Version 1.2
 * or any later version published by the Free Software Foundation;
 * Provided 'as is' with no warranties, nor shall the autor be responsible for any mis-use of the same.
 * A copy of the license is included in the section entitled 'GNU Free Documentation License'.
 *
 *   ajax made easy with cjax
 *   -- DO NOT REMOVE THIS --
 *   -- AUTHOR COPYRIGHT MUST REMAIN INTACT -
 *   Written by: CJ Galindo
 *   Website: http://cjax.sourceforge.net                     $
 *   Email: cjxxi@msn.com
 **####################################################################################################    */



if(!defined('AJAX_CD')) {
	//if you experience a file not found error, and  AJAX_CD hasn't been defined anywhere
	//enter a relateive path to the base directory where the controllers are.
	define('AJAX_CD', 'response');
}
if(!defined('AJAX_WD')) {
	//directory where cjax directory is located
	//this allows you to move the cjax/ directory else where.
	//keep in mind that it need to remain accessibly through the url.
	define('AJAX_WD', dirname(__file__).'/cjax');
}

require_once AJAX_WD . '/' . 'ajax.php';

$ajax = ajax();