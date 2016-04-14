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
*   Date: 03/13/2006                          $     
*   File Last Changed:  03/13/2016           $     
**####################################################################################################    */ 

namespace CJAX\Event;
use StdClass;

class KeyEvent extends InputEvent{

    protected $charCode;
    
    protected $keyCode;
    
    protected $keyText;
    
    protected $location;

    
    public function __construct(StdClass $event){
        parent::__construct($event);
        $this->charCode = $event->charCode;        
        $this->keyCode = $event->keyCode;
        $this->keyText = $event->key;
        $this->location = $event->location;
    }
    
    public function getCharCode(){
        return $this->charCode;
    }
    
    public function getKeyCode(){
        return $this->keyCode;
    }
    
    public function getKeyText(){
        return $this->keyText;
    }
    
    public function getLocation(){
        return $this->location;
    }   
}