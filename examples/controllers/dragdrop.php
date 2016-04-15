<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;
use CJAX\Event\DragEvent;

class Dragdrop extends AJAXController{
	
	public function dragstart(DragEvent $event){
        $data = $event->getData();
	    $this->ajax->notes = "You have begun dragging the {$data}.";
	}

	public function dragend(DragEvent $event){
        $data = $event->getData();
	    $this->ajax->notes = "You have ended dragging the {$data}.";
	}

	public function dragenter(DragEvent $event){
        $data = $event->getData();
        $target = $event->getTarget();
        $this->ajax->$target = ['style' => ['borderWidth' => '3px', 'borderColor' => 'red', 'border-style' => 'dotted']];
	    $this->ajax->notes = "The {$data} entering the {$target}.";
	}

	public function dragleave(DragEvent $event){
        $data = $event->getData();
        $target = $event->getTarget();
        $this->ajax->$target = ['style' => ['borderWidth' => '1px', 'borderColor' => '#aaaaaa', 'borderStyle' => 'solid']];
	    $this->ajax->notes = "The {$data} Leaving the {$target}.";
	}

	public function drop(DragEvent $event){
        $data = $event->getData();
        $target = $event->getTarget();
	    $this->ajax->notes = "The {$data} is dropped inside the {$target}.";
	}
}