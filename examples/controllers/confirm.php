<?php

use CJAX\Core\CJAX;

class controller_confirm {
	
	function confirm_action()
	{
		
		$ajax = CJAX::getInstance();
		
		$ajax->success("Do something..");
	}
	
}