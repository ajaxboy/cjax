<?php


class click_ajax_request {
	
	function click_button($message)
	{
		$ajax = ajax();
		
		$ajax->success("You clicked the button.. $message");
	}
}