<?php

class keyup_update {
	
	function update($text)
	{
		$ajax = ajax();
		
		$ajax->document('title', $text);
		
		$ajax->div_response = $text;
	}
}