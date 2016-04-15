<?php

namespace Examples\Controllers;
use CJAX\Core\CJAX;

class Alert{
	
	public function fire_alert($message){		
		$ajax = CJAX::getInstance();		
		$ajax->alert($message);
	}
}