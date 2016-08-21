<?php

//core file, reference..
require_once "ajax.php";

$ajax = ajax();


	
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

	<div style="margin: 20px;"> <div style="font-size: 12px;padding: 5px;">Project development is new to github. Give us a <span id="star">star</span>.</div>
		<iframe id='istar' src="https://ghbtns.com/github-btn.html?user=ajaxboy&repo=cjax&type=star&count=true" frameborder="0" scrolling="0" width="170px" height="20px"></iframe>
		<iframe src="https://ghbtns.com/github-btn.html?user=ajaxboy&repo=cjax&type=watch&count=true&v=2" frameborder="0" scrolling="0" width="170px" height="20px"></iframe>
	</div>

<h3>Access Your JS Functions</h3>

<p>
In Cjax, you can control most HTML objects/elements with the $ajax object. You can also control JavaScript Objects and functions of other scrips.
Cjax allows to access your existing JavasScript very easily and elegantly.
</p>

<p>
If you have written some custom JavaScript functions or you are using a third party script, that you need to run or interact with,
Cjax lets you access them right from the backend.
</p>

<h3>Examples</h3>

<p>
You have a custom JavaScript function, and you would like to execute it. Here is how.
</p>

<p>
Here is how you access your function. Cjax makes it seemsless.
</p>
<?php echo $ajax->code("

\$ajax->myCustomFunction();
");?>

<?php echo $ajax->code("
//your custom function
<script>

	function myCustomFunction()
	{
		//your javascript code..
	}

</script>
",'JavaScript');?>

<p>
	You can also pass parameters to your functions if you need to. Cjax will allow you to pass arrays, and strings.
	You will receive them in your JavaScript as a Json object or a string.
</p>

<?php echo $ajax->code("

\$ajax->myCustomFunction(array('test','test','test'), 'test');
");?>

<?php echo $ajax->code("
//your custom function
<script>

	function myCustomFunction(data, data2)
	{
		console.log(data, data2);

		//the parameters that you passed in php, have become available in your JavaScript function.
	}

</script>
",'JavaScript');?>

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
