<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class Alert extends AJAXController{
	
	public function fireAlert($message){			
		$this->ajax->alert($message);
	}
}