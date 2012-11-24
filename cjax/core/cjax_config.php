<?php
//@app_header;

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
	spl_autoload_register(array('instanceFanctory','cjax_autoload')); // As of PHP 5.3.0
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
		$ajax = new CJAX_FRAMEWORK;
		
		if(!defined('JSON_FORCE_OBJECT')) {
			define ('JSON_FORCE_OBJECT', 16);
		}
		
		if(!isset($ajax->format) || !$ajax->format) {
			$ajax->format = new cjaxFormat();
			
			$_config = new ext;
			if(file_exists($f = CJAX_HOME.'/'.'config.php')) {
				include($f);
				if(isset($config)) {
					$_config = new ext($config);
				}
			}
			$ajax->config = $_config;
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
			if(@is_dir('cjax/')) {
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
				die("Cannot find the correct path to Js directory.");
			}
			
			$error = error_get_last();
			
			if($error &&  preg_match('%.*(open_basedir).*File\(([^\)]+)%', $error['message'], $match)) {
				die( sprintf('Restriction <b>open_basedir</b> is turned on. File or directory %s will not be accessible while this setting is on due to security directory range.', $match[2]) );
			}
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