<?php

class confirm {
	
	function confirm_action()
	{
		
		$ajax = CJAX::getInstance();
		
		$ajax->success("Do something..");
	}
	
}