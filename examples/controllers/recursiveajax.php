<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class RecursiveAJAX extends AJAXController{
	
	public function call($counter, $count){
		$counter = (int)$counter;
		$count = (int)$count;
		
		$counter++;
		
		if($count > 100){
			$this->ajax->focus('count');
			$this->ajax->warning("Too many requests can add overhead to our servers, please try reducing the number.", 5);
			$this->ajax->count = 30;
			return;
		}
		
		//update div
		$this->ajax->div_counter = "Call# $counter of $count..";
		
		if($counter>=$count){
			$this->ajax->div_counter ="$counter recursive AJAX requests were made.";
		} 
        else{		
			//fire call
			$this->ajax->call("ajax.php?recursiveajax/call/$counter/$count");
		}

	}
	
}