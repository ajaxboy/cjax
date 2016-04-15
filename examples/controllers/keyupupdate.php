<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class KeyupUpdate extends AJAXController{
	
	public function update($text){	
		$this->ajax->document('title', $text);	
		$this->ajax->div_response = $text;
	}
}