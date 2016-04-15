<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class AjaxRequest extends AJAXController{
	
	public function onTheFly(){		

		$this->ajax->update('container1','This text was updated through ajax...');
		
		$this->ajax->wait(2);
		
		$this->ajax->update('container2','This text too...');
		
		$this->ajax->wait(3);
		
		$this->ajax->update('container2','And this....');
		
		$this->ajax->wait(4);
		
		$this->ajax->update('container2','Updated!....');
	}
}