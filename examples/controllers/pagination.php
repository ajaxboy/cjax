<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class Pagination extends AJAXController{
	
	public function show($page = 0){
		$total_number_of_items = 50;
		$items_per_page = 10;
		
		//generate some dummy data
		$items = ['Jonh','Tom','Lily','Carlos','Victor','Linda'];
		for($i = ($page * $items_per_page); $i < $total_number_of_items; $i++) {
			shuffle($items);
			$data[] = $items;
		}
		
		die("<pre>".print_r($data,1));		
	}
}