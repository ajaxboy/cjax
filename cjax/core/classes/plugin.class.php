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


$core_dir = dirname(dirname(__file__));
require_once $core_dir.'/cjax_config.php';

class plugin extends ext {

	/**
	 *
	 * instancedd  to the plugin class
	 * @var unknown_type
	 */
	private static $instance;

	public $xml;//xmlItem Object

	/**
	 *  Instances to plugins
	 */
	private static $_instances = array();
	/**
	 *
	 * entries Ids from plugns
	 * @var unknown_type
	 */
	private static $_instances_ids = array();

	/**
	 *
	 * Plugin has a class
	 * @var unknown_type
	 */
	private static $_instances_exist = array();
	/**
	 * Plugins parameters
	 */
	private static $_instances_params = array();
	/**
	 * Default controllers directory to each plugin
	 */
	public $controllers_dir = 'response';

	public $controller;

	public $controller_file = null;

	/**
	 * A executable string before the plugin is ran.
	 * @var unknown_type
	 */
	public $init = "function(){}";

	/**
	 *
	 * Plugins that are aborted
	 * @var unknown_type
	 */
	private static $_aborted = array();

	/**
	 *
	 * When needing  $loading in the contructor
	 * @var unknown_type
	 */
	private static $_loading_prefix = null;
	public $dir;
	public static $initiatePlugins = array();
	public $loading;
	/**
	 *
	 * Plugins settings
	 *
	 * @var unknown_type
	 */
	public $ajaxFile = false; //if true the it  will replace any string that start with ajax.php to a full url.

	/**
	 *
	 * javascript file name,
	 * by default is the plugin's name but can be different.
	 * @var unknown_type
	 */
	public $file = null;

	/**
	 *
	 * Plugin arguments
	 * @var unknown_type
	 */
	public $params;

	/**
	 *
	 * class pertaining to an addon
	 * @var unknown_type
	 */
	public $class;

	/**
	 *
	 * If using Exec event, store the element_id.
	 * @var unknown_type
	 */
	public $element_id;

	/**
	 *
	 * If a  plugin is used more than once on the page, assigns an id
	 * in wished to do modifications in later execution
	 * @var integer
	 */
	public $_id;
	public $id;
	private static $_dirs = array();
	private static $_initiated;
	private static $readDir = array();

	/**
	 *
	 * For session variables use cookie?
	 * if false it will use sessions.
	 *
	 * @var boolean
	 */
	private $cookie = false;

	public function __construct()
	{
		$this->loading = get_class($this);
	}

	/**
	 *
	 * Delete plugin entries
	 */
	function abort($plugin_name = null)
	{
		if(!$plugin_name) {
			$plugin_name = $this->loading;
		}
		if(self::$_instances_ids) {
			if(isset(self::$_instances_ids[$plugin_name])) {
				$entries = self::$_instances_ids[$plugin_name];
				foreach($entries as $v) {
					self::DeleteEntry($v);
				}
			}
		}
		self::$_aborted[$plugin_name] = true;
	}

	/*
     * can preload the plugin file if plugin is not being fired.
     */
	function preload()
	{
		$file = $this->file($this->loading);
		$file = preg_replace('/.+\/+/', '', $file);
		$this->import($file);
	}

	function xmlObject()
	{
		return ajax()->xmlObjects($this->_id);
	}

	/**
	 *
	 * mirrors xmlItem::xml()
	 */
	function xml()
	{
		return ajax()->xmlObjects($this->_id)->xml();
	}

	/**
	 *
	 * mirrors xmlItem::rawXml()
	 */
	function output()
	{
		return ajax()->xmlObjects($this->_id)->output();
	}

	/**
	 *
	 * mirros xmlItem::delete()
	 */
	function delete()
	{
		return ajax()->xmlObjects($this->_id)->delete();
	}

