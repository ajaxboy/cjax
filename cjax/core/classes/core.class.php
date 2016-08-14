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

/**
 * Load external classes
 *@package CoreEvents
 * @param string $c
 */
class CoreEvents extends cjaxFormat {
	public $a,$b,$c,$d,$e,$f,$g,$h,$i, $j;

	public $config;
	//acts more strict in the kind of information you provive
	public $strict = false;

	public $message_id;

	public $trace = 0;

	private $xmlObjects;

	//helper to cache callbacks
	public static $callbacks = array();

	private static $simpleCommit;

	private static $wrapper;

	public $lastCmd;

	//is using includes.php?
	public $includes = false;

	/**
	 *
	 * For js functions
	 * @var unknown_type
	 */
	public $selector;

	/**
	 *
	 * Force the sytem to adapt to a loading or not loading state.
	 * @var unknown_type
	 */
	public $loading = false;

	/**
	 *
	 * Some hosts have issues with sessions so lets fallback on cookies
	 * @var unknown_type
	 */
	public $fallback = false;

	private static $_loading;

	public $post = array();

	public $dir;

	public $attach_event = true;

	public $log = false; //show internal debug info

	/**
	 * If a request variable is sent with 'session_id' name
	 * the framework will start session with that id.
	 *
	 * In case ever need sessions
	 * @var string
	 */
	public $session_id;

	/**
	 * default port when connecting to web pages
	 *
	 * @var unknown_type
	 */
	public $port = 80;

	/**
	 * if controllers are located in a sub directory
	 *
	 * @var string
	 */
	public $controller_dir = '';

	/*
	 * hold an object with some formattig helpers
	 * not meant to be added to the package but it was added at some point
	 * @return cjaxFormat
	 */
	public $format;

	/**
	 * Where the data is stored before the output
	 *
	 * @var unknown_type
	 */
	private static $out = array();

	/**
	 * Check whether or not to call the shutdown function
	 *
	 * @var boolean $_is_shutdown_called
	 */
	private static $_is_shutdown_called = false;

	/**
	 * store cache procedure
	 *
	 * @var string $cache
	 */
	public static $cache = array();

	public $caching = false;

	public $crc32;

	/**
	 *
	 * Hold cache set for to execute last. Use flag $ajax->flag('last'); to store commands.
	 * This makes it so that commands even if called first can be executed last.
	 * @var unknown_type
	 */
	public static $lastCache = array();

	/**
	 * hold cache for actions
	 *
	 * @var array
	 */
	public static $actions = array();


	/**
	 * number of commands passed last in Exec
	 */
	private static $_lastExecCount = 0;

	/**
	 * specified whether to use the cache system or normal mode
	 *
	 * @var boolean $use_cache
	 */
	static $use_cache;

	//new alias to replace $JSevent.
	public $event = "onClick";

	/**
	 * Set the text to show when the page is loading
	 * this replaces the "loading.."
	 *
	 *
	 * @var mixed $text
	 */
	public $text = null;

	/*
	 * The the CJAX console on debug mode
	 */
	public $debug;

	/**
	 * Get the current version of CJAX FRAMEWORK you are using
	 *
	 * @var string
	 */
	public $version;


	/**
	 * Tells whether CJAX output has initciated or not, to void duplications
	 *
	 * @var boolean $is_init
	 */
	public $is_init;

	public $_file;//full name of the cjax.js

	public $init_extra = array();

	/**
	 * Sets the default way of making AJAX calls, it can be either get or post
	 */
	public $method;
	/**
	 * Stores the the waiting procedure for the next action
	 */
	private static $wait;

	/**
	 * Path where JavaScript Library is located
	 *
	 * @var string
	 */
	public static $path;

	/**
	 *
	 * @var unknown_type
	 */
	public $_path;

	/**
	 * Path where JavaScript Library is located
	 *
	 * @var string
	 */
	private $jsdir = null;

	public $caller;

	/*
	 * sets up the default loading image
	 */

	protected static $flags = array();


	public static $const = array();

	//holds he latest flag
	public $_flag = null;
	public $_flag_count = 0;

	function xmlItem($xml, $name)
	{
		if(!is_integer($xml)) {
			die("XML:$name ".print_r($xml,1)." is not an integer.");
		}
		$_xml = new xmlItem($xml, $name);

		if(!$this->xmlObjects) {
			$this->xmlObjects = new stdClass();
		}

		$this->xmlObjects->{$_xml->id} = $_xml;

		return $_xml;
	}

	function camelize($string, $ucfirst = true)
	{
		$string = str_replace(array('-', '_'), ' ', $string);
		$string = ucwords($string);
		$string = str_replace(' ', '', $string);

		if ($ucfirst) {
			return ucfirst($string);
		} else {
			return lcfirst($string);
		}
	}

	public function xmlObject($id = null)
	{
		if(!is_null($id)) {
			//if(isset($this->xmlObjects->$id)) {
			return $this->xmlObjects->$id;
			//}
		}
	}

