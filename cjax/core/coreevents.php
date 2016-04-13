<?php
/** ################################################################################################**   
* Copyright (c)  2008  CJ.   
* Permission is granted to copy, distribute and/or modify this document   
* under the terms of the GNU Free Documentation License, Version 1.2   
* or any later version published by the Free Software Foundation;   
* Provided 'as is' with no warranties, nor shall the author be responsible for any misuse of the same.     
* A copy of the license is included in the section entitled 'GNU Free Documentation License'.   
*   
*   CJAX  6.0                $     
*   ajax made easy with cjax                    
*   -- DO NOT REMOVE THIS --                    
*   -- AUTHOR COPYRIGHT MUST REMAIN INTACT -   
*   Written by: CJ Galindo                  
*   Website: http://cjax.sourceforge.net                     $      
*   Email: cjxxi@msn.com    
*   Date: 2/12/2007                           $     
*   File Last Changed:  04/12/2016           $     
**####################################################################################################    */   
/**
 * Load external classes
 *@package CoreEvents
 * @param string $c
 */
namespace CJAX\Core;
use StdClass;
 
class CoreEvents extends Format{

	public $a,$b,$c,$d,$e,$f,$g,$h,$i, $j;
	
	public $config;

	//acts more strict in the kind of information you provive
	public $strict = false;

	public $messageId;
 
	public $trace = 0;
	
	private $xmlObjects;
	
	//helper to cache callbacks
	public static $callbacks = [];
	
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

	public $post = [];

	public $dir;

	public $attachEvent = true;
	
	public $log = false; //show internal debug info
	
	/**
	 * If a request variable is sent with 'session_id' name
	 * the framework will start session with that id.
	 * 
	 * In case ever need sessions
	 * @var string
	 */
	public $sessionId;

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
	public $controllerDir = '';

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
	private static $out = [];

	/**
	 * Check whether or not to call the shutdown function
	 *
	 * @var boolean $_is_shutdown_called
	 */
	private static $_isShutdownCalled = false;

	/**
	 * store cache procedure
	 *
	 * @var string $cache
	 */
	public static $cache = [];
	
	public $caching = false;
	
	public $crc32;
	
	/**
	 * 
	 * Hold cache set for to execute last. Use flag $ajax->flag('last'); to store commands.
	 * This makes it so that commands even if called first can be executed last.
	 * @var unknown_type
	 */
	public static $lastCache = [];

	/**
	 * hold cache for actions
	 *
	 * @var array
	 */
	public static $actions = [];
	
	
	/**
	 * number of commands passed last in Exec
	 */
	private static $_lastExecCount = 0;

	/**
	 * specified whether to use the cache system or normal mode
	 *
	 * @var boolean $use_cache
	 */
	static $useCache;

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
	public $version = '6.0';

	/**
	 * Tells whether CJAX output has initciated or not, to void duplications
	 *
	 * @var boolean $is_init
	 */
	public $isInit;
	
	public $_file;//full name of the cjax.js
	
	public $initExtra = [];

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
	protected static $flags = [];

	public static $const = [];
	
	//holds he latest flag
	public $_flag = null;

	public $_flagCount = 0;
	
	public function xmlItem($xml, $name){
		if(!is_integer($xml)){
			die("XML:{$name} ".print_r($xml,1)." is not an integer.");
		}
		$_xml = new XmlItem($this, $xml, $name);
        $this->xmlObjects = ($this->xmlObjects)? $this->xmlObjects: new StdClass;
		$this->xmlObjects->{$_xml->id} = $_xml;	
		return $_xml;
	}
	
	public function camelize($string, $ucfirst = true){
		$string = str_replace(['-', '_'], ' ', $string);
		$string = str_replace(' ', '', ucwords($string)); 
		return ($ucfirst)? ucfirst($string): lcfirst($string);
	}
	
	public function xmlObject($id = null){
        return (is_null($id))? null: $this->xmlObjects->$id;
	}
	
	public function xmlObjects($id = null){
        return (is_null($id))? $this->xmlObjects: $this->xmlObjects->$id;
	}
	
	public function flushCache($all = false){
		if(!isset($_SESSION)){
			@session_start();
		}
		if($all){
			$_SESSION['cjax_x_cache'] = '';
			@setcookie('cjax_x_cache','');
		}
		$_SESSION['cjax_preload'] = '';
		$_SESSION['cjax_debug'] = '';
		@setcookie('cjax_preload','');
		@setcookie('cjax_debug','');
	}
	
