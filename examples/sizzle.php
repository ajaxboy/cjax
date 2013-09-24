<?php
require_once "ajax.php";
$ajax = ajax();

//$ajax->config->sizzle = true; 

$ajax->click(".bt", $ajax->call("ajax.php?click_ajax_request/click_button/"));

$ajax->click(".buttons", $ajax->call("ajax.php?click_ajax_request/click_button/|data.button_number|/"));
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">

<title>Selectors</title>
<?php echo $ajax->init();?>
</head>
<body>
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
<a href="http://cjax.sourceforge.net/examples/">Demos</a> &nbsp;&#8250;&nbsp;
Selectors
</td>
<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


<br />
Cjax 5.7+ lets you use well known libraries such as sizzle or Jquery to use their selector engine. Meaning that you can use wild card css selectors or
class selectors to bind elements with cjax.
<br /><br />
To enable selectors in your cjax installation - you must first enable sizzle. Go to your cjax config file and enable sizzle by setting the sizzle setting = true. If you are using Jquery,
you do not need to do this step, since Jquery already includes sizzle. All you have to do is include Jquery.
<br /><br />
You may also enable sizzle for a single page, by just doing this:
<?php
echo $ajax->code("
\$ajax->config->sizzle = true;
");
?>


<h3>Examples</h3>
<h2>Multiple Selections</h2>
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
<h2>Pass values in URL</h2>

You can pass data through the url by using the data keyword. In your HTML element you add an attribute item prefixed by "data-", the word following the data-
prefix will be the keyword you need to pass in the url by passing data.[Keyword Here] sorounded by pipe bars.
<br />
<br />

<input type='button' class='buttons' data-button_number='This is button 1' value='Click this button to make an ajax request'>
<input type='button' class='buttons' data-button_number='This is button 2' value='Click this button to make an ajax request'>
<input type='button' class='buttons' data-button_number='This is button 3' value='Click this button to make an ajax request'>
<?php
echo $ajax->code("
<?php

\$ajax->click(\".buttons\",\$ajax->call(\"ajax.php?click_ajax_request/click_button/|data.button_number|\"));

?>

<!-- HTML -->
<input type='button' class='buttons' data-button_number='This is button #1' value='Click this button to make an ajax request'>
<input type='button' class='buttons' data-button_number='This is button #2' value='Click this button to make an ajax request'>
<input type='button' class='buttons' data-button_number='This is button #3' value='Click this button to make an ajax request'>
", false);
?>

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