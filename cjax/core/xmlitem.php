<?php

/** ################################################################################################**   
* Copyright (c)  2008  CJ.   
* Permission is granted to copy, distribute and/or modify this document   
* under the terms of the GNU Free Documentation License, Version 1.2   
* or any later version published by the Free Software Foundation;   
* Provided 'as is' with no warranties, nor shall the autor be responsible for any mis-use of the same.     
* A copy of the license is included in the section entitled 'GNU Free Documentation License'.   
*   
*   CJAX  6.0               $     
*   ajax made easy with cjax                    
*   -- DO NOT REMOVE THIS --                    
*   -- AUTHOR COPYRIGHT MUST REMAIN INTACT -   
*   Written by: CJ Galindo                  
*   Website: http://cjax.sourceforge.net                     $      
*   Email: cjxxi@msn.com    
*   Date: 2/12/2007                           $     
*   File Last Changed:  03/11/2016            $     
**####################################################################################################    */  

namespace CJAX\Core;

class XmlItem{
	
	public $selector;
	public $coreEvents;
	public $id = null;
	public $name = null;
	public $type = null;
	
	/**
	 * 
	 * Any extra data that can be added through the xml item to other Exec events
	 * @var unknown_type
	 */
	public $buffer = [];
    
	//**ADD all existing built-in functions
	private $api = ['overlay', 'overlayContent', 'call', 'form', 'import', 'AddEventTo', 'Exec', 
                    'click', 'change', 'update', 'property', 'keyup', 'keydown', 'keypress', 'mouseover', 
                    'mouseout', 'mouseenter', 'mouseleave', 'mousedown', 'mouseup', 'mousemove',
                    'drag', 'dragend', 'dragenter', 'dragleave', 'dragover', 'dragstart', 'drop',
		            'blur', 'success', 'warning', 'process', '_message', 'error', 'location'];
	
	public $cache = [];
	
    
	public function __construct(CoreEvents $coreEvents, $xmlId, $name = null, $type = null){
        $this->coreEvents = $coreEvents;
		$this->name = $name;
		$this->id = (int) $xmlId;
		$this->type = $type;
	}
	
	public function __set($setting, $value){
		if($value instanceof Plugin){
			if(method_exists($value, 'callbackHandler')){
			    if($value->callbackHandler($value->xml,$this, $setting)){
					return $value;
				}
		    }
            
			switch($setting){
				case 'waitFor':
					$value = $value->id;
				    break;
				case 'callback':					
					if(isset(CoreEvents::$callbacks[$value->id])){					
						$cb = CoreEvents::$callbacks[$value->id];
						$cb = $this->coreEvents->processScache($cb);						
						//die("s<Pre>".print_r($cb,1));
						CoreEvents::$cache[$value->id]['callback'] = $this->coreEvents->mkArray($cb,'json', true);
						
						CoreEvents::$callbacks[$this->id][$value->id] = CoreEvents::$cache[$value->id];
						$value->delete();
					} 
                    else{
						CoreEvents::$callbacks[$this->id][$value->id][] = CoreEvents::$cache[$value->id];
						$value->delete();
					}					
					return;
				    break;
				default:
					return;
			}
			
		} 
		
		if(in_array(CJAX::getInstance()->lastCmd, $this->api)){
			if(is_object($value)){
				CoreEvents::$callbacks[$this->id][$value->id] = CoreEvents::$cache[$value->id];
			} 
            else{
				CoreEvents::$callbacks[$this->id][$value] = CoreEvents::$cache[$value];
			}
		} 
        else{
			$event = CoreEvents::$cache[$this->id];
			$event[$setting] = $value;
			CoreEvents::$cache[$this->id] = $event;
			if($setting=='waitFor'){
				CoreEvents::$cache[$value]['onwait'][$this->id] = $this->xml();
				$this->delete();
			}
			$this->coreEvents->simpleCommit();
		}
		
	}
	
	public function attach($callbacks){
		$xml = $this->xml();
		$cb = $this->coreEvents->processScache($callbacks);
		$xml['stack'] = $this->coreEvents->mkArray($cb);
		CoreEvents::$cache[$this->id] = $xml;
		
		foreach($callbacks as $k2 => $v2){
			unset(CoreEvents::$cache[$k2]);
		}
	}
	
	/**
	 * 
	 * for js functions
	 * @param unknown_type $fn
	 * @param unknown_type $args
	 */
	public function __call($fn, $args){
		if(isset($args['do'])){
			return true;
		}
		$ajax = CJAX::getInstance();		
		if($ajax->isPlugin($fn)){
			$lastCmd = $ajax->lastCmd;
			$plugin = call_user_func_array([$ajax, $fn], $args);
			if(method_exists($plugin, 'rightHandler')){
				$plugin->rightHandler($lastCmd, $args, $this);
			}
			return $plugin;
		}
		if(in_array($fn,$this->api)){
			$this->callback = call_user_func_array([$ajax,$fn],$args);
			return $this;
		}
		
		if($this->selector){
			$_args[] = $this->selector;
			$_args = array_merge($_args, $args);
			$args = $_args;
		}
		$params = range('a','z');

		$pParams = [];
		if($args){
			do{
				if(is_array($args[key($args)])){
					$pParams[current($params)] = $args[key($args)];
				} 
                else{
					$pParams[current($params)] = $args[key($args)];
				}
				
			}while(next($args) && next($params));
		}
		
		$data = [];
		$data['do'] = '_fn';
		$data['fn'] = $fn;
		$data['fn_data'] = $pParams;
		
		$item = $ajax->xmlItem($ajax->xml($data),'xmlItem_fn');
		return  $item;
	}
	
	public function callback($xmlObj, $fn = null){
		$this->callback = $xmlObj;
		//die("<pre>".print_r($this,1).print_r($xmlObj,1));
	}
	
	public function delete(){
		if(!is_null($this->id)) {
			$this->coreEvents->removeExecCache($this->id);
		}
	}
	
	public function next($xmlObj){
		$ajax = CJAX::getInstance();
		$xmlObjects = $ajax->xmlObjects();
		$found = false;
		foreach($xmlObjects as $v){
			if($v->id==$xmlObj->id){
				$found = true;
				continue;
			}
			if($found){
				return $v;
			}
		}
	}
	
	public function xml($id = null){
		$id  or $id = $this->id;
		if(!is_null($id)){
			return CoreEvents::$cache[$id];
		}
	}
}