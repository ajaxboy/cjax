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


$js_dir = null;

$base = pathinfo(__file__);
$base = $base['dirname'];
defined('CJAX_ROOT') or define('CJAX_ROOT', realpath($base."/../../"));
defined('AJAX_BASE') or define('AJAX_BASE', CJAX_ROOT.'/');
defined('CJAX_HOME') or define('CJAX_HOME', realpath($base."/../"));
defined('CJAX_CORE') or define('CJAX_CORE', CJAX_HOME.'/core');
require_once $base.'/classes/format.class.php';
require_once $base.'/classes/ext.class.php';
require_once $base.'/classes/plugin.class.php';
require_once $base.'/classes/cjax.class.php';
require_once $base.'/classes/std.class.php';
if(function_exists('spl_autoload_register')) {
	//spl_autoload_register(array('instanceFanctory','cjax_autoload')); // As of PHP 5.3.0
}
class CJAX extends CJAX_FRAMEWORK {

	private static $CJAX;
		
	/**
	* get an instance of CJAX
	* with singleton pattern 
	* @return CJAX_FRAMEWORK OBJECT
	*/
	public static function getInstance()
	{
		if(self::$CJAX) {
			return self::$CJAX;
		}

		CoreEvents::errorHandlingConfig();

		$ajax = new CJAX_FRAMEWORK;
		
		if(!defined('JSON_FORCE_OBJECT')) {
			define ('JSON_FORCE_OBJECT', 16);
		}
		
		if(!isset($ajax->format) || !$ajax->format) {
			$ajax->format = new cjaxFormat();
			
			$config = new ext;
			if(file_exists($f = CJAX_HOME.'/config.php')) {
				include($f);
				if(isset($config)) {
					$config = new ext($config);
				}
			}
			$ajax->config = $config;

			if(file_exists($f = CJAX_HOME.'/integration.php')) {
				include($f);
			}
			
			$ajax->initiate($ajax);
			if(!$ajax->isAjaxRequest()) {
				//$ajax->flushCache();
				if(defined('AJAX_CD')) {
					@setcookie ('AJAX_CD', AJAX_CD, null, '/');
				} else {
					//@setcookie ('AJAX_CD', null, time()-(3600*1000),'/');
				}
			} else {
				if(isset($_COOKIE['AJAX_CD']) && !defined('AJAX_CD')) {
					define('AJAX_CD', $_COOKIE['AJAX_CD']);
				}
				if(!function_exists('cleanInput')) {
					function cleanInput($input) {
						return $input;
					}
				}
			}
		}
		if($ajax->config->camelize===null) {
			if(version_compare($ajax->version, '>', '5.0-RC2')) {
				$ajax->config->camelize = true;
			}
		}
		if($ajax->config->ip_debug) {
			if(is_array($ajax->config->ip_debug)) {
				if(in_array(@$_SERVER['REMOTE_ADDR'], $ajax->config->ip_debug)) {
					$ajax->config->ip_debug = false;
				}
			} else {
				if(@$_SERVER['REMOTE_ADDR']!=$ajax->config->ip_debug) {
					$ajax->config->ip_debug = false;
				}
			}
		}
		
		if($ajax->config->caching) {
			if(isset($_SERVER['REQUEST_URI'])) {
				$ajax->crc32 = crc32($_SERVER['REQUEST_URI']);
				$cache = $ajax->readCache('cjax-'.$ajax->crc32);
				$ajax->caching = $cache;
			}
		}
		if($ajax->config->debug) {
			@ini_set('display_errors', 1);
			@ini_set('log_errors', 1);
		}
		
		if(!$js_dir = $ajax->config->js_path) {

			$script_name = explode('/', dirname($_SERVER['SCRIPT_FILENAME']));

			$count = 0;
			$slashes  = null;
			do  {
				$new = implode('/', $script_name);

				if(strpos(dirname(__FILE__), $new) !== false) {
					$core_dir = ltrim(str_replace($new, '', dirname(__FILE__)),'/');
					break;
				}
				$count ++;
			} while(array_pop($script_name));

			if($count) {
				$slashes  = str_repeat('../', $count);
			}

			if(is_dir($core_dir) || is_dir($slashes.$core_dir)) {
				$js_dir =  $slashes.$core_dir . '/js/';
			} else if(@is_dir('cjax/core')) {
				$js_dir  = "cjax/core/js/";
			} else if(@is_dir('core/js/')) {
				$js_dir  = "core/js/";
			} else if(@is_dir('../cjax')) {
				$js_dir  = "../cjax/core/js/";
			} else if(@is_dir('../../cjax')) {
				$js_dir  = "../../cjax/core/js/";
			} else if(@is_dir('../../../cjax')) {
				$js_dir  = "../../../cjax/core/js/";
			} else {
 				die(sprintf("Cannot find the correct path to Js directory(tried: {$slashes}{$core_dir})"));
			}
			
			$error = error_get_last();
			
			if($error &&  preg_match('%.*(open_basedir).*File\(([^\)]+)%', $error['message'], $match)) {
				die( sprintf('Restriction <b>open_basedir</b> is turned on. File or directory %s will not be accessible while this setting is on due to security directory range.', $match[2]) );
			}
			$ajax->config->js_path = $js_dir;
		}
		$ajax->js($js_dir);
		
		return self::$CJAX = $ajax;
	}
}

function ajax()
{
	return CJAX::getInstance();
}
$ajax = CJAX::getInstance();
$ajax->initiatePlugins();