	public function flushRawCache(){
		self::$cache = [];
		self::$actions = [];
		self::$lastCache = [];
	}
	
	public function callbacks($cache, $test = false){
		if(self::$callbacks){
			foreach(self::$callbacks as $k => $v){
                $cb = $this->processScache($v);
				if(!isset($cache[$k])){
					$v[$k]['callback'] = $this->mkArray($cb,'json', true);
				} 
                else{
                    $cache[$k]['callback'] = ($test)? $cb: $this->mkArray($cb,'json', true);
				}
			}
		}
		return $cache;
	}
	
	public function out(){
		if(!self::$cache && !self::$actions){
			return;
		}
		$cache = self::$cache;
		if(!self::$cache){
			$cache = self::$actions;
			if(self::$lastCache){
				$cache = array_merge($cache,self::$lastCache);
			}
		} 
        else{
			if(self::$actions){
				$cache = array_merge($cache,self::$actions);
			}
			if(self::$lastCache){
				$cache = array_merge($cache,self::$lastCache);
			}
		}
		
		$cache = $this->callbacks($cache);		
		$_preload = null;
		foreach($cache as $k => $v){
			if($v['do']=='_import' || $v['do']=='_imports' || isset($v['is_plugin'])) {
				$_preload[$k] = $v;
				if(!isset($v['is_plugin'])){
					unset($cache[$k]);
				}
			}
		}
		if($_preload){
			$_preload = $this->mkArray($this->processScache($_preload));
		}
		
		$_cache = $this->mkArray($this->processScache($cache));
				
		$out  = "<xml class='cjax'>{$_cache}</xml><xml class='cjax'><preload>{$_preload}</preload></xml>";
		if(self::$wrapper){
			$out = str_replace('(!xml!)', $out, self::$wrapper);
		}
		return $out;
	}
	
	public function commit(){
		if(!self::$cache && !self::$actions){
			return;
		}
		if(!self::$cache){
			self::$cache = self::$actions;
			if(self::$lastCache){
				self::$cache = array_merge(self::$cache,self::$lastCache);
			}
		} 
        else{
			if(self::$actions){
				self::$cache = array_merge(self::$cache,self::$actions);
			}
			if(self::$lastCache){
				self::$cache = array_merge(self::$lastCache, self::$cache);
			}
		}
        
		$ajax = CJAX::getInstance();		
		self::$cache = $this->callbacks(self::$cache);
		$_preload = [];
		foreach(self::$cache as $k => $v){
			if($v['do']=='_import' || $v['do']=='_imports' || isset($v['is_plugin'])) {
				$_preload[$k] = $v;
				if(!isset($v['is_plugin'])){
					unset(self::$cache[$k]);
				}
			}
		}
        $_preload = ($_preload)? $this->mkArray($this->processScache($_preload)): null;   
		$_cache = $this->mkArray($this->processScache(self::$cache));		
		if($ajax->config->debug){
			$ajax->debug = true;
		}
		$debug = ($ajax->debug)? 1 : 0;		
		$out = 'CJAX.process_all("'.$_cache.'","'.$_preload.'", '.$debug.', true);';		
		return $out;
	}
	
	public function simpleCommit($return = false){
		$ajax = CJAX::getInstance();
		if($ajax->fallback || $ajax->config->fallback || $ajax->caching) {
			return true;
		}
		$cache = self::$cache;
		if(!$cache){
			$cache = self::$actions;
			if(self::$lastCache) {
				$cache = array_merge($cache,self::$lastCache);
			}
		} 
        else{
			if(self::$actions){
				$cache = array_merge(self::$cache,self::$actions);
			}
			if(self::$lastCache){
				$cache = array_merge(self::$lastCache, $cache);
			}
		}
		
		$cache = $this->callbacks($cache);
		
		$_preload = [];
		foreach($cache as $k => $v){
			if(isset($v['do']) && ($v['do']=='_import' || $v['do']=='_imports' || isset($v['is_plugin']))) {
				$_preload[$k] = $v;
				if(!isset($v['is_plugin'])){
					unset($cache[$k]);
				}
			}
		}
		if($_preload){
			$_preload = $this->mkArray($this->processScache($_preload));
		}		
		$_cache = $this->mkArray($this->processScache($cache));		
		if($ajax->config->debug){
			$ajax->debug = true;
		}
		$debug = ($ajax->debug)? 1 : 0;
	
		if($_preload){
			$this->save('cjax_preload', $_preload);
		}
		$this->save('cjax_x_cache', $_cache);
		if($debug){
			$this->save('cjax_debug', $debug);
		}
		self::$simpleCommit = $cache;
		return $_cache;
	}
	