	function trigger($event, $params = array())
	{
		$ajax = ajax();

		if(self::$_instances_exist) {
			foreach(self::$_instances_exist as $k => $v) {

				$plugin = $ajax->plugin($v);

				if(!$plugin || !plugin::hasClass($k))  {
					continue;
				}

				if($plugin->exclude) {
					continue;
				}
				if(method_exists($plugin, $event)) {
					call_user_func_array(array($plugin,$event), $params);
					if(is_a($plugin,'xmlItem')) {
						die('plugin:delete');
						$plugin->delete();
					}
				}
			}
		}
	}

	/**
	 *
	 * pass apis, and they will be accesible in javascripot through this.callback;
	 *
	 * @param unknown_type $apiObj
	 */
	function callback($apiObj)
	{
		$this->xml->callback = $apiObj;
		CoreEvents::$cache = CoreEvents::callbacks(CoreEvents::$cache);
	}

	function imports($files = array(), &$data = array())
	{
		$data['plugin_dir'] = $this->loading;
		$ajax = ajax();

		return $ajax->imports($files, $data);
	}

	/**
	 *
	 * Impor javascript and css files
	 * @param mixed $file
	 * @param string $name
	 * @param integer $load_time - in milliseconds
	 */
	function import($file , $load_time = 0, $on_init = false)
	{
		$ajax = ajax();

		if(!is_array($file) && preg_match("/^https?/",$file)) {
			$data['file'] = $file;
		} else {
			$data['plugin_dir'] = $this->loading;
			$data['file'] = $file;
		}

		$data['time'] = (int) $load_time;


		if($on_init) {
			$ajax->init_extra[] = $data;
		} else {
			$ajax->first();//forces this command to be executed before any other
			$ajax->import($data);
		}
	}

	function waitFor($file)
	{
		ajax()->xmlObjects($this->_id)->waitfor = $file;
		CoreEvents::simpleCommit();
	}

	public static function isPlugin($plugin_name)
	{
		$plugins = self::readDir(CJAX_HOME."/plugins/");
		if(isset($plugins[$plugin_name])) {
			return isset($plugins[$plugin_name]);
		}
	}

	function setInstances()
	{
		if(self::$_initiated) {
			return true;
		}
		new plugin();
		if(!self::$_instances) {
			return;
		}
		$ajax = ajax();
		foreach(self::$_instances as $k => $v) {
			$ajax->$k = $v;
		}
		self::$_initiated = true;
	}


	/**
	 *
	 * Handle right handlers chain apis
	 *
	 * @param unknown_type $api
	 * @param unknown_type $args
	 */
	function __call($api, $args)
	{
		return call_user_func_array(array($this->xml,$api), $args);
	}

	/**
	 *
	 * Set variables
	 */
	function __set($setting, $value)
	{
		$this->setVar($setting, $value);
	}

	function setVar($setting, $value)
	{
		if(empty(self::$_instances_ids) || !isset(self::$_instances_ids[$this->loading])) {
			return;
		} else {
			$instances  = self::$_instances_ids[$this->loading];
		}

		foreach ($instances as  $v) {
			$this->_setVar($setting , $value, $v);
		}
	}

	/**
	 *
	 * Set variables that can be accessed as this.var
	 */
	private function _setVar($setting, $value, $instance_id)
	{
		if(!isset(CoreEvents::$cache[$instance_id])) {
			return;
		}
		$item = CoreEvents::$cache[$instance_id];

		if(is_array($value)) {
			$value  = CoreEvents::mkArray($value);
		}
		$item['extra'][$setting] = $value;

		CoreEvents::UpdateCache($instance_id, $item);
	}

	/**
	 *
	 * Updates parameters using plugin class
	 */
	public function set($setting, $value , $instance_id = null)
	{
		$params = range('a','z');

		if(!in_array($setting, $params)) {
			return $this->setVar($setting,$value);
		}

		if(!is_null($instance_id)) {
			$item = CoreEvents::$cache[$instance_id];
			$item['options'][$setting] = $value;

			CoreEvents::UpdateCache($instance_id, $item);
		} else {

			if(!isset(self::$_instances_ids[$this->loading])) {
				return;
			}

			$instances  = self::$_instances_ids[$this->loading];

			if(!$instances) {
				return false;
			}
			if(count($instances)==1) {
				return $this->set($setting ,$value, implode($instances));
			}
			foreach ($instances as  $v) {
				$this->set($setting ,$value, $v);
			}
		}
	}

