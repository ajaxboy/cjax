<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class SendInput extends AJAXController{
	
	public function sendText($text){		
		$this->ajax->success("This message was sent: $text",30);
	}
	
	public function sendCheckbox($check){
		if($check){
			$this->ajax->success("Is checked..");
		} 
        else{
			$this->ajax->warning("Is not checked..");
		}
	}
}