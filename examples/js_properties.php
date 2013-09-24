<?php

//core file, reference..
require_once "ajax.php";

$ajax = ajax();


	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">

<title>JS Properties</title>
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
Main Property
</td>
<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


<br />
In Cjax, you can control most HTML objects/elements with the $ajax object. You can also control JavaScript Objects and functions of other scrips.
Cjax allows not only to control the main properties of an object/element, but it allows you to controll All properies of that element, including
but not limited to style, DOM, colors, fonts, shapes, and everything in between.
<br /><br />

Property changing in Cjax is very simple, and all changes accumulate. If you apply properties to an element, and apply some more, all will accumulate not overwrite.
<br />


<h3>Examples</h3>

Lets say you have a div with id "my_div" on your HTML page. You want to change the width and height of this div. Here is how you'd do it with Cjax.
<?php echo $ajax->code("
\$ajax->my_div = array('width' => 200,'height'=> 100);
");?>
<br /><br />

To update the style property of an element follow the same logic as before:
<?php echo $ajax->code("
\$ajax->my_div = array(
	'style' => array(
		'width' => '200px',
		'height' => '100px',
		'borderStyle' => 'solid',
		'borderWidth' => '1px'
	)
);
");?>

Changing properies of an element, and later changing them again will not undo the previous set of properties, it will accumulate.
<br />
All properies will be applied to the element,  you can however overwrite  specific properties. If the same property is being use the latest one will stand.
<br />
In the example below all properties are taken into account, however the style property width and height will overwrite the previous width and height set.
<?php echo $ajax->code("
\$ajax->my_image = 'http://cjax.sourceforge.net/media/logo.png';
\$ajax->my_image = array('width' => 200,'height'=> 100, 'alt' => 'this is a logo');
\$ajax->my_image = array(
	'style' => array(
		'width' => '200px',
		'height' => '100px',
		'borderStyle' => 'solid',
		'borderWidth' => '1px'
	)
);
");?>


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
