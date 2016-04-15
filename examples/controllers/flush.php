<?php

namespace Examples\Controllers;
use CJAX\Core\CJAX;

class Flush{
	
	public function flush_element(){
		$ajax = CJAX::getInstance();
		
		$ajax->flush('#link1');
		
		$ajax->info("Element has been flushed.. if you click it nothing will happen.",5);
		
	}
	
}