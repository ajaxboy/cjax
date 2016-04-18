<?php

namespace CJAX\Plugins\Dragula\Controllers;
use CJAX\Core\AJAXController;

class Dragula extends AJAXController{
	
    protected $elementsOrders;
    
        
    protected function loadElementsOrders(){
        $elementsOrders = filter_input(INPUT_COOKIE, 'dragulaorders');
        if($elementsOrders){
            $this->elementsOrders = json_decode($elementsOrders, true);
        }        
    }
}