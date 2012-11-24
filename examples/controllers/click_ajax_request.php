<?php

class controller_click_ajax_request {
	
	function click_button($message)
	{
		$ajax = ajax();
		
		$ajax->success("You clicked the button.. $message");
		
	}
}