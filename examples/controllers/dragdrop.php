<?php

use CJAX\Core\CJAX;
use CJAX\Event\DragEvent;

class Dragdrop{
	
	public function dragstart(DragEvent $event){
		$ajax = CJAX::getInstance();
        $data = $event->getData();
	    $ajax->notes = "You have begun dragging the {$data}.";
	}

	public function dragend(DragEvent $event){
		$ajax = CJAX::getInstance();
        $data = $event->getData();
	    $ajax->notes = "You have ended dragging the {$data}.";
	}

	public function dragenter(DragEvent $event){
		$ajax = CJAX::getInstance();
        $data = $event->getData();
        $target = $event->getTarget();
        $ajax->$target = ['style' => ['borderWidth' => '3px', 'borderColor' => 'red', 'border-style' => 'dotted']];
	    $ajax->notes = "The {$data} entering the {$target}.";
	}

	public function dragleave(DragEvent $event){
		$ajax = CJAX::getInstance();
        $data = $event->getData();
        $target = $event->getTarget();
        $ajax->$target = ['style' => ['borderWidth' => '1px', 'borderColor' => '#aaaaaa', 'borderStyle' => 'solid']];
	    $ajax->notes = "The {$data} Leaving the {$target}.";
	}

	public function drop(DragEvent $event){
		$ajax = CJAX::getInstance();
        $data = $event->getData();
        $target = $event->getTarget();
	    $ajax->notes = "The {$data} is dropped inside the {$target}.";
	}
}