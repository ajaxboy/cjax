<?php

use CJAX\Core\CJAX;

class Send_form{
	
	public function validate(){
		$ajax = CJAX::getInstance();		
		$ajax->info("Validation Approved.");
	}
	
	public function submit_form($form_fields){
		$ajax = CJAX::getInstance();		
		$ajax->alert("Server Says....\n\nFields submitted: \n".print_r($form_fields,1));
	}
}