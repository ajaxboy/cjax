<?php
/** ################################################################################################**   
* Copyright (c)  2008  CJ.   
* Permission is granted to copy, distribute and/or modify this document   
* under the terms of the GNU Free Documentation License, Version 1.2   
* or any later version published by the Free Software Foundation;   
* Provided 'as is' with no warranties, nor shall the author be responsible for any mis-use of the same.     
* A copy of the license is included in the section entitled 'GNU Free Documentation License'.   
*   
*   CJAX  6.0               $     
*   ajax made easy with cjax                    
*   -- DO NOT REMOVE THIS --                    
*   -- AUTHOR COPYRIGHT MUST REMAIN INTACT -   
*   Written by: CJ Galindo                  
*   Website: http://cjax.sourceforge.net                     $      
*   Email: cjxxi@msn.com    
*   Date: 03/13/2016                           $     
*   File Last Changed:  03/13/2016           $     
**####################################################################################################    */ 

namespace CJAX\Event;
use StdClass;

abstract class Event{
	
    const CAPTURING_PHASE = 1;
    
    const AT_TARGET = 2;
    
    const BUBBLING_PHASE = 3;
    
    protected $bubbles;
    
    protected $cancelable;
    
    protected $defaultPrevented;
    
    protected $phase;
    
    protected $source;
    
    protected $target;
    
    protected $timeStamp;
    
    protected $trusted;
    
    protected $type;
    
    
	public function __construct(StdClass $event){
        $this->bubbles = (bool)$event->bubbles;
        $this->cancelable = (bool)$event->cancelable;
        $this->defaultPrevented = (bool)$event->defaultPrevented;
        $this->phase = $event->eventPhase;
        $this->source = $event->target;
        $this->target = $event->currentTarget;
        $this->timeStamp = $event->timeStamp;
        $this->trusted = (bool)$event->isTrusted;
        $this->type = $event->type;
    }
    
    public function canBubble(){
        return $this->bubbles;
    }
    
    public function isCancelable(){
        return $this->cancelable;
    }
    
    public function hasDefaultPrevented(){
        return $this->defaultPrevented;
    }
    
    public function getPhase(){
        return $this->phase;
    }
    
    public function getSource(){
        return $this->source;
    }
    
    public function getTarget(){
        return $this->target;
    }
    
    public function getTimeStamp(){
        return $this->timeStamp;
    }
    
    public function isTrusted(){
        return $this->trusted;
    }
    
    public function getType(){
        return $this->type;
    }
    
    public function __toString(){
        return "Event:".get_class($this).".{$this->type}";
    }
}