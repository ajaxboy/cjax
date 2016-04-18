<?php

namespace CJAX\Plugins\Dracula\Controllers;
use CJAX\Core\AJAXController;

class Dracula extends AJAXController{
	
    protected $elementsOrders;
    
        
    protected function loadElementsOrders(){
        $elementsOrders = filter_input(INPUT_COOKIE, 'dragulaorders');
        if($elementsOrders){
            $this->elementsOrders = json_decode($_COOKIE['dragulaorders'], true);
        }        
    }
}