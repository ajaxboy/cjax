<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
	<title>Element Properties</title>
	<?php echo $ajax->init();?>
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
			Element Properties
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

	<h2>Element Properties</h2>

	<p>
		<!-- Text -->

	Changin/Setting element properties with the $ajax object follows the same logic as changing them in JavaScript.
	All you need is the ID of the element to be able to change/set its properties. This applies to all elements:
	divs,spans,images , text, buttons, inputs, and other elements. You may change ANY property that is available in JavaScript for that element.
	As long it is a valid property you will be able to change/set its value.
	<h3>Main Property</h3>
	<?php echo $ajax->code("\$ajax->element_id = 'something';");?>
	In Cjax all elements have a main property. "element_id" would be of course the id of the element you wish to interact with. 'something' is the value, each element
	has its main property, for example  an image's main property would be "src" so by using the statement above on an image
	it would update its src property while if it is for a div or a span it would be updating/settings its innerHTML. For checkboxes
	you may use boolean (true or false) inputs to check/uncheck.
	<br /><br />
	<B>Note:</B> <i>General Properies and Style Properties are only possible after</i> version 5.0-RC1.
	<br />

	<table>
		<thead>
		<tr>
			<th>
				Element
			</th>
			<th>
				Main Property
			</th>
		</tr>
		</thead>
		<tr>
			<td>
				Image
			</td>
			<td>
				src
			</td>
		</tr>
		<tr>
			<td>
				Div,Span
			</td>
			<td>
				innerHTML
			</td>
		</tr>
		<tr>
			<td>
				input (text,checkbox,hidden, etc)
			</td>
			<td>
				value
			</td>
		</tr>
		<tr>
			<td>
				link
			</td>
			<td>
				href
			</td>
		</tr>
	</table>

	<h3>General Properties</h3>
	If you intend to update other properies in that element, use an array instead.
	<br />




	</p>

	<h3>Examples</h3>

	<?php echo $ajax->code("
\$ajax->element_id = array('width' => 200,'height'=> 100);
");?>
	<h3>Style Properties</h3>
	To update the style property of an element follow the same logic as before:
	<?php echo $ajax->code("
\$ajax->element_id = array(
	'style' => array(
		'width' => '200px',
		'height' => '100px',
		'borderStyle' => 'solid',
		'borderWidth' => '1px'
	)
);
");?>

	<!-- Code Used -->
	<h3>Properties Accumulate</h3>
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

	<!-- HTML -->


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