	public function xmlObjects($id = null)
	{
		if(!is_null($id)) {
			return $this->xmlObjects->$id;
		}
		return $this->xmlObjects;
	}


	function flushCache($all = false)
	{
		if(!isset($_SESSION)) {
			@session_start();
		}
		if($all) {
			$_SESSION['cjax_x_cache'] = '';
			@setcookie('cjax_x_cache','');
		}
		$_SESSION['cjax_preload'] = '';
		$_SESSION['cjax_debug'] = '';
		@setcookie('cjax_preload','');
		@setcookie('cjax_debug','');
	}

	function flushRawCache()
	{
		CoreEvents::$cache = array();
		CoreEvents::$actions = array();
		CoreEvents::$lastCache = array();
	}

	static function callbacks($cache, $test = false)
	{
		if(CoreEvents::$callbacks) {
			foreach(CoreEvents::$callbacks as $k => $v) {
				if(!$test) {
					$cb = CoreEvents::processScache($v);
				} else {
					$cb = CoreEvents::processScache($v);
				}
				if(!isset($cache[$k])) {
					$v[$k]['callback'] = CoreEvents::mkArray($cb,'json', true);
				} else {
					if(!$test) {
						$cache[$k]['callback'] = CoreEvents::mkArray($cb,'json', true);
					} else {
						$cache[$k]['callback'] = $cb;
					}
				}
			}
		}
		return $cache;
	}

	static function prepareCommit()
	{
		$cache = self::$cache;
		if(!$cache) {
			$cache = self::$actions;
			if(self::$lastCache) {
				$cache = array_merge($cache,self::$lastCache);
			}
		} else {
			if(self::$actions) {
				$cache = array_merge(self::$cache,self::$actions);
			}
			if(self::$lastCache) {
				$cache = array_merge(self::$lastCache, $cache);
			}
		}

		$cache = self::callbacks($cache);

		$_preload = array();
		foreach($cache as $k => $v) {
			if($v['do']=='_import' || $v['do']=='_imports' || isset($v['is_plugin'])) {
				$_preload[$k] = $v;
				if(!isset($v['is_plugin'])) {
					unset($cache[$k]);
				}
			}
			if($v['do'] == 'AddEventTo') {
				$events = $v['events'];
				foreach($events as $k2 => $v2) {
					if(isset($v2['is_plugin'])) {
						$_preload[$k2] = $v2;
						//unset($cache[$k]);
					}
				}
			}
		}
		if($_preload) {
			$_preload = self::processScache($_preload);
			$_preload = self::mkArray($_preload);
		}

		$_cache = self::processScache($cache);

		$_cache = self::mkArray($_cache);


		return array($_cache,$_preload);
	}

	function out()
	{
		$data = self::prepareCommit();


		$out  = "<xml class='cjax'>".$data[0]."</xml><xml class='cjax'><preload>{$data[1]}</preload></xml>";
		if(self::$wrapper) {
			$out = str_replace('(!xml!)', $out, self::$wrapper);
		}
		return $out;
	}

	function simpleCommit($return = false)
	{
		$ajax = ajax();
		if($ajax->fallback || $ajax->config->fallback || $ajax->caching) {
			return true;
		}
		$data = self::prepareCommit();

		if($ajax->config->debug) {
			$ajax->debug = true;
		}
		$debug =  ($ajax->debug? 1 : 0);

		if($data[1]) {
			self::save('cjax_preload', $data[1]);
		}
		self::save('cjax_x_cache', $data[0]);
		if($debug) {
			self::save('cjax_debug', $debug);
		}
		self::$simpleCommit = $data[0];
		return $data[0];
	}


	/**
	 * Saves the cache
	 *
	 * @return string
	 */
	public static function saveSCache()
	{
		$ajax = ajax();

		if($ajax->log) {
			if(self::$cache){
				die("Debug Info:<pre>".print_r(self::$cache,1)."</pre>");
			}
		}

		if($ajax->isAjaxRequest()) {

			print self::out();
			return;
		}  else {


			$out = self::simpleCommit();

			if($ajax->config->caching) {
				if(is_array($ajax->caching) && crc32('caching=1;'.$out)!= key($ajax->caching)) {
					self::write(array($ajax->crc32 => 'caching=1;'.$out),'cjax-'.$ajax->crc32);
				} else if(!$ajax->caching) {
					self::write(array($ajax->crc32 => 'caching=1;'.$out),'cjax-'.$ajax->crc32);
				}
			} else {
				if($ajax->fallback || $ajax->config->fallback) {

					$data = self::fallbackPrint($out);

					print "\n<script>$data\n</script>";
				}
			}
		}
	}

