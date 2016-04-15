/**
 * Example Plugin 1.0
 * 
 * There are  files included in this package but this is the only file required. The other files
 * only offer additional information and prospective of the scope of tools you can use to further develop.
 * 
 */

/**
 * This plugin is for demonstration purpose only.
 * Do see the comments in the code for some samples of API and methods available.
 * 
 */
function exampleplugin(arg1, arg2) 
{
	
	//alerts data set in the contructors $ajax->ExamplePlugin();
	//alert(arg1.test1);   
	//alert(arg1.test2); 
	
	//see plugins's api documentation to see all the available functions and variables available.
	
	/**
	 * The following statement shows several things:
	 * How to request ajax  to the plugin itself, usage or parameters
	 * 
	 * the ":json" part of the url tells ajax to return  a json object.
	 * 
	 * 
	 */
	this.call(this.ajaxFile+'?ExamplePlugin:json/docs', function(response) {
		
		//alert(response.test1);
		//alert(response.test2);
	});

	
	//You may access the parameters the  same order they were sent.
	//arg1.test1;
	
	//arg1.test2
	
	//arg2 
	
	/**
	 * this.prevent()
	 * 
	 * You can intercept other ajax APIs executed after the plugin was called.
	 * Using  the method this.prevent();
	 * 
	 * this.prevent() will stop other APIs, and returns them into one function which you may
	 * use at your own pase.
	 * 
	 * Example:  
	 * 
	 * Lets say in your controller you use
	 * 
	 * $ajax->exec('button', $ajax->form('url','form_id'));
	 * 
	 * The above Api will submit a form attached to a button,
	 * 
	 * but lets say you want to do something else before the form is submitted through ajax,
	 * this is a case where you can use this method.
	 * 
	 * if  you  use prevent(), that Api will be intercepted and not executed.
	 * Then it gives you the controll of execution of that API, in the returned value.
	 * Which you may execute.
	 * 
	 * var Api = this.prevent();
	 * 
	 * setTimeout(function() {
	 * 		Api();
	 * },5000);
	 * you may prevent more than one APIs by passing a number in this 
	 * function  this.prevent(3); - will prevent 3 APIs and they all are returned back to you.
	 * 
	 * 
	 */
	//this.prevent()
	
	//sample of importing javascript into the scope 
	this.import('http://cjax.googlecode.com/svn/trunk/_extra/test_unit/plugins/js/test.js', function() {
		console.log('File was imported.');
	});
	//sample of importing css to the page 
	this.import('http://cjax.googlecode.com/svn/trunk/_extra/test_unit/plugins/css/test.css');
	
	//sample of preventing the next  API $ajax->info()
	

	//CJAX.preventDefault();
	
	//setTimeout('func2()',20000);
	
	//console.log('File base:', this.base);
	//console.log('This file:', this.file);
	//console.log('Paramters Passed:', a, b ,c);
}