<?php

use CJAX\Core\CJAX;

class Send_input{
	
	public function send_text($text){		
		$ajax = CJAX::getInstance();		
		$ajax->success("This message was sent: $text",30);
	}
	
	public function send_checkbox($check){
		$ajax = CJAX::getInstance();		
		if($check){
			$ajax->success("Is checked..");
		} 
        else{
			$ajax->warning("Is not checked..");
		}
	}
}