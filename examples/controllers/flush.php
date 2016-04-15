<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class Flush extends AJAXController{
	
	public function flushElement(){
		
		$this->ajax->flush('#link1');
		
		$this->ajax->info("Element has been flushed.. if you click it nothing will happen.",5);
		
	}
	
}