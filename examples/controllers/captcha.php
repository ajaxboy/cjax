<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;
use CJAX\Event\DragEvent;

class Captcha extends AJAXController{
	
	public function dragstart(DragEvent $event){

	}

	public function dragenter(DragEvent $event){
        $target = $event->getTarget();
        $this->ajax->$target = ['style' => ['borderWidth' => '3px', 'borderColor' => 'red', 'border-style' => 'dotted']];
	}

	public function dragleave(DragEvent $event){
        $target = $event->getTarget();
        $this->ajax->$target = ['style' => ['borderWidth' => '1px', 'borderColor' => '#aaaaaa', 'borderStyle' => 'solid']];
	}

	public function drop(DragEvent $event, $ball = null){
        if(!$ball){
            return;
        }
        $data = $event->getData();
        $target = $event->getTarget();
        if($target != "box"){
            return;
        }
        if($data == $ball){ 
	        $this->ajax->notes = "<span style='color:blue;'>You have selected the correct ball, congratulations!</span>";
            $this->ajax->process("You have passed the captcha test, the page will refresh in 5 seconds."); 
            $this->ajax->wait(5);
            $this->ajax->location();
        }
        else{
            $this->ajax->notes = "<span style='color:red;'>You have picked the wrong ball, please try again!</span>";
        }
	}
}