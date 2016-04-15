<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class Calc extends AJAXController{
	
	public function math($action, $buffer){
		$operators_signs = ['[plus]','p','m','x','d'];
		$operators = ['p','+','-','*','/'];
		
		$pre_buffer = $buffer;
		$buffer = $this->ajax->buffer = $buffer.$action;
		$buffer = str_replace($operators_signs, $operators, $buffer);
		
		switch($action) {
			case 'm'://minus
			case 'p'://plus
			case 'd'://divide
			case 'x'://times
			    break;
			case 'c': //clear
				$this->ajax->buffer = null;
				$this->ajax->result = 0;
			    break;
			case 'e': //equal
				$buffer = rtrim($buffer,"e=+-\/*");
				
				eval("\$action = ({$buffer});");
				
				$this->ajax->result = $action;
				$this->ajax->buffer = $action;
			    break;
			default: //number
				
				//get previous operator used, if not then keep putting numbers together
				$prev = rtrim($pre_buffer, $action);
				$prev = preg_replace("/[0-9]/", '', $prev);
				if(!in_array($prev, $operators_signs)) {
					$action = $buffer;
				} 
                else {
					$action =  preg_replace("/.+[^0-9]/", '', $buffer);
				}
				$this->ajax->result = $action;
		
		}
	}
}