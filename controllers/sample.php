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
 * 1. create a new file inside controllers directory 
 *  name that file sample.php
 *  
 *  so far you have controllers/sample.php
 * 
 * 2. You will need to have a class inside this file and the class should be named controller_sample.
 *  (or controller_(whatever your controller name is)
 *  
 *  so far you have in controllers/sample.php
 *  
 *  class controller_sample {
 *  
 *  }
 * 
 * 3.  create a function and name it whatever you like, in this example we will name it "test"
 * 
 * so far you have
 * 
 *  class controller_sample {
 *  
 *  	function test()
 *  	{
 *  
 *  	}
 * 	}
 * 4. request  URL should be:
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
 *  class controller_sample  {
 *	
 *		function test($a, $b , $c)
 *		{
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

class Sample {
	
	function test()
	{
		$ajax = CJAX::getInstance();
		$ajax->success("Testing controller <b>sample</b>.  Works ok.");
	}

}

