<?php
/**
 * How to use:
 * 
 * Rename this file to auth.php,
 * implement your validation code inside validate function below.
 * 
 * return true, the request goes through.
 * return false, the request will not go through.
 * 
 */

class AjaxAuth {
	
	/*
	 * This function aims at covering the user authentification, 
	 * place here your custom authentification code to validate user's session.
	 * 
	 * Here you may add custom validation that validates the session or each request
	 * 
	 * if you return false the request will not proceed.
	 * 
	 * If the authentication is valid or do not require authentication, return true.
	 */
	function validate($controller = null, $function = null, $args = array())
	{
		
		return true;
	}
	
	/*
	 * 
	 * This function is ran if the validation above is unsuccessful.
	 */
	function authError()
	{
		$ajax = ajax();
		
		$ajax->warning("Could no Authenticate. Please re-login");
	}
	
	/*
	 * Routing Handler
	 * 
	 * Optonal Routing interception
	 * 
	 * You may route the ajax request to other custom destination here.
	 * 
	 * If your application offers some sort of addons or plugins system that handles ajax,
	 * here is where you can intercept these requests and configure code your custom route to your application's
	 * addons/plugins system.
	 * 
	 * if you return true, the request will be intercepted and will not proceed to the controller that was meant to.
	 * 
	 * If you return an array or an object it will print a json string and will not proceed to the controller that was meant to.
	 * 
	 * If you return false, the request will proceed as normal to the destination controller.
	 * 
	 * $controller string
	 * $function strnig
	 * $args array
	 * $requesObj object or null.  If a cotroller exists for this request the controller object is passed.
	 */
	function intercept($controller = null, $function = null , $args = array(), $requestObj = null)
	{
		return false;
	}
	
}