	function _processScachePlugin($v,$caller = null)
	{
		if(isset($v['options']) && is_array($v['options'])) {
			$v['options'] =  self::mkArray($v['options']);
		}
		if(isset($v['extra'])) {
			$v['extra'] =  self::mkArray($v['extra']);
		}
		if(isset($v['onwait'])) {
			$v['onwait'] = self::processScache($v['onwait']);
		}
		if(isset($v['callback'])) {
			$v['callback'] = self::mkArray($v['callback']);
		}

		return $v;
	}

	function _processScacheAddEventTo($event)
	{
		$keep = array('event_element_id','xml','do','event','waitFor','uniqid');
		foreach($event['events'] as $k => $v) {
			$v['event_element_id'] = $event['element_id'];
			foreach($v as $k2 => $v2) {
				if(is_array($v2)) {
					foreach($v2 as $k3 => $v3) {
						if(is_array($v3)) {
							$v2[$k3] = self::mkArray($v3);
						}
					}
					$v[$k2] = self::mkArray($v2);
				}
			}
			$v['xml'] = self::xmlIt($v);
			foreach($v as $_k => $_v) {
				if(in_array($_k , $keep)) {
					continue;
				}
				unset($v[$_k]);
			}
			$event['events'][$k] = $v;
		}

		$event['events'] = self::mkArray($event['events']);
		return $event;
	}

	static function processScache($_cache)
	{
		foreach($_cache as $k => $v) {
			$v['uniqid'] = $k;
			if(isset($v['do']) && $v['do']=='AddEventTo') {
				$v = self::_processScacheAddEventTo($v);
			}

			if(isset($v['is_plugin'])) {
				$v = self::_processScachePlugin($v);
			}

			foreach($v  as $k2 => $v2) {
				if(is_array($v2)) {
					$v2 = self::mkArray($v2);
					$v[$k2] =  "<$k2>$v2</$k2>";

				} else {
					$v[$k2] =  "<$k2>$v2</$k2>";
				}
			}
			$_cache[$k] = "<cjax>".implode($v)."</cjax>";
		}
		return $_cache;
	}

	function lastEntryId()
	{
		$count = 0;
		if(self::$cache) {
			end(self::$cache);
			$count = key(self::$cache);
			reset(self::$cache);
		}

		return $count;
	}

	function lastId()
	{
		return self::lastEntryId();
	}

	/**
	 *
	 * Tells if plugin exists or not
	 * regardless of it having a class or not
	 *
	 * @param unknown_type $plugin_name
	 */
	function isPlugin($plugin_name)
	{
		return plugin::isPlugin($plugin_name);
	}

	function UpdateCache($instance_id, $data)
	{
		self::$cache[$instance_id] = $data;
		CoreEvents::simpleCommit();
	}

	/**
	 *
	 * gets plugin only if it has a class
	 */
	public function plugin($plugin_name, $load_controller = false)
	{
		if($this->isPlugin($plugin_name)) {
			if($plugin = plugin::getPluginInstance($plugin_name, null, null, $load_controller)) {
				return $plugin;
			}
		}
	}

	function initiatePlugins()
	{
		return plugin::initiatePlugins();
	}

	/**
	 *
	 * sets flag
	 */
	function first()
	{
		$this->flag('first');
	}

	/**
	 * xml outputer, allows the interaction with xml
	 *
	 * @param xml $xml
	 * @return string
	 */
	function xml($xml, $api_name  = null)
	{
		$ajax = ajax();
		if(isset($xml['do'])) {
			$this->lastCmd = $xml['do'];
		}
		if($ajax->_flag) {

			if(is_array($ajax->_flag)) {
				$xml['flag'] = self::xmlIt($ajax->_flag);
				$ajax->_flag = null;
			} else {
				if($ajax->_flag=='first') {
					self::setLastCache($xml);
					$ajax->_flag = null;
					return;
				}
			}
		}

		self::cache($xml);

		if(!$ajax->isAjaxRequest()) {
			self::simpleCommit();
		}
		$count = self::lastEntryId();

		return $count;
	}


	function cacheWrapper($wrapper = array())
	{
		if(!is_array($wrapper)) {
			return;
		}
		self::$wrapper = implode('(!xml!)',$wrapper);
	}

