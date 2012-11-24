<?php

class recursive_ajax {
	
	function call($counter, $count)
	{
		$counter = (int) $counter;
		$count = (int) $count;
		
		$counter++;
		
		$ajax = ajax();
		
		if($count > 100) {
			$ajax->focus('count');
			$ajax->warning("Too many requests can add overhead to our servers, please try reducing the number.", 5);
			$ajax->count = 30;
			return;
		}
		
		//update div
		$ajax->div_counter = "Call# $counter of $count..";
		
		if($counter>=$count) {
			$ajax->div_counter ="$counter recursive AJAX requests were made.";
		} else {
		
			//fire call
			$ajax->call("ajax.php?recursive_ajax/call/$counter/$count");
		}

	}
	
}