	/**
	 * Saves the cache
	 *
	 * @return string
	 */
	public static function saveSCache(){
		$ajax = CJAX::getInstance();
		if($ajax->log && self::$cache){
			die("Debug Info:<pre>".print_r(self::$cache,1)."</pre>");
		}
		
        $coreEvents = new self;	
		if($coreEvents->isAjaxRequest()){			
			print $coreEvents->out();
			return;
		}  
        else{			
			$out = $coreEvents->commit();
			
			if($ajax->config->caching){
				if(is_array($ajax->caching) && crc32('caching=1;'.$out)!= key($ajax->caching)){
					$coreEvents->write([$ajax->crc32 => 'caching=1;'.$out], 'cjax-'.$ajax->crc32);
				} 
                elseif(!$ajax->caching){
					$coreEvents->write([$ajax->crc32 => 'caching=1;'.$out], 'cjax-'.$ajax->crc32);
				}
			} 
            else{
				if($ajax->fallback || $ajax->config->fallback){					
					$data = $coreEvents->fallbackPrint($out);			
					print "\n<script>$data\n</script>";
				}
			}
		}
	}
	
	public function _processScachePlugin($v,$caller = null){
		if($v['data'] && is_array($v['data'])){
			$v['data'] =  $this->mkArray($v['data']);
		}
		if(isset($v['extra'])){
			$v['extra'] =  $this->mkArray($v['extra']);
		}
		if(isset($v['onwait'])){
			$v['onwait'] = $this->processScache($v['onwait']);
		}
		if(isset($v['callback'])){
			$v['callback'] = $this->mkArray($v['callback']);
		}	
		
		return $v;
	}
	
	public function _processScacheAddEventTo($event){
		$keep = ['event_element_id','xml','do','event','waitFor','uniqid'];
		foreach($event['events'] as $k => $v){
			$v['event_element_id'] = $event['element_id'];
			foreach($v as $k2 => $v2){
				if(is_array($v2)){
					foreach($v2 as $k3 => $v3){
						if(is_array($v3)){
							$v2[$k3] = $this->mkArray($v3);
						}
					}
					$v[$k2] = $this->mkArray($v2);
				}
			}
			$v['xml'] = $this->xmlIt($v);
			foreach($v as $_k => $_v){
				if(in_array($_k , $keep)){
					continue;
				}
				unset($v[$_k]);
			}
			$event['events'][$k] = $v;
		}
		
		$event['events'] = $this->mkArray($event['events']);
		return $event;
	}
	
	public function processScache($_cache){
		foreach($_cache as $k => $v){
			$v['uniqid'] = $k;
			if(isset($v['do']) && $v['do']=='AddEventTo'){
				$v = $this->_processScacheAddEventTo($v);
			}
			
			if(isset($v['is_plugin'])){
				$v = $this->_processScachePlugin($v);
			}
			
			foreach($v  as $k2 => $v2){
				if(is_array($v2)){
					$v2 = $this->mkArray($v2);
					$v[$k2] =  "<$k2>$v2</$k2>";
					
				} 
                else{
					$v[$k2] =  "<$k2>$v2</$k2>";
				}
			}
			$_cache[$k] = "<cjax>".implode($v)."</cjax>";
		}
		return $_cache;
	}
	
	public function lastEntryId(){
		$count = 0;
		if(self::$cache){
			end(self::$cache);
			$count = key(self::$cache);
			reset(self::$cache);
		}		
		return $count;
	}
	
	public function lastId(){
		return $this->lastEntryId();
	}
	
	/**
	 * 
	 * Tells if plugin exists or not
	 * regardless of it having a class or not
	 * 
	 * @param unknown_type $pluginName
	 */
	public function isPlugin($pluginName){
        $plugin = new Plugin;
		return $plugin->isPlugin($pluginName);
	}
	
	public function UpdateCache($instanceId, $data){
		self::$cache[$instanceId] = $data;
		$this->simpleCommit();
	}
	