	public static function getPluginInstance($plugin = null, $params = array(), $instance_id = null)
	{
		if(isset(self::$_instances[$plugin]) && is_object(self::$_instances[$plugin])) {
			return self::$_instances[$plugin];
		}
		if(!isset(self::$_instances_exist[$plugin])) {
			$plugin_class = 'plugin_'.$plugin . $instance_id;
			eval('class ' . $plugin_class . ' extends plugin {}');
			self::$_instances_exist[$plugin] = $plugin_class;
		} else {
			$plugin_class = self::$_instances_exist[$plugin];
		}

		if(!isset(self::$_instances[$plugin])  ||  !is_object(self::$_instances[$plugin])) {
			$ajax = ajax();
			if(!isset($params[1])) {
				self::$_loading_prefix = $plugin;
				$_plugin = self::$_instances[$plugin]  = new $plugin_class();
				$_plugin->params  = array();
				if(!is_null($instance_id)) {
					$_plugin->_id = $instance_id;
					$_plugin->id = $instance_id;
					self::$_instances_ids[$plugin][$instance_id] = $instance_id;
				}

				$_plugin->dir = self::dir($plugin);
				$_plugin->loading = $plugin;

				self::$_loading_prefix = null;
			} else {
				$args = array();
				$params = $params[1];
				$_params = range('a','f');
				foreach($_params as $k => $v) {
					$args[$v] = current($params);
					if($k >= count($params)) {
						$args[$v] = null;
					} else {
						next($params);
					}
				}
				extract($args);
				self::$_loading_prefix = $plugin;
				$_plugin = self::$_instances[$plugin][$instance_id]  = new $plugin_class($a,$b,$c,$d,$e,$f);
				$_plugin->params  = $params;
				if(!is_null($instance_id)) {
					$_plugin->_id = $instance_id;
					$_plugin->id = $instance_id;
					self::$_instances_ids[$plugin][$instance_id] = $instance_id;
				}
				$_plugin->dir = plugin::dir($plugin);
				$_plugin->loading = $plugin;
				self::$_loading_prefix = null;
			}
		} else {
			$_plugin = self::$_instances[$plugin];
		}
		$dir = plugin::dir($plugin).$_plugin->controllers_dir;
		$_plugin->xml = $ajax->xmlObject($instance_id);
		$_plugin->controllers_dir = $dir;
		if(!$_plugin->controller) {
			$_plugin->controller = $plugin;
		} else {
			$_plugin->controller = $_plugin->controller;
		}
		$_plugin->loading = $plugin;
		return $_plugin;
	}

	static function instanceTriggers($_plugin , $params)
	{
		$ajax = ajax();
		if(!$ajax->isAjaxRequest()) {
			if(method_exists($_plugin, 'onLoad')) {
				if($params) {
					call_user_func_array(array($_plugin,'onLoad'), $params);
				}
			}
		} else {
			if(method_exists($_plugin, 'onAjaxLoad')) {
				if($params) {
					call_user_func_array(array($_plugin,'onAjaxLoad'),  $params);
				}
			}
		}
	}

	function DeleteEntry($entry_id)
	{
		if(isset(CoreEvents::$cache[$entry_id])) {
			unset(CoreEvents::$cache[$entry_id]);
		}
		self::$_instances_ids[$this->loading] = array();
	}

	public function hasClass($plugin)
	{
		if(isset(self::$_instances_exist[$plugin])) {
			return true;
		}
	}

	public static function getInstance($plugin = null, $params = array() , $instance_id  = null)
	{
		if(is_object(self::$instance)) {
			return self::$instance;
		}
		if(!$plugin) {
			$plugin = new plugin;
			return self::$instance = $plugin;
		}

		if($plugin = self::getPluginInstance($plugin, $params, $instance_id)) {
			return $plugin;
		}

	}

