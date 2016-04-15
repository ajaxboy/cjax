<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class Confirm extends AJAXController{
	
	public function confirmAction(){		
		$this->ajax->success("Do something..");
	}
	
}