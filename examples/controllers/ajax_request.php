<?php

class AjaxRequest {
	
	function on_the_fly()
	{
		$ajax = ajax();
		
		$ajax->update('container1','This text was updated through ajax...');
		
		$ajax->wait(2);
		
		$ajax->update('container2','This text too...');
		
		$ajax->wait(3);
		
		$ajax->update('container2','And this....');
		
		$ajax->wait(4);
		
		$ajax->update('container2','Updated!....');
	}
}