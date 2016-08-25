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
	define('AJAX_CD', 'controllers');
}
if(!defined('AJAX_WD')) {
	//directory where cjax directory is located
	//this allows you to move the cjax/ directory else where.
	//keep in mind that it need to remain accessibly through the url.
	define('AJAX_WD', dirname(__file__));
}

if(!defined('AJAX_FILE')) {
	//main ajax.php file name, should you rename it, enter new name here.
	define('AJAX_FILE', 'ajax.php');
}

/**
 * //@ajax_php;
 **/
class ajax  {
	
	function ajax($controller)
	{
		$ajax = ajax();
		
		$controller = $raw_class = preg_replace('/:.*/', '', $controller);
		$function = (isset($_REQUEST['function'])? $_REQUEST['function']: null);

		if($ajax->config->camelize) {
			$raw_class = $ajax->camelize($raw_class, $ajax->config->camelizeUcfirst);
		}
		$class_exists = false;
		$requestObject = null;
		$alt_controller = null;

		if(preg_match("/[^a-zA-Z0-9_]/", $controller)) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
			$this->abort("Invalid Controller: $controller");
		}
		if($function && preg_match("/[^a-zA-Z0-9_]/", $function)) {
			//if function is empty, it still passes.
			header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
			//header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
			$this->abort("Invalid Function: $function");
		}

		if(file_exists($f = CJAX_HOME.'/'.'includes.php')) {
			if(!defined('AJAX_INCLUDES')) {
				$ajax->includes = true;
				include_once $f;
			}
		}
		$args = $this->_params();
		
		if($controller=='_crossdomain') {
			return $this->_response(call_user_func_array(array($ajax, 'crossdomain'), $args));
		}

		if($plugin = $ajax->plugin($controller, true)) {
			if(method_exists($plugin, $function)) {
				return $this->_response(call_user_func_array(array($plugin, $function), $args));
			} else {

				if(is_dir($plugin->controllers_dir)) {

					$alt_controller = array(
						'class' => $plugin->controller,
						'dir' => $plugin->controllers_dir,
						'file' => $plugin->controllers_dir . '/' . $plugin->controller . '.php'
					);
					if (!file_exists($alt_controller['file'])) {
						$this->abort("{$controller} Plugin: Controller File Not Found.");
					}
				}
			}
		}

		$is_file = $this->_files($controller, $alt_controller);

		if($is_file) {
			$class_exists = $this->_class($controller);
			$requestObject = $this->_controller($class_exists, $controller, $function);
		}
		if(file_exists($f = CJAX_HOME.'/auth.php')) {
			require_once $f;
			if(class_exists('AjaxAuth')) {
				$auth = new AjaxAuth;
				if(!$auth->validate($controller, $function, $args, $requestObject)) {
					return $auth->authError();
				}
			} else {
				$this->abort("Class AjaxAuth was not found.");
			}
			if(method_exists($auth, 'intercept') && $_response = $auth->intercept($controller, $function , $args, $requestObject)) {
				if(is_array($_response) || is_object($_response)) {
					return $this->_response($_response);
				}
				return true;
			}
		}
		if(!$is_file) {
			header("Content-disposition:inline; filename='{$controller}.php'");
			header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
			header("Status: 404 Not Found");
			$this->abort("Controller File: $controller.php not found");
		}
		if(!$class_exists) {
			$this->abort("Controller Class \"{$raw_class}\" could not be found.");
		}
		if(!$function) {
			$function = $raw_class;
		}

		if(!method_exists($requestObject,$function)) {
			header("Content-disposition:inline; filename='{$controller}.php'");
			header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
			header("Status: 404 Not Found");
			$this->abort("Controller Method/Function: {$raw_class}::{$function}() was not found");
		}
		return $this->_response( call_user_func_array(array($requestObject, $function), $args) );
	}
	
	function abort($err)
	{
		ajax()->error($err, 10);
		exit(0);
	}

	protected function _response($response)
	{
		if($response && (is_array($response) || is_object($response))) {
			header('Content-type: application/json; charset=utf-8');
			print CoreEvents::json_encode($response);
		}		
	}
	
	protected function _files(&$controller, $alt_controller = null)
	{
		$ajax = ajax();
		if($alt_controller && is_array($alt_controller)) {
			$files[] = $alt_controller['file'];
			$controller = $alt_controller['class'];
		}
		if(defined('AJAX_CD')) {
			$ajax_cd = AJAX_CD;
		} else if(isset($_COOKIE['AJAX_CD']) && $_COOKIE['AJAX_CD']) {
			$ajax_cd = $_COOKIE['AJAX_CD'];
		}
		
		$files[] = "{$ajax_cd}/{$controller}.php";
		$files[] = "{$ajax->controller_dir}/{$ajax_cd}/{$controller}.php";
		$files[] = dirname(dirname(__file__))."/{$ajax_cd}/{$controller}.php";

		do {
			if(file_exists($f = $files[key($files)])) {
				require_once $f;
				return $f;
			}
		} while( next($files) );
	}

	protected function _class($controller)
	{
		$raw_controller = $controller;
		$ajax = ajax();

		$controller = $ajax->camelize($controller, $ajax->config->camelizeUcfirst);

		$_classes = array();
		$_classes[] = 'controller_'.$controller;
		$_classes[] = '_'.$controller;
		$_classes[] = $controller;
		$_classes[] = $raw_controller;

		do {
			$c = $_classes[key($_classes)];

			if(class_exists($c, false)) {
				return $c;
			}
		} while(next($_classes));


		return $c;
	}
	
	protected function _params()
	{
		$args = array();
		$arg_count = count(array_keys($_REQUEST)) - 3;
		foreach(range('a','z') as $k => $v) {
			if(isset($_REQUEST[$v])) {
				if(is_array($_REQUEST[$v])) {
					foreach($_REQUEST[$v] as $k2 => $v2) {
						if(is_array($_REQUEST[$v][$k2])) {
							$args[$v][$k2] = array_map('urldecode', $_REQUEST[$v][$k2]);
						} else {
							$args[$v][$k2] = urldecode($_REQUEST[$v][$k2]);
						}
					}
				} else {
					$args[$v] = urldecode($_REQUEST[$v]);
				}
			} else {
				$args[$v] = null;
			}
			if($k >= $arg_count) {
				break;
			}
		}
		if(function_exists('cleanInput')) {
			$args = cleanInput($args);
			$_REQUEST = cleanInput($_REQUEST,'_REQUEST');
			$_POST = cleanInput($_POST,'_POST');
			$_GET = cleanInput($_GET,'_GET');
		}
		
		$ajax = ajax();
		foreach($args as $k => $v) {
			if(is_array($v)) {
				$ajax->{$k} = new ext($v);
			} else {
				$ajax->{$k} = $v;
			}
		}
		return $args;
	}
	
	
	protected function _controller($class, $raw_controller, $function)
	{
		if(!$class) {
			return false;
		}

		if($class == $function && method_exists($class, $function)) {

			//prevent constructor
			$parent = get_parent_class($class);
			$_class = 'empty_'.$class;
			if($parent) {
				eval('class ' . $_class . ' extends ' . $class . '{ public function __construct() { parent::__construct(); } }');
			} else {
				eval('class ' . $_class . ' extends ' . $class . '{ public function __construct() {} }');
			}


			$obj = new $_class();
		} else {
			$obj = new $class;
		}
		return $obj;
	}
}
require_once (rtrim(AJAX_WD, '/') . '/core/preemptive.php');
$ajax = ajax();
$controller = $ajax->input('controller');
if($controller) {
	new ajax($controller);
}