<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


//forces $ajax->form() to fire AFTER the overlay has fully loaded and shown
//Makes sure that $ajax->Exec/$ajax->form() is triggerd after the overlay is created by being attached to the actual overlay


$ajax->click('a_login', $ajax->overlay('resources/html/login.html'));


$ajax->on('overlayPop', $ajax->click('button1', $ajax->form('ajax.php?ajax_login/handler')));


?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
	<title>Ajax Login | Ajax Framework</title>
	<?php echo $ajax->init(false);?>

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
</head>
<body>
<header>
	<div style='padding: 15px;'>
		<a href='http://cjax.sourceforge.net'><img src='http://cjax.sourceforge.net/media/logo.png' border=0/></a>
	</div>
</header>
<!-- START NAVIGATION -->
<div id="nav"><div id="nav_inner"></div></div>
<div id="nav2"><a name="top">&nbsp;</a></div>
<div id="masthead">
	<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
		<tr>
			<td><h1>Cjax Framework</h1></td>
			<td id="breadcrumb_right"><a href="#">Demos</a></td>
		</tr>
	</table>
</div>
<!-- END NAVIGATION -->



<!-- START BREADCRUMB -->
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
	<tr>
		<td id="breadcrumb">
			<a href="http://cjax.sourceforge.net/">Project Home</a> &nbsp;&#8250;&nbsp;
			<a href="./">Demos</a> &nbsp;&#8250;&nbsp;
			Ajax Login
		</td>
		<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
	</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


	<!-- Text -->
	Creating functinality using generic Cjax API.
	<br /><br />
	Demonstrates how to launch a login screen while manipuilating elements. This is only a generic "flow" example and it is not a complete login script.
	The showcase of the ajax functionality more than anything.  This sample also demonstrates how to do some element manipulation in the backend.
	On this example elements are being manipulated and re-used.
	<br />


	<br />

	<h3>Examples</h3>


	<!-- Code Used -->

	<?php


	echo $ajax->code("
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
class ajax_login {

	function handler(\$username, \$password)
	{
		\$ajax = ajax();

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

	function logout()
	{
		\$ajax = ajax();
		\$ajax->flush('#a_login'); //clear previous click events from element
		\$ajax->success(\"You haved logged out.\");
		\$ajax->a_login = 'Login'; //changes the text back to 'login'
		\$ajax->insert('#login_now_area','#a_login'); //moves the logout link to the bottom
		\$ajax->login_div = 'Login Again..'; //updates the login_div container text

		//This is exactly the example as the first line in the Initial code but with different syntax
		\$overlay = \$ajax->overlay('resources/html/login.html');
		\$link = \$ajax->click('button1',\$ajax->form('ajax.php?ajax_login/handler','form1'));
		\$overlay->callback(\$link);
		\$ajax->click('a_login', \$overlay);
	}
}
", true , true);

	?>

	<!-- HTML -->
	<br />
	<p>
	<div id='login_now_area'>
		<a id='a_login' href='#'>Login</a>
	</div>
	</p>
	<br />
	<p>
		<div id="login_div"></div>
	</p>
	<a id='code' href="#">View Code Used</a>
	<br />

	<br />
</div>
<!-- END CONTENT -->

<div id="myfooter">
	<p>
		Previous Topic:&nbsp;&nbsp;<a href="#">Previous Class</a>
		&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;
		<a href="#top">Top of Page</a>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;
		<a href="http://cjax.sourceforge.net/examples">Demos Home</a>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;
		<!-- Next Topic:&nbsp;&nbsp;<a href="#">Next Class</a> -->
	</p>
	<p>
		<a href="http://codeigniter.com">CodeIgniter</a> &nbsp;&middot;&nbsp; Copyright &#169; 2006 - 2012 &nbsp;&middot;&nbsp;
		<a href="http://cjax.sourceforge.net/">Cjax</a>
	</p>
</div>

</body>
</html>