<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class Post extends AJAXController{
		
	public function postSample(){
		echo 'Response is<pre>'.print_r($_POST,1).'</pre>';
	}
}