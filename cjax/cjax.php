<?php
//@app_header;


include_once 'core/cjax_config.php';
$ajax = ajax();

/**
 * Handle mod_rewrite redirects
 */
if(isset($_SERVER['REDIRECT_QUERY_STRING']) && $_SERVER['REDIRECT_QUERY_STRING']) {
	$_SERVER['QUERY_STRING'] = $_SERVER['REDIRECT_QUERY_STRING'];
} else if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] && !$_SERVER['QUERY_STRING']) {
	$_SERVER['QUERY_STRING'] = ltrim($_SERVER['PATH_INFO'],'/');
}

$file = 'ajax.php';
if(isset($_SERVER['SCRIPT_NAME'])) {
	$file = preg_replace("/.+\//",'', ltrim($_SERVER['SCRIPT_NAME'],'/'));
}
if(defined('AJAX_FILE') && AJAX_FILE !=$file) {
	return true;
}

/**
 * Handle friendly URLS
 */
if(isset($_SERVER['QUERY_STRING']) && $query = $_SERVER['QUERY_STRING']) {
	$packet = explode('/' ,rtrim($query,'/'));
	if(count($packet) == 1) {
		$is_plugin = $packet[0];
		if($plugin = $ajax->isPlugin($is_plugin))  {
			if(!defined('AJAX_VIEW')) {
				define('AJAX_VIEW', true);
			}
		}
	}
	if($ajax->isAjaxRequest() || defined('AJAX_VIEW') ) {
		if($packet && count(array_keys($packet)) >= 2 && $packet[0] && $packet[1]) {
			$_REQUEST['controller'] = $packet[0];
			$_REQUEST['function'] = $packet[1];
			$_REQUEST['cjax'] = time();
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
						$_REQUEST['controller'] = $packet[0];
					}
				}
			}
		}
	}
}

if(!$ajax->isAjaxRequest()) {
	if(count(array_keys(debug_backtrace(false))) == 1 && !defined('AJAX_VIEW')) {
		exit("Security Error. You cannot access this file directly.");
	}
}

