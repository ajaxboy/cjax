<?php

class change_value {
	
	function text($element_id,$current_value)
	{
		$ajax = ajax();
		
		$ajax->text1 = "Random number..".rand(100,1000);
	}
	
	
	function check($element_id,$current_value)
	{
		$ajax = ajax();
		
		if($current_value) {
			$ajax->check1 = false;
		} else {
			$ajax->check1 = true;
		}
	}
	
	function div($num = 0)
	{
		$ajax = ajax();
		
		$text = array();
		
	//Some random strings .......
		$text[] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. ";
		$text[] = "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown ";
		$text[] = "printer took a galley of type and scrambled it to make a type";
		$text[] = "specimen book. It has survived not only five centuries, but also the leap into electronic";
		$text[] = "typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of ";
		$text[] = "Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
		$text[] = "it is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout."; 
		$text[] = "The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using";
		$text[] = "'Content here, content here', making it look like readable English. Many desktop publishing packages and ";
		$text[] = "web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many";
		$text[] = "web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).";
		
		$ajax->DIV_1 = $text[rand(0, count($text)-1)];
	}
}