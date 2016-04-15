<?php

namespace Examples\Controllers;

use CJAX\Core\CJAX;
use CJAX\Event\DragEvent;

class Captcha{
	
	public function dragstart(DragEvent $event){

	}

	public function dragenter(DragEvent $event){
		$ajax = CJAX::getInstance();
        $target = $event->getTarget();
        $ajax->$target = ['style' => ['borderWidth' => '3px', 'borderColor' => 'red', 'border-style' => 'dotted']];
	}

	public function dragleave(DragEvent $event){
		$ajax = CJAX::getInstance();
        $target = $event->getTarget();
        $ajax->$target = ['style' => ['borderWidth' => '1px', 'borderColor' => '#aaaaaa', 'borderStyle' => 'solid']];
	}

	public function drop(DragEvent $event, $ball = null){
        if(!$ball){
            return;
        }
		$ajax = CJAX::getInstance();
        $data = $event->getData();
        $target = $event->getTarget();
        if($target != "box"){
            return;
        }
        if($data == $ball){ 
	        $ajax->notes = "<span style='color:blue;'>You have selected the correct ball, congratulations!</span>";
            $ajax->process("You have passed the captcha test, the page will refresh in 5 seconds."); 
            $ajax->wait(5);
            $ajax->location();
        }
        else{
            $ajax->notes = "<span style='color:red;'>You have picked the wrong ball, please try again!</span>";
        }
	}
}