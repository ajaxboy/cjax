<?php

namespace Controllers;
use CJAX\Core\AJAXController;

class Test extends AJAXController{
	
	public function test($a = null, $b = null){
		echo "Ajax View... $a $b";
	}
}