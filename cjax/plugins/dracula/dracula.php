<?php

/**
 * dracula 1.0
 * 
 * Plugin Class
 * 
 * @author Ordland Euroboros
 *
 */
 
namespace CJAX\Plugins\Dracula; 
use CJAX\Core\Plugin;
 
class Dracula extends Plugin{
	
    private $containers = [];

	private $options = []; 
    
    private $events = [];
			

	/**
	 * 
	 * @param array|string $containers
	 * @param array $options
     * @param array $events
	 */
	public function onLoad($containers = null, $options = [], $events = []){	
		$this->import('dragula-3.6/dragula.min.js', 0, true);
        if($containers){
            $this->drake($containers, $options, $events);
        }
	}
    
    public function drake($containers = null, $options = [], $events = []){
        $this->containers[] = $containers;
        $this->options[] = $options;
        $this->events[] = $events;
        $this->set('a', $this->containers);
        $this->set('b', $this->options);
        $this->set('c', $this->events);
    }
}