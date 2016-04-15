<?php

/**
 * 
 * Example Plugin 2.0
 * 
 * This file has the  basic structure and information that can used to create a plugin.
 * This plugin is for demonstration purpose only and does not perform any specific task.
 * 
 * Note:
 * 
 * This php file is  not required at all, and a plugin will work just fine without it. But  
 * if you are doing a complex plugin or require of more power, provide extra functions or data manipulation , without
 * mixing your code you will find this very useful.
 * 
 * 
 * @author cj
 *
 */

//class name must match directory name, as well as the file name.
//extend plugin to inheric generic plugin properties

namespace CJAX\Plugin\ExamplePlugin;
use CJAX\Core\CoreEvents;
use CJAX\Core\Plugin;

class ExamplePlugin extends Plugin{
	
	/**
	 * 
	 * This excludes this plugins from being processed
	 * 
	 * @var unknown_type
	 */
	public $exclude = true;
	
	/**
	 * 
	 * For ajax request
	 * use the plugin name in place of the controller in the url, it will automatically
	 * point to your plugin.
	 * eg. ajax.php?ExamplePlugin/docs
	 * 
	 * Cjax will  add the plugin controller  on top of the list, if a controller is not found
	 * it will  continue its normal process and see for a controller in the default controller process.
	 * 
	 * would seek for: plugins/ExamplePlugin/cntrollers/ExamplePlugin.php:docs();
	 * 
	 * 
	 * @var unknown_type
	 */
	public $controllers_dir = 'controllers'; 
	
	
	/**
	 * 
	 * Autoload - is fired regardless of if the plugin is called or not, in page load and during ajax requests
	 */
	static function autoload(){
		
	}
	
	/**
	 * 
	 * Autoload - is fired regardless of if the plugin is called or not while the page first load ( not in ajax requests)
	 */
	static function PageAutoload(){
		
	}	
	
	/**
	 * 
	 * Autoload - is fired during an ajax request regardless of if the plugin is called or not
	 */
	static function AjaxAutoload(){
		
	}
	
	
	/**
	 * Constructor
	 * 
	 * This function is ran when the plugin is initialized as $ajax->ExamplePlugin();
	 * 
	 * Paramaters:
	 * through the plugin contructor eg. $ajax->ExamplePlugin('test1','test2');
	 * 
	 * This function is ran on contruction - for both page load and ajax.
	 * 
	 * @param unknown_type $arg
	 * @param unknown_type $ar2
	 */
	function ___construct($arg, $ar2){
		//you may access these variables in the plugin as:
		// this.test1 and this.test2
		$this->test1 = ['test_1','test_2'];
		$this->test2 = 'test2';
	}
	
	/**
	 * $this->waitFor('Some-js-file-loaded-throgh-import.js');
	 * 
	 * Lets say that you loaded a javascritp file usin:
	 * 
	 * $ajax->import('some_file.js');
	 * 
	 * Javascript loads scripts acrimoniously so some times even if you load script #1
	 * before #2, it is posibble that script #2 loads before script #1, so this would 
	 * prevent some times  the plugin to work. Here is where waitFor comes in.
	 * 
	 * $ajax->waitFor() - allows #1 to fully load before loading script #2.
	 * 
	 * Also there is another approach to this, see: $this->callback();
	 * 
	 * @param unknown_type $file
	 * 
	 * 
	 */
	function waitfor($file){
		return parent::waitFor($file);
	}
	
	/**
	 * Update parameters
	 * You may use
	 * a,b,c,d,e,f  etc..  as $setting.
	 * 
	 * if the setting is called other than the alphabeth, you  may still access these settings 
	 * eg:
	 * 
	 * Instead of updating parameters you would be updating variables
	 * 
	 * Lets say you set variable testing:
	 * 
	 * $this->set('testing','Hello!');
	 * 
	 * in your plugin you can access it as:  this.testing (if it is inside the scope)  
	 * or ExamplePlugin.testing outside the scope of your plugin.
	 * 
	 * if you use __get() magic function, you  should be able to intercept.
	 * 
	 * @see plugin::set()
	 */
	public function set($setting, $value , $instance_id = null){
		return parent::set($setting, $value);
	}
	
