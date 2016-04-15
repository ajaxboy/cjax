<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class Dropdown extends AJAXController{
	
	public function propagate($selected){
		$data = [];
			
		switch($selected) {
			case 'options':
				$data[] = "Option 1";
				$data[] = "Option 2";
				$data[] = "Option 3";
				$data[] = "Option 4";
				$data[] = "Option 5";
			break;
			case 'states':
				
				$data[] = "Texas";
				$data[] = "Florida";
				$data[] = "New York";
				$data[] = "California";
				$data[] = "New Mexico";
				$data[] = "Maine";
			break;
		}
		
		//setcookie('data','testesttest',time()+1000*10);
		$this->ajax->select('dropdown2', $data);
		
	}
	
	/**
	 * this function is almost identical to the function above, except it changes the dropdown into 
	 * a textbox if nothing is selected as a mode of input
	 * 
	 * @param $selected
	 */
	public function propagateAllowInput($selected){
		$data = [];

		switch($selected) {
			case 'options':
				$data[] = "Option 1";
				$data[] = "Option 2";
				$data[] = "Option 3";
				$data[] = "Option 4";
				$data[] = "Option 5";
			break;
			case 'states':			
				$data[] = "Texas";
				$data[] = "Florida";
				$data[] = "New York";
				$data[] = "California";
				$data[] = "New Mexico";
				$data[] = "Maine";
			break;
		}
		
		$this->ajax->select('dropdown2', $data, 'Enter Something', true);		
	}
}