	public static function initiatePlugins()
	{
		if(self::$initiatePlugins) {
			return self::$initiatePlugins;
		}
		$base = CJAX_HOME;
		$plugins = CJAX_HOME."/plugins/";

		self::$initiatePlugins = self::readDir($plugins);
	}

	public function merge($setting, $new_data)
	{
		$data = $this->get($setting);

		foreach($new_data as $k => $v) {
			$data[$k] = $v;
		}
		$this->save($setting, $data);
	}

	/**
	 *
	 * Saves values in a cookie or session
	 * @param unknown_type $setting
	 * @param unknown_type $value
	 */
	public function save($setting, $value, $prefix = null)
	{
		if(!$prefix) {
			$prefix = $this->loading;
		}
		if(!$prefix && self::$_loading_prefix) {
			$prefix = self::$_loading_prefix;
		}
		if($prefix) {
			$setting = $prefix.'_'.$setting;
		}
		$ajax = ajax();

		return $ajax->save($setting,$value, $this->cookie);
	}

	/**
	 *
	 * get settings saved in cookies
	 */
	function get($setting, $prefix = null)
	{
		if(!$prefix) {
			$prefix = $this->loading;
		}
		if(!$prefix && self::$_loading_prefix) {
			$prefix = self::$_loading_prefix;
		}
		if($prefix) {
			$setting = $prefix.'_'.$setting;
		}
		$setting = strtolower($setting);
		$ajax = ajax();

		$data = $ajax->getSetting($setting, $prefix);

		return $data;
	}

	function  __get($setting)
	{
		return self::get($setting);
	}

	/**
	 * get the full path of a plugin
	 */
	static function file($name)
	{
		$plugin_name = self::$initiatePlugins[$name]->file;

		return $plugin_name;
	}

	function init()
	{
		return $this->init;
	}

	static function method($method)
	{
		return self::$initiatePlugins[$method]->method;
	}

	public static function dir($plug_name = null)
	{
		$dir = self::$_dirs[$plug_name];

		return $dir;
	}

	public static function readDir($resource)
	{
		if(self::$readDir) {
			return self::$readDir;
		}
		$resource = str_replace("\\","/",$resource);
		$dirs = scandir($resource);
		unset($dirs[0],$dirs[1]);
		$new = array();

		$ajax = ajax();

		foreach($dirs as $k => $v) {
			$name = preg_replace("/\..+$/", '', $v);

			if(isset($new[$name])) {
				continue;
			}
			$obj = new ext($v);
			$obj->file = "{$v}.js";
			$obj->method = $v;
			if(is_dir($resource.$v)) {
				self::$_dirs[$name] = $resource.$v.'/';
				$dir = self::$_dirs[$name];

				if(file_exists($f = "{$dir}{$v}.php")) {
					require_once $f;
					$class = $v;
					$parent = get_parent_class($class);
					if(!class_exists($class)) {
						$class = 'plugin_'.$v;
					} else if($parent!='plugin') {
						$class = 'plugin_'.$v;
					}

					if(class_exists($class)) {
						$vars = get_class_vars($class);

						if(isset($vars['file'])) {
							$obj->file = $vars['file'];
							$obj->method = preg_replace(array("/\..+$/","/\.js$/"), '', $obj->file);
						}
						self::$_instances_exist[$v] = $class;

						if(method_exists($class, 'autoload')) {
							call_user_func(array($class,'autoload'));
						}
						if(!$ajax->isAjaxRequest()) {
							if(method_exists($class, 'PageAutoload')) {
								call_user_func(array($class,'PageAutoload'));
							}
						} else {
							if(method_exists($class, 'AjaxAutoload')) {
								call_user_func(array($class,'AjaxAutoload'));
							}
						}
					}
				}
				$obj->file = "{$v}/{$obj->file}";
				$new[$name] = $obj;
			} else {
				self::$_dirs[$name] = $resource;
				$new[$name] = $obj;
				$dir = $resource;
			}
		}
		return self::$readDir = $new;
	}
}