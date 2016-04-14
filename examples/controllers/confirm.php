<?php

use CJAX\Core\CJAX;

class Confirm{
	
	public function confirm_action(){		
		$ajax = CJAX::getInstance();		
		$ajax->success("Do something..");
	}
	
}