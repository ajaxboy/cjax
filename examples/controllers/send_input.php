<?php

class send_input {
	
	function send_text( $text )
	{
		
		$ajax = CJAX::getInstance();
		
		$ajax->success("This message was sent: $text",30);
	}
	
	function send_checkbox( $check )
	{
		$ajax = CJAX::getInstance();
		
		if($check) {
			$ajax->success("Is checked..");
		} else {
			$ajax->warning("Is not checked..");
		}
	}
}