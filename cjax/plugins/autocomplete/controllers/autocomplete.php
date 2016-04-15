<?php

namespace CJAX\Plugins\Autocomplete\Controllers;
use CJAX\Core\AJAXController;

class Autocomplete extends AJAXController{
	
    protected function generateOutput($search, array $data = []){
        $output = [];
        foreach($data as $value){
			if(substr(strtolower($value), 0, strlen($search)) == strtolower($search)){
				$output[] = $value;
			}
        }
        return $output;
    }
}