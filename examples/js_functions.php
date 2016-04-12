<?php

//core file, reference..
require_once "ajax.php";


	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">

<title>JS Functions</title>
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
Js Functions
</td>
<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


<br />
In Cjax, you can control most HTML objects/elements with the $ajax object. You can also control JavaScript Objects and functions of other scrips.
Cjax allows to access your existing scripts, and existing JavasScript.
<br /><br />

If you have written some custom JavaScript functions or you are using a third party script, that you must run or interact with, 
Cjax makes this easy by giving you control and access over them in PHP.
<br /><br />

Cjax will allow you to execute unlimited JavaScript functions. You can reach all functions you need, you have a full bridge between PHP and JavaScript.

<h3>Examples</h3>

Lets say you have a custom Js Function/or any function, and you would like to execute it. Cjax will allow you to execute it, even pass paramenters into your function.
<?php echo $ajax->code("
//your custom function
<script>
	
	function  my_function(param1, param2) 
	{
		
		//your custom code
		alert(param1+ ' ' +param2);
		
	}

</script>
");?>

Here is how you access your function. Cjax makes it seemsless, as if you were executing a PHP function, but it reaches all the way to your JS function.
<?php echo $ajax->code("
\$param1 = \"Hello\";
\$param2 = \"World\";

\$ajax->my_function(\$param1, \$param2);
");?>

<br /><br />



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
