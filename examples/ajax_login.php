<?php

require_once 'ajax.php';

//forces $ajax->form() to fire AFTER the overlay has fully loaded and shown
//Makes sure that $ajax->exec/$ajax->form() is triggerd after the overlay is created by being attached to the actual overlay
$overlay = $ajax->overlay('resources/html/login.html');


$overlay->click('button1', $ajax->form('ajax.php?ajax_login/handler'));


$ajax->click('a_login', $overlay);


$code = $ajax->code("
//Initial Code

//Loads file resources/html/login.html onto the overlay
//Adds event listerner to button1 so when you click it
//it submit/posts the form to url 'ajax.php?ajax_login/handler'

\$overlay = \$ajax->overlay('resources/html/login.html');

\$overlay->click('#button1', \$ajax->form('ajax.php?ajax_login/handler'));

//assigns the overlay to the click event on achor element 'a_login'
//so when you click the link the overlay is displayed
\$ajax->click('#a_login', \$overlay);


//Controller

use CJAX\\Core\\CJAX;
class ajax_login {
	
	function handler(\$username, \$password){
		\$ajax = CJAX::getInstance();
		
		if(!\$username) {
			return  \$ajax->err = 'Enter your username.';
		}
		if(!\$password) {
			return \$ajax->err = 'Enter your password.';
		}
		
		\$ajax->success(\"Hello \$username, You haved successfully logged in.\");
		
		\$ajax->flush('#a_login'); //clear previous click events from element
		\$ajax->overlay();//clear overlay from the screen
		
		\$ajax->login_div = \"Hello \$username!, Logout Now..\"; 
		\$ajax->insert('#login_div','#a_login',true); // places the login button inside the login_div container
		
		\$ajax->click('#a_login', \$ajax->call('ajax.php?ajax_login/logout')); // adds the ajax link to a_login
		\$ajax->a_login = 'Logout';  //changes the login text to logout
		
	}
	
	function logout(){
		\$ajax = CJAX::getInstance();
		\$ajax->flush('#a_login'); //clear previous click events from element
		\$ajax->success(\"You haved logged out.\");
		\$ajax->a_login = 'Login'; //changes the text back to 'login'
		\$ajax->insert('#login_now_area','#a_login'); //moves the logout link to the bottom
		\$ajax->login_div = 'Login Again..'; //updates the login_div container text
		
		//This is exactly the example as the first line in the Initial code but with different syntax
		\$overlay = \$ajax->overlay('resources/html/login.html');
		\$link = \$ajax->exec('button1',\$ajax->form('ajax.php?ajax_login/handler','form1'));
		\$overlay->callback(\$link);
		\$ajax->click('a_login', \$overlay);
	}
}
");

$ajax->click('code', $ajax->overlayContent($code,array('width'=> '1000px','top'=>50)));
?>
<html>
<head>
<title>Ajax Login | Ajax Framework</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<?php echo $ajax->init();?>
</head>
<style>
#login_bar {
	height: 60px;
	width: 100%;
	font-family: verdana;
}

#login_div {
	width: 100%;
	float: right;
	font-size: 36px;
	position:relative;
}

#a_login  {
	 font-size: 20px;
}
</style>
<body>
<h2>Ajax Login</h2>
<br />
<div id='login_bar'>
	<div id='login_div'></div>
</div>
<h3>Note</h3>
<br />
Creating functinality using generic Cjax API.
<br /><br />
Demonstrates how to launch a login screen while manipuilating elements. This is only a generic "flow" example and it is not a complete login script.
The showcase of the ajax functionality more than anything.  This sample also demonstrates how to do some element manipulation in the backend.
On this example elements are being manipulated and re-used.
<br />
<br />
<div id='login_now_area'>
<a id='a_login' href='#'>Login</a>
</div>
<br />
<a id='code' href="#">View Code Used</a>
<br />

</body>
</html>