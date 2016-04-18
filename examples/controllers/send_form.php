<?php

use CJAX\Core\CJAX;

class controller_send_form {
	
	function validate()
	{
		$ajax = CJAX::getInstance();
		
		$ajax->info("Validation Approved.");
	}
	
	function submit_form($form_fields)
	{
		$ajax = CJAX::getInstance();
		
		$ajax->alert("Server Says....\n\nFields submitted: \n".print_r($form_fields,1));
	}
}