<?php

class search {
	
	
	function string($string)
	{
		// Fill up array with some data
		$a[]="Anna";
		$a[]="Amanda";
		$a[]="Amelia";
		$a[]="Armando";
		$a[]="Brittany";
		$a[]="Bob";
		$a[]="Bill";
		$a[]="Cinderella";
		$a[]="Cindy";
		$a[]="Carlos";
		$a[]="Diana";
		$a[]="Doris";
		$a[]="Eva";
		$a[]="Eve";
		$a[]="Evita";
		$a[]="Fiona";
		$a[]="Gunda";
		$a[]="Hege";
		$a[]="Inga";
		$a[]="Johanna";
		$a[]="Kitty";
		$a[]="Linda";
		$a[]="Nina";
		$a[]="Ophelia";
		$a[]="Petunia";
		$a[]="Raquel";
		$a[]="Sunniva";
		$a[]="Tove";
		$a[]="Unni";
		$a[]="Violet";
		$a[]="Liza";
		$a[]="Liz";
		$a[]="Elizabeth";
		$a[]="Ellen";
		$a[]="Wenche";
		$a[]="Vicky";
		$a[]="Quinton";
		$a[]="Yancy";
		$a[]="Yakecan";
		
		
		$out = array();
		
		foreach($a as $v) {
			if(substr(strtolower($v), 0, strlen($string)) == strtolower($string)) {
				$out[] = $v;
			}
		}
		
		die('<pre>'.print_r($out,1).'<pre>');
		
	}
	
}