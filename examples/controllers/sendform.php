<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class SendForm extends AJAXController{
	
	public function validate(){
		$this->ajax->info("Validation Approved.");
	}
	
	public function submitForm($form_fields){	
		$this->ajax->alert("Server Says....\n\nFields submitted: \n".print_r($form_fields,1));
	}
}