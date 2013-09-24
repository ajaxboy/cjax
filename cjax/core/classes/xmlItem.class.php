<?php

class xmlItem {
	
	public $selector;
	
	public $id = null;
	public $name = null;
	public $type = null;
	
	/**
	 * 
	 * Any extra data that can be added through the xml item to other Exec events
	 * @var unknown_type
	 */
	public $buffer = array();
	
	private $api = array(
		'overlay',
		'overlayContent',
		'call',
		'form',
		'import',
		'AddEventTo',
		'Exec',
		'click',
		'change',
		'keyup',
		'keydown',
		'blur'
	);
	
	public $cache = array();
	
	function __construct($xml_id, $name = null,$type = null)
	{
		$this->name = $name;
		$this->id = (int) $xml_id;
		$this->type = $type;
	}
	
	function __set($setting, $value)
	{
		if(is_a($value,__class__) || is_a($value,'plugin')) {
			if(is_a($value,'plugin')) {
				if(method_exists($value, 'callbackHandler')) {
					if($value->callbackHandler($value->xml,$this, $setting)) {
						return $value;
					}
				}
			}
			switch($setting) {
				case 'waitFor':
					$value = $value->id;
				break;
				case 'callback':
					
					if(isset(CoreEvents::$callbacks[$value->id])) {
						
						$cb = CoreEvents::$callbacks[$value->id];
						$cb = CoreEvents::processScache($cb);
						
						//die("s<Pre>".print_r($cb,1));
						CoreEvents::$cache[$value->id]['callback'] = CoreEvents::mkArray($cb,'json', true);
						
						CoreEvents::$callbacks[$this->id][$value->id] = CoreEvents::$cache[$value->id];
						$value->delete();
					} else {
						CoreEvents::$callbacks[$this->id][$value->id] = CoreEvents::$cache[$value->id];
						$value->delete();
					}
					
					
					//die('sss<pre>'.print_r(CoreEvents::$cache,1) . "ddd<pre".print_r(CoreEvents::$callbacks,1));
					return;
				break;
				default:
					//nothing to handle
					return;
			}
			
		}
		$event = CoreEvents::$cache[$this->id];
		$event[$setting] = $value;
		CoreEvents::$cache[$this->id] = $event;
		if($setting=='waitFor') {
			CoreEvents::$cache[$value]['onwait'][$this->id] = $this->xml();
			$this->delete();
		}
		CoreEvents::simpleCommit();
		
	}
	
	/**
	 * 
	 * for js functions
	 * @param unknown_type $fn
	 * @param unknown_type $args
	 */
	function __call($fn, $args)
	{
		if(isset($args['do'])) {
			return true;
		}
		
		$ajax = ajax();
		
		if($ajax->isPlugin($fn)) {
			$last_cmd = $ajax->lastCmd;
			$plugin = call_user_func_array(array($ajax,$fn), $args);
			if(method_exists($plugin, 'rightHandler')) {
				$plugin->rightHandler($last_cmd, $args, $this);
			}
			return $plugin;
		}
		if(in_array($fn,$this->api)) {
			$this->callback = call_user_func_array(array($ajax,$fn),$args);
			return $this;
		}
		
		
		if($this->selector) {
			$_args[] = $this->selector;
			$_args = array_merge($_args, $args);
			$args = $_args;
		}
		$params = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

		$pParams = array();
		if($args) {
			do {
				if(is_array($args[key($args)])) {
					$pParams[current($params)] =   $args[key($args)];
				} else {
					$pParams[current($params)] =   $args[key($args)];
				}
				
			} while(next($args) && next($params));
		}
		
		$ajax = ajax();
		
		$data = array();
		$data['do'] = '_fn';
		$data['fn'] = $fn;
		$data['fn_data'] = $pParams;
		
		$item = $ajax->xmlItem($ajax->xml($data),'xmlItem_fn');
		return  $item;
	}
	
	function callback($xmlObj,$fn = null)
	{
		$this->callback = $xmlObj;
		//die("<pre>".print_r($this,1).print_r($xmlObj,1));
	}
	
	function delete()
	{
		if(!is_null($this->id)) {
			CoreEvents::removeExecCache($this->id);
		}
	}
	
	function next($xmlObj)
	{
		$ajax = ajax();
		$xmlObjects = $ajax->xmlObjects();
		$found = false;
		foreach($xmlObjects as $v) {
			if($v->id==$xmlObj->id) {
				$found = true;
				continue;
			}
			if($found) {
				return $v;
			}
		}
	}
	
	function xml($id = null)
	{
		$id  or $id = $this->id;
		if(!is_null($id)) {
			return CoreEvents::$cache[$id];
		}
	}
}