	/**
	 * 
	 * gets plugin only if it has a class
	 */
	public function plugin($pluginName, $loadController = false){
		if($this->isPlugin($pluginName) && $plugin = Plugin::getPluginInstance($pluginName, null, null, $loadController)){
			return $plugin;
		}
	}
	
	public function initiatePlugins(){
		return Plugin::initiatePlugins();
	}
	
	/**
	 * 
	 * sets flag 
	 */
	public function first(){
		$this->flag('first');
	}
	
	/**
	 * xml outputer, allows the interaction with xml
	 *
	 * @param xml $xml
     * @param string $apiName
	 * @return string
	 */
	public function xml($xml, $apiName  = null){
		$ajax = CJAX::getInstance();
		if(isset($xml['do'])){
			$this->lastCmd = $xml['do'];
		}
		if($ajax->_flag){			
			if(is_array($ajax->_flag)){
				$xml['flag'] = $this->xmlIt($ajax->_flag);
				$ajax->_flag = null;
			} 
            elseif($ajax->_flag == 'first'){
				$this->setLastCache($xml);
				$ajax->_flag = null;
				return;
			}
		}
		
		$this->cache($xml);		
		if(!$this->isAjaxRequest()){
			$this->simpleCommit();
		}
		$count = $this->lastEntryId();		
		return $count;
	}
	
	public function cacheWrapper($wrapper = []){
		if(is_array($wrapper)){
			self::$wrapper = implode('(!xml!)',$wrapper);
		}		
	}
	
