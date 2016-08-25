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

					CoreEvents::$callbacks[$this->id][$value->id] = CoreEvents::delegateActions($value->id);

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
		if(!ajax()->isAjaxRequest()) {
			CoreEvents::simpleCommit();
		}
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
		$params = range('a','z');

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
		$data['options'] = $pParams;

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