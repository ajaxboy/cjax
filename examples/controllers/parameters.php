<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class Parameters extends AJAXController{
	
	public function sendParams($a, $b, $c, $d){
		$params = "
		params a: $a\n
		params b: $b\n
		params c: $c\n
		params d: $d\n
		";
		$this->ajax->alert($params);
		
		$this->ajax->update('params',$params);
	}
}