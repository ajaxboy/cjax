<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class ValidationUploader extends AJAXController{
	
	public function pre(){
		die('pre!');
	}
	
	public function post(){
		die('post!');
	}
}