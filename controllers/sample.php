<?php

/**
 * HOW TO USE AJAX CONTROLLERS
 * 
 * This file is intended to be a sample to create your own controllers
 * 
 * there are 4 steps to follow when creating new controllers
 * 
 * Lets create a controller named "sample" 
 * 
 * 1. Create a new file inside controllers directory 
 *  name that file sample.php
 *  
 *  so far you have controllers/sample.php
 * 
 * 2. You will need to have a class inside this file and the class should be named Sample.
 *  
 *  so far you have in controllers/sample.php
 *  
 *  class Sample{
 *  
 *  }
 * 
 * 3. Declare namespace for your controller class(ie. Controllers), and make your controller extend from base AJAXController.
 * 
 *  so far you have in controllers/sample.php
 * 
 *  namespace Controllers;
 *  use CJAX\Core\AJAXController;
 *
 *  class Sample{
 *  
 *  }
 * 
 * 4.  create a function and name it whatever you like, in this example we will name it "test"
 * 
 * so far you have
 * 
 *  namespace Controllers;
 *  use CJAX\Core\AJAXController;
 *
 *  class Sample extends AJAXController{
 *  
 *  	public function test(){
 *  
 *  	}
 * 	}
 *
 * 5. request  URL should be:
 *  ajax.php?controller=sample&function=test
 *  
 *  Sending parameters:
 *  
 *  You can send as many as 6 arguments/parameters. (a,b,c,d,e,f)
 *  
 *  Sample  URL with parameters
 *  In this url we'll send 3 parameters:
 *   ajax.php?controller=sample&function=test&a=test1&b=test2&c=test3  ( and so on, d,e,f, etc)
 *  
 *  So far you have:
 *  
 *  namespace Controllers;
 *  use CJAX\Core\AJAXController;  
 *
 *  class Sample extends AJAXController{
 *	
 *		public function test($a, $b , $c){
 *			echo "$a $b, $c";
 *		}
 *		
 *   }
 *   
 *   
 *   Using Jquery:
 *   $.get("ajax.php?controller=sample&function=test&a=test1&b=test2&c=test3", function(response){
 *   
 *   	alert(response);
 *   });
 *
 */

namespace Controllers;
use CJAX\Core\AJAXController;

class Sample extends AJAXController{
	
	public function test(){
		$this->ajax->success("Testing controller <b>sample</b>.  Works ok.");
	}

}
