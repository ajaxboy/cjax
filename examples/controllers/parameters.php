<?php

namespace Examples\Controllers;
use CJAX\Core\CJAX;

class Parameters{
	
	public function send_params($a, $b, $c, $d){
		$ajax = CJAX::getInstance();
		
		$params = "
		params a: $a\n
		params b: $b\n
		params c: $c\n
		params d: $d\n
		";
		$ajax->alert($params);
		
		$ajax->update('params',$params);
	}
}