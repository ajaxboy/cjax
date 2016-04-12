<?php

use CJAX\Core\CJAX;

class controller_keyup_update {
	
	function update($text)
	{
		$ajax = CJAX::getInstance();
		
		$ajax->document('title', $text);
		
		$ajax->div_response = $text;
	}
}