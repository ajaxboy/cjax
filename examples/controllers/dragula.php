<?php

namespace Examples\Controllers;
use CJAX\Plugins\Dracula\Controllers\Dracula;
 
class Dragula extends Dracula{

	public function drop($elementId){
        $this->ajax->$elementId = ['style' => ['background-color' => '#e74c3c']];
        $this->ajaxMessage($elementId);
    }

    private function ajaxMessage($elementId){
        $this->loadElementsOrders();
        $ajaxMessage = "<br>";
        foreach($this->elementsOrders as $container => $elements){
            $ajaxMessage .= "<br>Container #{$container}: <br>";
            foreach($elements as $element){
                $ajaxMessage .= "&nbsp;&nbsp;&nbsp;&nbsp;Element: #{$element}; <br>";
            }
        }
        $this->ajax->success("You have moved element {$elementId} and changed the order of items in this list, the new order is: {$ajaxMessage}");
    }
}