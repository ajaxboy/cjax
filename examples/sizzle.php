<?php
require_once "ajax.php";
$ajax = ajax();

//$ajax->config->sizzle = true; 

$ajax->click(".bt", $ajax->call("ajax.php?click_ajax_request/click_button/"));

$ajax->click(".buttons", $ajax->call("ajax.php?click_ajax_request/click_button/|data.button_number|/"));
?>
<!doctype html>
<head>
<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
<title>Selectors</title>
<?php echo $ajax->init(false);?>
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
Selectors
</td>
<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">

<h3>Elements Queries, Selector</w></h3>
<p class="note">
	As of <span class="req">Cjax 5.9+</span> the advanced selector engine is enabled by default.
	You don't longer need to enable this setting, as it already enabled.
</p>
<p>
	<span class="req">Cjax 5.7+</span> includes a selector engine that can select complex queries, as these of known libraries.
	You can use wildcard selections specifying a class name or more complex selections.
</p>

<h3>Examples</h3>
<h2 id="data">Multiple Selections</h2>
You can add multiple buttons or elements in your HTML page, and add the same class ".bt", or any class you specify, and cjax will use these selectors to 
bind your elements with the assigned actions.
<br />
<br />

<input type='button' class='bt' value='Click this button to make an ajax request #1'>
<br />
<input type='button' class='bt' value='Click this button to make an ajax request #2'>
<br />
<input type='button' class='bt' value='Click this button to make an ajax request #3'>
<?php
echo $ajax->code("
<?php

\$ajax->click(\".bt\",\$ajax->call(\"ajax.php?click_ajax_request/click_button\"));

?>

<!-- HTML -->
<input type='button' class='bt' value='Click this button to make an ajax request'>
<input type='button' class='bt' value='Click this button to make an ajax request'>
<input type='button' class='bt' value='Click this button to make an ajax request'>
", false);
?>

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