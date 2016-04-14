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

class MouseEvent extends InputEvent{

    protected $button;
    
    protected $clickCount;
    
    protected $x;
    
    protected $xOnPage;
    
    protected $xOnScreen;
    
    protected $y;
    
    protected $yOnScreen;

    
    public function __construct(StdClass $event){
        parent::__construct($event);
        $this->button = $event->button;        
        $this->clickCount = $event->detail;
        $this->x = $event->x;
        $this->xOnPage = $event->pageX;
        $this->xOnScreen = $event->screenX;
        $this->y = $event->y;
        $this->yOnPage = $event->pageY;
        $this->yOnScreen = $event->screenY;
    }
    
    public function getButton(){
        return $this->button;
    }
    
    public function getClickCount(){
        return $this->clickCount;
    }
    
    public function getX(){
        return $this->x;
    }
    
    public function getXOnPage(){
        return $this->xOnPage;
    }   
    
    public function getXOnScreen(){
        return $this->xOnScreen;
    }
    
    public function getY(){
        return $this->y;
    }   
    
    public function getYOnPage(){
        return $this->yOnPage;
    }   
    
    public function getYOnScreen(){
        return $this->yOnScreen;
    }   

    public function getLocation(){
        return [$this->x, $this->y];
    }

    public function getLocationOnPage(){
        return [$this->xOnPage, $this->yOnPage];
    }     
    
    public function getLocationOnScreen(){
        return [$this->xOnScreen, $this->yOnScreen];
    }    
}