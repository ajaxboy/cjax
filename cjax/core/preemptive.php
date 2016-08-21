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
 *   Date: 2/12/2007                           $
 *   File Last Changed:  10/05/2013            $
 **####################################################################################################    */


include_once 'cjax_config.php';
$ajax = ajax();


/**
 * Handle mod_rewrite redirects
 */
if(isset($_SERVER['REDIRECT_QUERY_STRING']) && $_SERVER['REDIRECT_QUERY_STRING']) {
	$_SERVER['QUERY_STRING'] = $_SERVER['REDIRECT_QUERY_STRING'];
} else if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] && !$_SERVER['QUERY_STRING']) {
	$_SERVER['QUERY_STRING'] = ltrim($_SERVER['PATH_INFO'],'/');
}


/**
 * Handle friendly URLS
 */
if((isset($_SERVER['QUERY_STRING']) && $query = $_SERVER['QUERY_STRING'])) {

	$packet = explode('/' ,rtrim($query,'/'));
	if(count($packet) == 1) {
		$is_plugin = $packet[0];
		if($plugin = $ajax->isPlugin($is_plugin))  {
			if(!defined('AJAX_VIEW')) {
				define('AJAX_VIEW', true);
			}
		}
	}
	$allowed = array ('test');
	$controller = $function = null;

	if($packet && count(array_keys($packet)) >= 2 && $packet[0] && $packet[1]) {
		$controller  = $packet[0];
		$function 	 = $packet[1];

		if(count(array_keys($packet)) > 2) {
			unset($packet[0]);
			unset($packet[1]);
			if($packet){
				$params = range('a','z');
				foreach($packet as $k  => $v) {
					$_REQUEST[current($params)] = $v;
					next($params);
				}
			}
		}
	} else  {
		if(!$ajax->input('controller')) {
			if(count($packet)==1) {
				$url = explode('&',$_SERVER['QUERY_STRING']);
				if(count($url) ==1){
					$controller = $packet[0];
				}
			}
		} else {
			$controller = $_REQUEST['controller'];
			$function = isset($_REQUEST['function'])? $_REQUEST['function'] : null;
		}
	}

	if($ajax->isAjaxRequest() || defined('AJAX_VIEW') || in_array($controller, $allowed)) {
		$_REQUEST['controller'] = $controller;
		$_REQUEST['function'] = $function;
		$_REQUEST['cjax'] = time();
	}
	$ajax->controller 	= 	$controller;
	$ajax->function 	= 	$function;
}

if(!$ajax->isAjaxRequest()) {

	if(count(array_keys(debug_backtrace(false))) == 2) {

		if(!defined('AJAX_VIEW') && !in_array($controller, $allowed)) {
			exit("Security Error. You cannot access this file directly.");
		}
	}
}