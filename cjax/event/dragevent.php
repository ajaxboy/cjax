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
*   File Last Changed:  04/10/2016           $     
**####################################################################################################    */ 

namespace CJAX\Event;
use StdClass;

class DragEvent extends MouseEvent{

    protected $data;
    
    protected $dropEffect;
    
    protected $effectAllowed;
    
    protected $files;

    
    public function __construct(StdClass $event){
        parent::__construct($event);
        $this->data = $event->data;        
        $this->dropEffect = $event->dropEffect;
        $this->effectAllowed = $event->effectAllowed;
        $this->files = $event->files;
    }
 
    
    public function getData(){
        return $this->data;
    }
    
    public function getDropEffect(){
        return $this->dropEffect;
    }   
    
    public function isEffectAllowed(){
        return $this->effectAllowed;
    }
    
    public function getFiles(){
        return $this->files;
    }
}