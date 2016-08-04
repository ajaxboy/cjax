<?php

class send_form {
	
	function validate()
	{
		$ajax = ajax();
		
		$ajax->info("Validation Approved.");
	}
	
	function submit_form($form_fields)
	{
		$ajax = ajax();
		
		$ajax->alert("Server Says....\n\nFields submitted: \n".print_r($form_fields,1));
	}
}