	public function fallbackPrint($out){
		$ajax = CJAX::getInstance();
		$path = $ajax->_path;				
		$data = "init = function() {
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

	public function getCache(){
		return self::$cache;
	}

	/**
	 * Used for loading "fly" events
	 *
	 * @param string $add
	 */
	public function cache($add=null, $cacheId = null){
		if(!self::$_isShutdownCalled) {
			register_shutdown_function(['CJAX\\Core\\CoreEvents','saveSCache']);
			self::$_isShutdownCalled = true;
			self::$useCache = true;		
		}
		
		if($cacheId){
			if($cacheId=='actions'){
				self::$actions[] = $add;
			} 
            else{
				self::$cache[$cacheId] = $add;
			}
		} 
        else{
			self::$cache[] = $add;
		}
		if($add == null){
			return self::$cache;
		}
	}
	
	public function template($templateName){
		return file_get_contents(CJAX_HOME."/assets/templates/{$templateName}");		
	}
	
	public function jsonEncode($array){
		return json_encode($array, JSON_FORCE_OBJECT);
	}
	
	public function mkArray($array, $tag = 'json', $double = false){
		$json = $this->encode($this->jsonEncode($array));		
        $json = ($double)? $this->encode($json): $json;	
		return "<{$tag}>{$json}</{$tag}>";
	}

	/**
	 * Setting up the directory where the CJAX FRAMEWORK resides
	 *
	 * @param string $jsdir
	 */
	public function js($jsdir, $force = false){
		if($force){
			self::$path = $jsdir;
			return $this->jsdir = false;
		}
		if(!$this->jsdir && $this->jsdir !== false){
			self::$path = $jsdir;
			$this->jsdir = $jsdir;
		}
	}

	/**
	 * Outputs our FRAMEWORK to the browser
	 * @param unknown-type $jsPath
	 * @return unknown
	 */
	public function headRef($jsPath = null, $min = false){
		$ajax = CJAX::getInstance();
		$file = "cjax-6.0.js";
		if($min) {
			$file = $this->_file;
		}
		if(is_string($min) && !is_bool($min)){
            $jsPath = ($file)? rtrim($min,'/').'/cjax/assets/js/': rtrim($min,'/'); 
		} 
        else{
			if($ajax->config->initUrl && preg_match("/https?/", $ajax->config->initUrl)) {
				$jsPath = rtrim($ajax->config->initUrl,'/').'/cjax/assets/js/';
			}
		}
		if($ajax->crc32){
			$file .= "?crc32={$ajax->crc32}";
		}
		
		if($this->config->sizzle){
			$script[] = "<script type='text/javascript' src='{$jsPath}sizzle.min.js'></script>\n";
		}
		
		if($ajax->initExtra){
			$pluginPath = str_replace('/assets/js','/plugins',$jsPath);
			foreach($ajax->initExtra as $k => $v) {
                $script[] = (isset($v['plugin_dir']))? "\t<script type='text/javascript' src='".$pluginPath.$v['plugin_dir'].'/'.$v['file']."'></script>\n"
                                                     : "\t<script type='text/javascript' src='".$v['file']."'></script>\n";
			}
		}
		if($this->jsdir){
            $path = ($file)? $jsPath.$file: $jsPath;
			$ajax->_path = $path;
			$script[] = "<script defer='defer' id='cjax_lib' type='text/javascript' src='{$path}'></script>\n";
		} 
        elseif(self::$path){
			if(self::$path[strlen(self::$path)-1] =='/') {
				self::$path = substr(self::$path,0,strlen(self::$path) -1);
			}
			$ajax->_path = ($this->_file)? self::$path: self::$path."/assets/js/";
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
	public function init($min = true){
        $this->_file = ($min && substr($min, 0, 2)=='..')
                        ? (strpos($min,'.js') !== false) ? null: "cjax-6.0.min.js"
                        : "cjax-6.0.min.js";
		$this->isInit = $href = $this->headRef($this->jsdir, $min);
		return $href;
	}

	public function curl($url, $postData = []){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_URL, 'http://sourceforge.net');
		curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS
		if($postData && is_array($postData)){
			curl_setopt($ch,CURLOPT_POST, count($postData));
			curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($postData));
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
		curl_setopt ($ch, CURLOPT_TIMEOUT, 3);
		$data = curl_exec($ch);
		$err = curl_errno($ch);
		curl_close($ch);
		return ($err)? $this->fsockopen($url): $data;
	}
	
	public function remote($url){
		$content = @file_get_contents($url);		
		if($content !== false){			
			return $content;
		}
        return (function_exists('curl_init'))? $this->curl($url): $this->fsockopen($url);
	}
	
	public function fsockopen($url, $errno = null, $errstr = null){
		if(!function_exists('fsockopen')){
			die('You  need cURL or fsockopen enabled to connect to a remote server.');
		}
		
		$info = parse_url($url);
		$host = $info['host'];
		$file = $info['path'];
		$fp = @fsockopen($host,80,$errno,$errstr);
		@stream_set_timeout($fp, 20);
		if(!$fp){
			die('Could not connect to remote server: '. $errstr);
		}
		if($errstr){
			die('Error:#'.$errno.' '.$errstr);
		}

		$base = "/";			
	    @fputs($fp, "GET {$base}{$file} HTTP/1.1\r\n");
	    @fputs($fp, "HOST: {$host}\r\n");
	    @fputs($fp, "Connection: close\r\n\r\n");
		$getInfo = false;
		$data= [];
        
		while(!feof($fp)){
			if($getInfo){
				$data[] = fread($fp, 1024);
			} 
            elseif(fgets($fp, 1024) == "\r\n"){
				$getInfo = true;
			}
		}
		fclose($fp);		
		return implode($data);
	}
	
	public function readCache($crc32 = null){
        $filename = ($crc32)? $crc32: 'cjax.txt';
        $dir = ($this->config->caching)? sys_get_temp_dir(): CJAX_HOME.'/assets/cache/';
 		$dir = rtrim($dir, '/').'/';
 		$file = $dir.$filename;
 		if(is_file($file)){
 			if(getlastmod($file) > time() + 3600) {
 				return;//1 hour to regenerate
 			}
	 		$content = file_get_contents($file);
	 		if($content){
	 			$content = unserialize($content);
	 		}
	 		return $content;
 		}
	}
	
	public function tapCache($crc32){
		$cache = $this->readCache('cjax-'.$crc32);
		return ($cache)? $cache[$crc32]: null;
	}
	
	/**
	 * write to a file in file system, used as an alrernative to for cache
	 *
	 * @param string $content
	 * @param string $filename
	 */
 	public function write($content, $filename = null){
 		if(!$filename){
	 		$filename = 'cjax.txt';
 		}
 		$ajax = CJAX::getInstance();
 		if($ajax->config->caching && !is_writable($dir=sys_get_temp_dir())){
 			$dir = CJAX_HOME.'/assets/cache/';
 		}
 		if(is_array($content)){
 			$content = serialize($content);
 		}
 		$dir = rtrim($dir, '/').'/';
 		$file = $dir.$filename;
 		if(file_exists($file) && !is_writable($file) && !chmod($filename, 0666)){
 			echo "CJAX: Error! file ($file) is not writable, Not enough permission";
 			exit;
 		}
 		if(!$fp = @fopen($file, 'w')){
 			echo "CJAX: Error! file ($file) is not writable, Not enough permission";
 			exit;
 		}
 		if(fwrite($fp, $content) === FALSE){
 			echo "Cannot write to file ($file)";
 			exit;
 		}
 		if(!fclose($fp)){
 			echo "Cannot close file ($file)";
 			exit;
 		}
 	}
 	
	/**
	 * 
	 * perform cross domain  requests
	 * @param unknown_type $url
	 */
	public function crossdomain($url){
		$response = $this->remote($url);
		if(!$response || strpos(strtolower($response),'not found') !== false){
			return;
		}
		print $response;
	}

	/**
	 * Helper to generate flags quicker.
	 * @param $flag_id
	 * @param $command_count
	 */
	public function flag($flagId, $commandCount = 1 ,$settings = []){
		switch($flagId){
			case 'wait':					
				$settings['command_count'] = $commandCount;		
				$this->_flag = $settings;
				$this->_flagcount = $commandCount;
				break;
			case 'first':
			case 'last':
			case 'no_wait':
				$this->_flag = 'first';
				break;
			default:
				if(CJAX::getInstance()->strict){
					die("Invalid Flag Argument Prodivided");
				}
		}
	}
	
	/**
	 * 
	 * tell whether this is an ajax request or not.
	 */
	public function isAjaxRequest(){
		$request = $this->input('ajax');
		if($request){
			return true;
		}
		$request = $this->input('cjax_iframe');
		if($request){
			return true;
		}
		$headers = [];
		if(function_exists('apache_request_headers')){
			$headers = apache_request_headers();
			if(!isset($headers['X-Requested-With'])){
                $headers['X-Requested-With'] = (isset($_SERVER['HTTP_X_REQUESTED_WITH']))?
                                                $_SERVER['HTTP_X_REQUESTED_WITH'] : null;
			}
		} 
        elseif(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			$headers['X-Requested-With'] = $_SERVER['HTTP_X_REQUESTED_WITH'];
		}
		
		if(!empty($headers) && ($headers['X-Requested-With'] == 'CJAX FRAMEW0RK 6.0' || $headers['X-Requested-With'] == 'XMLHttpRequest')){
		    return true;
		}
		//allow access to flash
		if(isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] == 'Shockwave Flash'){
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
	public function request($callback = null, &$params = null){
	 	$r = $this->isAjaxRequest();
	 	if($r && $callback){
	 		if(is_array($callback)){
	 			if(substr($callback[0],0,4)=='self'){
	 				$arr = debug_backtrace(false);
		 			$trace = $arr[1];
		 			$class = $trace['class'];
	 				$callback[0] =$class;
	 			}
	 			if(!$params) $params = [];
	 			$r = call_user_func_array($callback, $params);
	 		} 
            else{
	 			$r = call_user_func($callback);
	 		}
	 		exit;
	 	}
        return ($this->isAjaxRequest())? true: false;
	 }

	public function setRequest($request = true){
        $_GET['cjax'] = ($request)? time(): '';
        $_REQUEST['cjax'] = ($request)? time(): '';
	}

	/**
	 * Encode special data to void conflicts with javascript
	 *
	 * @param string $data
	 * @return encoded string
	 */
	public function encode($data){
		return urlencode(str_replace('+', '[plus]', $data));		
	}

	/**
	 * Converts an array into xml..
	 */
	public function xmlIt($input = [], $tag = null){
		$new = [];
		if(is_array($input) && $input){
            $new = $this->xmlInput($tag, $input);
			return $xml = implode($new);
		}
	}
    
    private function xmlInput($tag, $input){
        $new = [];
        foreach($input as $k => $v){
            if($v){
                if($tag){
                    $k = $tag;
                }
                if(is_array($v)){
                    foreach($v as $k2 => $v2){
                        $new[] =  $this->xmlIt($v2);
                    }
                } 
                else{
                    $new[] =  "<$k>$v</$k>";
                }
            }
        }
        return $new;    
    }

	public function save($setting, $value = null, $useCookie = false){
		$ajax = CJAX::getInstance();
		if(!isset($_SESSION)){
			@session_start();
		}
		if($ajax->fallback || $ajax->config->fallback){
			if($value===null && isset($_SESSION[$setting])){
				unset($_SESSION[$setting]);
				$this->cookie($setting);
			} 
            else{
				$_SESSION[$setting] = $value;
				$this->cookie($setting, $value);
			}
		} 
        elseif(!$useCookie){
			if($value === null && isset($_SESSION[$setting])){
				unset($_SESSION[$setting]);
			} 
            else{
				$_SESSION[$setting] = $value;
			}
		} 
        else{
		    $this->cookie($setting, $value);
        }
	}
	
	public function cookie($setting, $value = null){
        ($value === null)? @setcookie($setting, $value, time()-(3600*1000), '/')
                         : @setcookie($setting, $value, null, '/');
	}

	public function getSetting($setting){
		return $this->get($setting);
	}
	
	public function setLastCache($add = null, $cacheId = null){
		if($cacheId){
			self::$lastCache[$cacheId] = $add;
		} 
        else{
			array_push(self::$lastCache,$add);
		}
	}

	/**
	 * 
	 * remove cache
	 * @param mixed $cacheId
	 */
	public function removeExecCache($cacheId){
		if(is_array($cacheId)){
			foreach($cacheId as $k){
				unset(self::$cache[$k]);
			}
		} 
        elseif(isset(self::$cache[$cacheId])){
			unset(self::$cache[$cacheId]);
		}
		$this->simpleCommit();
	}
	
	/**
	 * 
	 * remove cache
	 * @param int $count
	 */
	public function removeLastCache($count){
		do{
			$count--;
			end(self::$cache);
			unset(self::$cache[key(self::$cache)]);			
		}while($count);
	}
	
	/**
	 * 
	 * remove cache
	 * @param mixed $cacheId
	 */
	public function removeCache($cacheId){
		unset(self::$cache[$cacheId]);
	}

	public function warning($msg = "Invalid Input", $seconds = 4){
		$ajax = CJAX::getInstance();
		return $ajax->message($ajax->format->message($msg, Format::CSS_WARNING),$seconds);
	}

	public function success($msg = "Success!", $seconds = 3){
		$ajax = CJAX::getInstance();
		return $ajax->message($ajax->format->message($msg, Format::CSS_SUCCESS));
	}

	/*
	 * Show loading indicator
	 */
	public function loading($msg = "Loading..."){
		$ajax = CJAX::getInstance();
		return $ajax->message($ajax->format->message($msg, Format::CSS_SUCCESS));
	}

	public function process($msg = "Processing...", $seconds = 3){
		$ajax = CJAX::getInstance();
		return $ajax->message($ajax->format->message($msg, Format::CSS_PROCESS), $seconds);
	}

	public function info($msg = null, $seconds = 3){
		$ajax = CJAX::getInstance();
		return $ajax->message($ajax->format->message($msg, Format::CSS_INFO),$seconds);
	}

	public function error($msg = "Error!", $seconds = 15){
		$ajax = CJAX::getInstance();
		return $ajax->message($ajax->format->message($msg, Format::CSS_ERROR), $seconds);
	}
	
	public function _lastExecCount($count = 0){
		if($count){
			self::$_lastExecCount = $count;
		}
		return self::$_lastExecCount;
	}

	/**
	 * Yet to implement
	 *
	 * @param string $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param string $errline
	 * @return string
	 */
	public function CJAXErrorHandler($errno, $errstr, $errfile, $errline){
		switch($errno){
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

	public function CJAXExceptionHandler(){

	}

	public function clearCache(){
		//$old_err = set_error_handler(['self', 'CJAXErrorHandler']);
		if(!isset($_SESSION)){
			@session_start();
		}
		unset($_SESSION['cjax_x_cache']);
			
		if(!headers_sent()){
			@setcookie('cjax_x_cache','');
		}
	}
	
	public function initiate($ajax){
		if(isset($_REQUEST['session_id'])){
			session_id($_REQUEST['session_id']);
			@session_start();
		} 
        elseif(!$ajax->config->fallback && !isset($_SESSION)){
		    @session_start();
		}
	}

	/**
	 * Optional text, replaces the "loading.." text when an ajax call is placed
	 *
	 * @param unknown_type $ms
	 */
	public function text($ms = ''){
		$this->text = $ms;
	}

	/**
	 * CJAX is bein called from within a child directory then you will need to specify
	 * the url where CJAX is located (eg. http://yoursite.com/cjax)
	 *
	 * @param string $path [CJAX URL]
	 */
	public function path($path){
		self::$path = $path;
	}

	public static function remotePath(){
		return 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER["SCRIPT_NAME"]).'/cjax';
	}

	public static function getFile($file = null){
		return self::connect($_SERVER['HTTP_HOST'],(isset($_SERVER['SERVER_PORT'])? $_SERVER['SERVER_PORT']:80), $file, true);
	}

	public static function connect($file = null, $port = 80, $local = false){
		$ajax = CJAX::getInstance();

		if(!$port){
			$port = $ajax->port;
			if(!$port){
				$port = 80;
			}
		}
		if(!function_exists('fsockopen')){
			die('no fsockopen: be sure that php function fsockopen is enabled.');
		}
		
		
		$fp = @fsockopen($host, $port, $errno, $errstr);
		if(!$fp){
			return false;
		}
		if($errstr){
			die('error:'.$errstr);
		}
        
		$base = "/";
        @fputs($fp, "GET {$base}{$file} HTTP/1.1\r\n");
        @fputs($fp, "HOST: {$host}\r\n");
		@fputs($fp, "Connection: close\r\n\r\n");
		$getInfo = false;
		$data = [];
		while(!feof($fp)){
			if($getInfo){
				$data[] = fread($fp, 1024);
			} 
            elseif(fgets($fp, 1024) == "\r\n"){
				$getInfo = true;
			} 
		}
		fclose($fp);
		return implode($data);
	}
	
	public function input($value = 'cjax'){
		$v = isset($_REQUEST[$value])? $_REQUEST[$value] : (isset($_GET[$value])? $_GET[$value]: null);		
		if(!$v && isset($_COOKIE[$value]) && $_COOKIE[$value]){
			$v = $_COOKIE[$value];
		}
        
		if(is_array($v)){
			foreach($v as $k => $kv){
                $return[$k] = (is_array($kv))? $kv: addslashes($kv);
			}
			return $return;
		}
		return addslashes($v);		
	}

	/*
	 * Get session or cookie value
	 */
	public function get($setting, $getAsObject = false){
		$value = null;
		if(isset($_SESSION[$setting])){
			$value = $_SESSION[$setting];
		} 
        elseif(isset($_COOKIE[$setting])){
			$value = $_COOKIE[$setting];
		}
        
		if(is_array($value) && $getAsObject){
			$value = new Ext($value);
		} 
        elseif($getAsObject){
			$value = new Ext;
		}
		return $value;
	}
	
	public function code($data, $tags = true){	
		@ini_set('highlight.string', "#DD0000"); // Set each colour for each part of the syntax
		@ini_set('highlight.comment', "#FF8000"); // Suppression has to happen as some hosts deny access to ini_set and there is no way of detecting this
		@ini_set('highlight.keyword', "#007700");
		@ini_set('highlight.default', "#0000BB");
		@ini_set('highlight.html', "#0000BB");
			
		$data = str_replace("\n\n", "\n", $data);	
		$data = ($tags)? highlight_string("<?php \n" . $data . "\n?>", true)
                       : highlight_string($data, true); 		
		return '<div id="code_highlighted">'.$data."</div>";
	}
	
	public function jsCode($data, $tags = false, $output = null){ 		
		@ini_set('highlight.string', "#DD0000"); // Set each colour for each part of the syntax
		@ini_set('highlight.comment', "#FF8000"); // Suppression has to happen as some hosts deny access to ini_set and there is no way of detecting this
		@ini_set('highlight.keyword', "green");
		@ini_set('highlight.default', "#0000BB");
		@ini_set('highlight.html', "#0000BB");

		$data =  "<script>". highlight_string("\n" . $data ."\n"); 		
        return ($tags)? str_replace(['?php', '?&gt;'], ['script type="text/javascript">', '&lt;/script&gt;'], $output)
                      : str_replace(['&lt;?php', '?&gt;'], ['', ''], $data);
	}
	
	public static function errorHandlingConfig(){
		/**Error Handling**/
		@ini_set('display_errors', 1);
		@ini_set('log_errors', 1);
		$level = ini_get('error_reporting');
		if($level > 30719 || $level == 2048){
			@ini_set('error_reporting', $level-E_STRICT);
			$_level = ini_get('error_reporting');
			if($_level > 30719 || $_level ==2048){
				die("Cjax requirements not met. Strict Stardards must be turned off in your php.ini.");
			} 
            else{
				$level = $_level;
			}
		}
		return $level;
	}
}