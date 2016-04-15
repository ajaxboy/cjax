<?php

namespace Examples\Controllers;
use CJAX\Core\CJAX;

class Keyup_update{
	
	public function update($text){
		$ajax = CJAX::getInstance();
		
		$ajax->document('title', $text);
		
		$ajax->div_response = $text;
	}
}