	/**
	 * Semi-Constructor function
	 * 
	 * This function is automatically fired on page load when the loading is invoqued.
	 * Is similar to the constructor, except this one won't be fired on ajax requests, just on page load.
	 * 
	 * The parameters of the contructor will be passed.
	 * 
	 * @param unknown_type $arg
	 * @param unknown_type $ar2
	 */
	function onLoad($arg = null, $ar2 = []){
		
	}
	
	/**
	 * Semi-Constructor function
	 * 
	 * This function is ran only when is an ajax request or a requests approved by $ajax->isAjaxRequest()
	 * That may include others type of requests.
	 * 
	 * The parameters of the contructor will be passed.
	 */
	function onAjaxLoad($arg = null, $ar2 = null){
		
	}
	
	
	/**
	 * 
	 * This function is ran within exec when plugin  passed as paramenter.
	 * Serves mainly to obtain the element_id being used.
	 * 
	 * As of  5.3 +
	 */
	function onEvent($element_id){
		
	}
	
	
	/**
	 * Save plugin settings globally in a session or cookie variable
	 * 
	 * @see plugin::save()
	 */
	public  function save($setting, $value, $prefix = null){
		return parent::save($setting, $value);
	}
	
	/**
	 * Get plugin  setting  saved with  save();
	 * @see plugin::get()
	 */
	function get($setting,$prefix = null){
		return parent::get($setting);
	}
	
	
	/*
	 * Import css and  javascript files into the page
	 * 
	 * $file = use relative paths to the plugin. 
	 * 
	 * $name - in case you want to check if the file is already  loaded,
	 * specify a name. Will try to find a function or variable with that name
	 * and if found,  then it will not proceed to import.
	 * 
	 * $load_time - if you are loading a file that needs a little time to load, you 
	 * may specify milliseconds, for example a range from  100 and 10th of  a second to 500 (half a second)
	 * only use this if you are experiecing issues with the file not being loaded on time.
	 * 
	 */
	function import($file , $load_time = 0, $on_init = false){
		return parent::import($file, $load_time);
	}
	
	/**
	 * like import() - imports allows you to  import files into the page, 
	 * the difference is
	 * @see plugin::imports()
	 * 
	 * provide a list of files to import, eg:
	 * 
	 * The main difference of  import() and imports() is that imports
	 * waits for the previous file to fully be loaded before importing the next,
	 * something import does not do.
	 * 
	 * $this->imports(array('file.css','file2.js','file3.js'); et.
	 * 
	 */
	function imports($files = [], &$data = []){
		
	}
	
	/**
	 * 
	 * Handles right api assignments eg:
	 * 
	 * $ajax->overlay()->[plugin]();
	 * $ajax->call()->[plugin]();
	 * etc...
	 * 
	 * @param string $api - internal API name 
	 * @param array $args
	 */
	function rightHandler($api, $args, $xmlObj){
		switch($api){
			/**
			 * To view all 'internal methods' available , see: cjax/core/classes/cjax.class.php
			 * all functions that say  $data['do'] = 'Function name'; that would be what goes in this list.
			 * and here is where we handle relativity to these functions
			 */
			case '_overLay':
				$xmlObj->callback = $this;
				$this->delete();
				break;
			case '_overLayContent':
				$xmlObj->callback = $this;
				$this->delete();
				break;
		}
		
	}
	
	/**
	 * Advanced Callback Handler
	 * 
	 * Pushes an API to be a part of another API or Plugin instead of running on its own,
	 * then you may access that other callback in plugins through this.callback
	 * 
	 * If your rightHandler is a callback, you may create a custom handler for that callback,
	 * mainly micmic the functionality in core/classes/xmlItem.php on function __set() case 'callback'
	 * 
	 * 
	 */
	function callbackHandler($xmlObj_from, $xmlObj_to, $setting){
        $coreEvents = new CoreEvents;
		$event = CoreEvents::$cache[$xmlObj_from->id];
		$callback = CoreEvents::$cache[$xmlObj_to->id];
		
		//pusha a copy of the API as callback
		$event['callback'][$xmlObj_from->id] = $callback;
		
		//deletes the API
		$xmlObj_from->delete();
		//process
		//do changes to $event
		
		//push changes
		CoreEvents::$cache[$xmlObj_to->id] = $event;
		//commit changes
		$coreEvents->simpleCommit();
		
		return true;
	}
	

}