	function fallbackPrint($out)
	{
		$ajax = ajax();
		$path = $ajax->_path;

		$data = "
init = function() {
	if (arguments.callee.done) return;
	arguments.callee.done = true;
	_cjax = function() {
		$out
	}
	window['DOMContentLoaded'] = true;
	if(typeof CJAX != 'undefined') {
		_cjax();
	} else {
		window['_CJAX_PROCESS'] = function() {
			_cjax();
		}
	}
}
if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', init, false);
} else {
	/* for Internet Explorer */
	/*@cc_on @*/
	/*@if (@_win32)
	 document.write('<script defer src=\"{$path}cjax.js.php?json=1\"><'+'/script>');
	/*@end @*/
	window.onload = init;
}";
		return $data;
	}

	function getCache()
	{
		return  CoreEvents::$cache;
	}
	/**
	 * Used for loading "fly" events
	 *
	 * @param string $add
	 */
	function cache($add=null,$cache_id = null)
	{
		if(!self::$_is_shutdown_called) {
			$bol = register_shutdown_function(array('CoreEvents','saveSCache'));
			self::$_is_shutdown_called = true;
			self::$use_cache = true;
			if(!headers_sent()) {
				//flush();
			}

		}
		$ajax = ajax();
		if($cache_id) {
			if($cache_id=='actions') {
				self::$actions[] = $add;
			} else {
				self::$cache[$cache_id] = $add;
			}
		} else {
			self::$cache[] = $add;
		}

		if($add==null){
			return self::$cache;
		}
	}

	public function template($template_name) {
		$template = file_get_contents(CJAX_CORE."/templates/$template_name");

		return $template;
	}

	static function json_encode($array)
	{
		if(version_compare('5.3', phpversion(),'>')) {
			return json_encode($array);
		}
		return json_encode($array,JSON_FORCE_OBJECT);
	}

	public static function mkArray($array, $tag = 'json', $double = false)
	{
		$json = ajax()->encode(self::json_encode($array));

		if($double) {
			$json = ajax()->encode($json);
		}

		return "<$tag>".$json."</$tag>";
	}

	/**
	 * Setting up the directory where the CJAX FRAMEWORK resides
	 *
	 * @param string $jsdir
	 */
	function js($jsdir,$force=false)
	{
		if($force) {
			self::$path = $jsdir;
			return $this->jsdir = false;
		}
		if(!$this->jsdir && $this->jsdir !==false) {
			self::$path = $jsdir;
			$this->jsdir = $jsdir;
		}
	}

	/**
	 * Outputs our FRAMEWORK to the browser
	 * @param unknown_type $js_path
	 * @return unknown
	 */
	function head_ref($js_path = null, $min = false)
	{
		$ajax = ajax();
		$file = "cjax.js";
		if($min) {
			$file = $this->_file;
		}
		if(is_string($min) && !is_bool($min)) {
			if($file) {
				$js_path =  rtrim($min,'/').'/cjax/core/js/';
			} else {
				$js_path =  rtrim($min,'/');
			}
		} else {
			if($ajax->config->init_url && preg_match("/https?/", $ajax->config->init_url)) {
				$js_path =  rtrim($ajax->config->init_url,'/').'/cjax/core/js/';
			}
		}
		if($ajax->crc32) {
			$file .= "?crc32={$ajax->crc32}";
		}

		if($this->config->sizzle) {
			$lib_path = str_replace('/core/js','/lib',$js_path);
			$script[] = "<script type='text/javascript' src='{$lib_path}sizzle.js'></script>\n";
		}

		if($ajax->init_extra) {
			$plugin_path = str_replace('/core/js','/plugins',$js_path);
			//die($plugin_path);
			foreach($ajax->init_extra as $k => $v) {
				if(isset($v['plugin_dir'])) {
					$script[] = "\t<script type='text/javascript' src='".$plugin_path.$v['plugin_dir'].'/'.$v['file']."'></script>\n";
				} else {
					$script[] = "\t<script type='text/javascript' src='".$v['file']."'></script>\n";
				}
			}
		}
		if($this->jsdir) {
			if(!$file) {
				$path = $js_path;
			} else {
				$path = $js_path.$file;
			}
			$ajax->_path = $path;
			$script[] = "<script defer='defer' id='cjax_lib' type='text/javascript' src='$path'></script>\n";
		} else if(self::$path) {
			if(self::$path[strlen(self::$path)-1] =='/') {
				self::$path = substr(self::$path,0,strlen(self::$path) -1);
			}

			if(!$this->_file) {
				$ajax->_path = self::$path."/core/js/";
			} else {
				$ajax->_path = self::$path;
			}
			$script[] = "<script id='cjax_lib' type='text/javascript' src='".$ajax->_path.$file."'></script>\n";
		}
		return implode($script);
	}

	/**
	 * initciates the process of sending the javascript file to the application
	 *
	 * @param optional boolean $min - get the minimized version of javascript
	 * @return string
	 */
	public function init($min = true)
	{
		if($min) {
			$this->_file = "cjax.min.js";
		}

		$href = $this->head_ref($this->jsdir, $min);
		$this->is_init = $href;

		//plugin::trigger('onInit');
		return $href;
	}

	function curl($url, $post_data = array())
	{
		$ajax = CJAX::getInstance();

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_URL, 'http://sourceforge.net');
		curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS
		if($post_data && is_array($post_data)){
			curl_setopt($ch,CURLOPT_POST, count($post_data));
			curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($post_data));
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
		curl_setopt ($ch, CURLOPT_TIMEOUT, 3);
		$data = curl_exec($ch);
		$err = curl_errno($ch);
		curl_close($ch);

		if($err) {
			return self::fsockopen($url);
		}
		return $data;
	}

	function remote($url)
	{
		$content = @file_get_contents($url);

		if($content !== false) {

			return $content;
		}
		if(function_exists('curl_init')) {
			return self::curl($url);
		} else {
			return self::fsockopen($url);
		}
	}

	function fsockopen($url)
	{
		if(!function_exists('fsockopen')) {
			die('You  need cURL or fsockopen enabled to connect to a remote server.');
		}

		$info = parse_url($url);

		$host = $info['host'];
		$file = $info['path'];
		$fp = @fsockopen($host,80,$errno,$errstr);
		@stream_set_timeout($fp, 20);
		if(!$fp) {
			die('Could not connect to remote server: '. $errstr);
			return false;
		}
		if($errstr) {
			die('Error:#'.$errno.' '.$errstr);
		}

		if($fp) {
			$base = "/";

			@fputs($fp, "GET $base$file HTTP/1.1\r\n");
			@fputs($fp, "HOST: $host\r\n");
			@fputs($fp, "Connection: close\r\n\r\n");

		} else {
			return false;
		}
		$get_info = false;
		$data= array();
		while (!feof($fp)) {
			if ($get_info) {
				$data[] = fread($fp, 1024);
			} else {
				if (fgets($fp, 1024) == "\r\n") {
					$get_info = true;
				}
			}
		}
		fclose ( $fp );

		return implode($data);
	}

	function readCache($crc32 = null)
	{
		if(!$crc32) {
			$filename = 'cjax.txt';
		} else {
			$filename = $crc32;
		}
		if($this->config->caching) {
			$dir = sys_get_temp_dir();
		} else {
			$dir = CJAX_HOME.'/core/cache/';
		}
		$dir = rtrim($dir, '/').'/';
		$file = $dir.$filename;
		if(is_file($file)) {
			if(getlastmod($file) > time() + 3600) {
				return;//1 hour to regenerate
			}
			$content = file_get_contents($file);
			if($content) {
				$content = unserialize($content);
			}
			return $content;
		}
	}

	function tapCache($crc32)
	{
		$cache = self::readCache('cjax-'.$crc32);
		if($cache) {
			return $cache[$crc32];
		}
	}

	/**
	 * write to a file in file system, used as an alrernative to for cache
	 *
	 * @param string $content
	 * @param string $flag
	 */
	function write($content, $filename = null)
	{
		if(!$filename) {
			$filename = 'cjax.txt';
		}
		$ajax = ajax();
		if($ajax->config->caching && !is_writable($dir=sys_get_temp_dir())) {
			$dir = CJAX_HOME.'/core/cache/';
		}
		if(is_array($content)) {
			$content = serialize($content);
		}
		$dir = rtrim($dir, '/').'/';
		$file = $dir.$filename;
		if (file_exists($file)) {
			if (!is_writable($file)) {
				if (!chmod($filename, 0666)) {
					echo "CJAX: Error! file ($file) is not writable, Not enough permission";
					exit;
				};
			}
		}
		if (!$fp = @fopen($file, 'w')) {
			echo "CJAX: Error! file ($file) is not writable, Not enough permission";
			exit;
		}
		if (fwrite($fp, $content) === FALSE) {
			echo "Cannot write to file ($file)";
			exit;
		}
		if (!fclose($fp)) {
			echo "Cannot close file ($file)";
			exit;
		}
	}

	/**
	 *
	 * perform cross domain  requests
	 * @param unknown_type $url
	 */
	function crossdomain($url)
	{
		$response = $this->remote($url);

		if(!$response || strpos(strtolower($response),'not found')!==false) {
			return;
		}
		print $response;
	}

	/**
	 * Helper to generate flags quicker.
	 * @param $flag_id
	 * @param $command_count
	 */
	function flag($flag_id,$command_count = 1 , $settings = array())
	{
		$flags = array();

		switch($flag_id) {
			case 'wait':

				$settings['command_count'] = $command_count;

				$this->_flag = $settings;
				$this->_flag_count = $command_count;
				break;
			case 'first':
			case 'last':
				$this->_flag = 'first';

				break;
			case 'no_wait':
				$this->_flag = 'first';
				break;
			default:

				if(CJAX::getInstance()->strict) {
					die("Invalid Flag Argument Prodivided");
				}
		}
	}

	/**
	 *
	 * tell whether this is an ajax request or not.
	 */
	function isAjaxRequest()
	{
		$request = self::input('ajax');
		if($request) {
			return true;
		}
		$request = self::input('cjax_iframe');
		if($request) {
			return true;
		}
		$headers = array();
		if(function_exists('apache_request_headers')) {
			$headers = apache_request_headers();
			if(!isset($headers['X-Requested-With'])) {
				if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
					$headers['X-Requested-With'] = $_SERVER['HTTP_X_REQUESTED_WITH'];
				} else {
					$headers['X-Requested-With'] = null;
				}
			}
		} else {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
				$headers['X-Requested-With'] = $_SERVER['HTTP_X_REQUESTED_WITH'];
			}
		}

		if(!empty($headers)) {
			if($headers['X-Requested-With']=='CJAX FRAMEW0RK' || $headers['X-Requested-With']=='XMLHttpRequest') {
				return true;
			}
		}
		//allow access to flash
		if(isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT']=='Shockwave Flash') {
			return true;
		}
	}

	/**
	 *  Tell whether or not the a ajax request has been placed
	 *
	 * Sunday August 3 2008 added functionality:
	 *
	 * @return boolean
	 */
	function request($callback = null, &$params = null)
	{
		$ajax = ajax();
		$r = $ajax->isAjaxRequest();
		if($r && $callback) {
			if(is_array($callback) ) {
				if(substr($callback[0],0,4)=='self') {
					$arr = debug_backtrace(false);
					$trace = $arr[1];
					$class = $trace['class'];
					$class = $class;
					$callback[0] =$class;
				}
				if(!$params) $params = array();
				$r = call_user_func_array($callback,$params);
			} else {
				$r = call_user_func($callback);
			}
			exit();
		}
		if(!$ajax->isAjaxRequest()) {
			return false;
		}
		return true;
	}

	function setRequest($request = true)
	{
		if($request) {
			$_GET['cjax'] = time();
			$_REQUEST['cjax'] = time();
		} else {
			$_GET['cjax'] = '';
			$_REQUEST['cjax'] = '';
		}
	}


	/**
	 * Encode special data to void conflicts with javascript
	 *
	 * @param string $data
	 * @return encoded string
	 */
	public function encode($data)
	{
		$data = str_replace('+','[plus]', $data);
		$data = urlencode($data);

		return $data;
	}

	/**
	 * Converts an array into xml..
	 */
	function xmlIt($input = array(), $tag = null)
	{
		$new = array();
		if(is_array($input) && $input) {
			foreach ($input as $k =>$v) {
				if($v) {
					if($tag) {
						$k = $tag;
					}
					if(is_array($v)) {
						foreach($v as $k2 => $v2){
							$new[] =  self::xmlIt($v2);
						}
					} else {
						$new[] =  "<$k>$v</$k>";
					}
				}
			}
			return $xml = implode($new);
		}
	}


	function save($setting, $value = null, $use_cookie = false)
	{
		$ajax = ajax();
		if(!isset($_SESSION)) {
			@session_start();
		}
		if($ajax->fallback || $ajax->config->fallback) {
			if($value===null) {
				if(isset($_SESSION[$setting])) {
					unset($_SESSION[$setting]);
					self::cookie($setting);
				}
			} else {
				$_SESSION[$setting] = $value;
				self::cookie($setting, $value);
			}
		} else {
			if(!$use_cookie) {
				if($value===null) {
					if(isset($_SESSION[$setting])) {
						unset($_SESSION[$setting]);
					}
				} else {
					$_SESSION[$setting] = $value;
				}
			} else {
				self::cookie($setting, $value);
			}
		}
	}

	function cookie($setting, $value = null)
	{
		if($value===null) {
			@setcookie ($setting, $value, time()-(3600*1000), '/');
		} else {
			@setcookie ($setting, $value, null, '/');
		}
	}

	function getSetting($setting)
	{
		return $this->get($setting);
	}

	function setLastCache($add=null,$cache_id = null)
	{
		if($cache_id) {
			self::$lastCache[$cache_id] = $add;
		} else {
			array_push(self::$lastCache,$add);
		}
	}

	/**
	 *
	 * remove cache
	 * @param mixed $cache_id
	 */
	function removeExecCache($cache_id)
	{
		if(is_array($cache_id)) {
			foreach($cache_id as $k) {
				unset(self::$cache[$k]);
			}
		} else if(isset(self::$cache[$cache_id])) {
			unset(self::$cache[$cache_id]);
		}
		self::simpleCommit();
	}

	/**
	 *
	 * remove cache
	 * @param mixed $cache_id
	 */
	function removeLastCache($count)
	{
		do {
			$count--;
			end(self::$cache);
			unset(self::$cache[key(self::$cache)]);

		} while($count);
	}

	/**
	 *
	 * remove cache
	 * @param mixed $cache_id
	 */
	function removeCache($cache_id)
	{
		unset(self::$cache[$cache_id]);
	}

	public function warning($msg=null,$seconds=4)
	{
		$ajax = CJAX::getInstance();
		if(!$msg) {
			$msg = "Invalid Input";
		}
		return $ajax->message($ajax->format->message($msg,cjaxFormat::CSS_WARNING),$seconds);
	}

	public function success($msg=null,$seconds=3)
	{
		$ajax = CJAX::getInstance();
		if(!$msg) {
			$msg = "Success!";
		}
		return $ajax->message($ajax->format->message($msg,cjaxFormat::CSS_SUCCESS));
	}

	/*
	 * Show loading indicator
	 */
	public  function loading($msg = null)
	{
		$ajax = CJAX::getInstance();
		if(!$msg) {
			$msg = "Loading...";
		}
		return $ajax->message($ajax->format->message($msg,cjaxFormat::CSS_SUCCESS));
	}

	public function process($msg=null,$seconds=3)
	{
		$ajax = CJAX::getInstance();
		if(!$msg) {
			$msg = "Processing...";
		}
		return $ajax->message($ajax->format->message($msg,cjaxFormat::CSS_PROCESS),$seconds);
	}

	public function info($msg=null,$seconds=3)
	{
		$ajax = CJAX::getInstance();
		return $ajax->message($ajax->format->message($msg,cjaxFormat::CSS_INFO),$seconds);
	}

	public function error($msg=null,$seconds=15)
	{
		$ajax = CJAX::getInstance();
		if(!$msg) {
			$msg = "Error!";
		}
		return $ajax->message($ajax->format->message($msg,cjaxFormat::CSS_ERROR),$seconds);
	}


	function _lastExecCount($count = 0)
	{
		if($count) {
			self::$_lastExecCount = $count;
		}
		return self::$_lastExecCount;
	}

	// error handler function
	/**
	 * Yet to implement
	 *
	 * @param string $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param string $errline
	 * @return string
	 */
	function CJAXErrorHandler($errno, $errstr, $errfile, $errline)
	{
		switch ($errno) {
			case E_USER_ERROR:
				echo "<b>CJAX:</b> [$errno] $errstr<br />\n";
				echo "  Fatal error on line $errline in file $errfile";
				echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
				echo "Aborting...<br />\n";
				exit(1);
				break;

			case E_USER_WARNING:
				echo "<b>Cjax WARNING</b> [$errno] $errstr<br />\n";
				break;
			case E_USER_NOTICE:
				echo "<b>Cjax NOTICE</b> [$errno] $errstr<br />\n";
				break;
			default:
				echo "Unknown error type: [$errno] $errstr<br />\n";
				break;
		}

		/* Don't execute PHP internal error handler */
		return true;
	}

	function CJAXExceptionHandler()
	{

	}

	function clearCache()
	{
		//$old_err = set_error_handler(array('self','CJAXErrorHandler'));
		GLOBAL $_SESSION;
		if(!isset($_SESSION)) {
			@session_start();
		}
		unset($_SESSION['cjax_x_cache']);

		if (!headers_sent()) {
			@setcookie('cjax_x_cache','');
		}
	}

	function initiate($ajax)
	{
		if(isset($_REQUEST['session_id'])) {
			$session_id = $_REQUEST['session_id'];
			session_id($session_id);
			@session_start();
		} else {
			if(!$ajax->config->fallback) {
				if(!isset($_SESSION)) {
					@session_start();
				}
			}
		}
	}

	/**
	 * Optional text, replaces the "loading.." text when an ajax call is placed
	 *
	 * @param unknown_type $ms
	 */
	function text($ms = false)
	{
		$this->text = $ms;
	}

	/**
	 * CJAX is bein called from within a child directory then you will need to specify
	 * the url where CJAX is located (eg. http://yoursite.com/cjax)
	 *
	 * @param string $Path [CJAX URL]
	 */
	function path($path)
	{
		self::$path = $path;
	}

	public static function remotePath()
	{
		$host = $_SERVER['HTTP_HOST'];
		$sname = dirname($_SERVER["SCRIPT_NAME"]);
		return 'http://'.$host.$sname.'/cjax';
	}

	public static function getFile($file=null)
	{
		return self::connect($_SERVER['HTTP_HOST'],(isset($_SERVER['SERVER_PORT'])? $_SERVER['SERVER_PORT']:80),$file,true);
	}

	public static function connect($file=null,$port = 80,$local = false)
	{
		$ajax = CJAX::getInstance();

		if(!$port) {
			$port = $ajax->port;
			if(!$port) {
				$port = 80;
			}
		}
		if(!function_exists('fsockopen')) {
			die('no fsockopen: be sure that php function fsockopen is enabled.');
		}


		$fp = @fsockopen($host,$port,$errno,$errstr);
		if(!$fp) {
			return false;
		}
		if($errstr) {
			die('error:'.$errstr);
		}

		if($fp) {
			$base = "/";
			@fputs($fp, "GET $base$file HTTP/1.1\r\n");
			@fputs($fp, "HOST: $host\r\n");
			@fputs($fp, "Connection: close\r\n\r\n");
		} else {
			return false;
		}
		$get_info = false;
		$data = array();
		while (!feof($fp)) {
			if ($get_info) {
				$data[] = fread($fp, 1024);
			} else {
				if (fgets($fp, 1024) == "\r\n") {
					$get_info = true;
				} else {
					//break;
				}
			}
		}
		fclose ( $fp );
		return implode($data);
	}

	function input($value=null)
	{
		if($value===null) $value= 'cjax';
		$v = isset($_REQUEST[$value])? $_REQUEST[$value] : (isset($_GET[$value])? $_GET[$value]:null);

		if(!$v && isset($_COOKIE[$value]) && $_COOKIE[$value]) {
			$v = $_COOKIE[$value];
		}
		if(is_array($v)) {
			foreach($v as $k => $kv ) {
				if(!is_array($kv)) {
					$return[$k] =  addslashes($kv);
				} else {
					foreach($kv as $k_level => $v_level2) {
						$return[$k][$k_level] = $v_level2;
					}
				}
			}
			return $return;
		}
		return addslashes($v);
	}

	/*
	 * Get session or cookie value
	 */
	function get($setting, $get_as_object = false)
	{
		$value = null;
		if(isset($_SESSION[$setting])) {
			$value = $_SESSION[$setting];
		} else if(isset($_COOKIE[$setting])) {
			$value = $_COOKIE[$setting];
		}
		if(is_array($value) && $get_as_object) {
			$value = new ext($value);
		} else if($get_as_object) {
			$value = new ext;
		}
		return $value;
	}

	function code($data, $tags = true, $extra = null)
	{
		$flush_on_closing_brace = true;
		$c_string = "#DD0000";
		$c_comment = "#FF8000";
		$c_keyword = "#007700";
		$c_default = "#0000BB";
		$c_html = "#0000BB";

		@ini_set('highlight.string', $c_string); // Set each colour for each part of the syntax
		@ini_set('highlight.comment', $c_comment); // Suppression has to happen as some hosts deny access to ini_set and there is no way of detecting this
		@ini_set('highlight.keyword', $c_keyword);
		@ini_set('highlight.default', $c_default);
		@ini_set('highlight.html', $c_html);


		//$data = str_replace(array(') { ', ' }', ";", "\r\n"), array(") {\n", "\n}", ";\n", "\n"), $data); // Newlinefy all braces and change Windows linebreaks to Linux (much nicer!)

		$data = str_replace("\n\n", "\n", $data);

		//$data = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $data); // Regex identifies all extra empty lines produced by the str_replace above. It is quicker to do it like this than deal with a more complicated regular expression above.


		if (is_bool($tags)) {
			if (!$tags) {
				$data = highlight_string($data, true);; // Add nice and friendly <script> tags around highlighted text
			} else {
				$data = highlight_string("<?php \n" . $data . "\n?>", true);
			}
		} else {
			$data = highlight_string($data, true);; // Add nice and friendly <script> tags around highlighted text
		}

		if (is_bool($extra) && $extra) {
			$extra = "<div class='try_it'><img src='resources/images/try_it.png' /></div><h4>Try it</h4>";
		}

		return sprintf('<div id="code_highlighted">%s%s</div>', $data, $extra);
	}

	function jsCode($data, $tags = false)
	{
		$c_string = "#DD0000";
		$c_comment = "#FF8000";
		$c_keyword = "green";
		$c_default = "#0000BB";
		$c_html = "#0000BB";


		@ini_set('highlight.string', $c_string); // Set each colour for each part of the syntax
		@ini_set('highlight.comment', $c_comment); // Suppression has to happen as some hosts deny access to ini_set and there is no way of detecting this
		@ini_set('highlight.keyword', $c_keyword);
		@ini_set('highlight.default', $c_default);
		@ini_set('highlight.html', $c_html);

		//$data = str_replace(array(') { ', ' }', ";", "\r\n"), array(") {\n", "\n}", ";\n", "\n"), $data); // Newlinefy all braces and change Windows linebreaks to Linux (much nicer!)
		//$data = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $data); // Regex identifies all extra empty lines produced by the str_replace above. It is quicker to do it like this than deal with a more complicated regular expression above.
		$data =  "<script>". highlight_string("\n" . $data ."\n") . "</script>";

		//$data = explode("\n", str_replace(array("<br />"), array("\n"),$data));

		if($tags) {
			$data = str_replace(array('?php', '?&gt;'), array('script type="text/javascript">', '&lt;/script&gt;'), $output); // Add nice and friendly <script> tags around highlighted text
		} else {
			$data = str_replace(array('&lt;?php', '?&gt;'), array('', ''), $data); // Add nice and friendly <script> tags around highlighted text

		}
		return $data;
	}

	static function errorHandlingConfig()
	{
		/**Error Handling**/
		@ini_set('display_errors', 1);
		@ini_set('log_errors', 1);
		$level = ini_get('error_reporting');
		if($level > 30719 || $level ==2048) {
			@ini_set('error_reporting', $level-E_STRICT);
			$_level = ini_get('error_reporting');
			if($_level > 30719 || $_level ==2048) {
				die("Cjax requirements not met. Strict Stardards must be turned off in your php.ini.");
			} else {
				$level = $_level;
			}
		}
		return $level;
	}
}