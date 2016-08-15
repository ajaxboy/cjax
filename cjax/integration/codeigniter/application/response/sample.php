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
 * 1. create a new file inside application/response directory 
 *  name that file sample.php
 *  
 *  so far you have response/sample.php
 * 
 * 2. You will need to have a class inside this file and the class should be named Sample.
 * 	If you experience conflict with class name you start the class with an undercore "_".
 *  *  
 *  so far you have in response/sample.php
 *  
 *  class Sample {
 *  
 *  }
 * 
 * 3.  create a function and name it whatever you like, in this example we will name it "test"
 * 
 * so far you have
 * 
 *  class Sample {
 *  
 *  	function test()
 *  	{
 *  
 *  	}
 * 	}
 * 
 * 4. request  URL should be:
 *  ajax.php?sample/test
 *  
 *  Sending parameters:
 *  
 *  You can send as many aparameters in the url: (a,b,c,d,e,f)
 *  
 *  Sample  URL with parameters
 *  In this url we'll send 3 parameters:
 *   ajax.php?sample/test/test1/test2/test3  ( and so on, d,e,f, etc)
 *  
 *  So far you have:
 *  
 *  class Sample  {
 *	
 *		function test($a, $b , $c)
 *		{
 *			echo "$a $b, $c";
 *		}
 *		
 *   }
 *   
 *   Using Jquery:
 *   $.get("ajax.php?sample/test/test1/test2/test3", function(response){
 *   
 *   	alert(response);
 *   });
 *
 */

class Sample extends CI_Controller {
	
	/**
	 * Funtion snario #1
	 * ajax.php?c
	 * @param unknown_type $a
	 * @param unknown_type $b
	 * @param unknown_type $c
	 */
	function test($a,$b,$c)
	{
		
		echo "$a $b, $c";
	}
	
	/**
	* As response, you will get a json object.
	 */
	function test2()
	{
		$data = array(1,2,3,4,5);
		
		return $data;
	}

}

