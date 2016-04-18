<?php

/**
 * dragula 1.0
 * 
 * Plugin Class
 * 
 * @author Ordland Euroboros
 *
 */
 
namespace CJAX\Plugins\Dragula; 
use CJAX\Core\Plugin;
 
class Dragula extends Plugin{
	
	private $options = []; 
    
    private $events = [];
			

	/**
	 * 
	 * @param array|string $containers
	 * @param array $options
	 */
	public function onLoad($containers = null, $options = []){	
		$this->options = $options;
		$this->import('dragula-3.6/dragula.min.js', 0, true);
		$this->import('dragula-3.6/dragula.min.css');
	}
	
	/**
	 * This function updates second parameter values options
	 * eg.
	 * $this->copy = true;
	 * $this->removeOnSpill = true;
	 */
	public function __set($setting, $value){
		$this->options[$setting] = $value;		
		//Save to options /second parameter
		$this->set('b', $this->options); 
	}
    
    public function event($eventName, $eventHandler){
       if(!$eventHandler){
           return $this;
       }       
       $this->events[$eventName] = $eventHandler;
       $this->set('c', $this->events);
       return $this;
    }
}