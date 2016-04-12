<?php

//core file, reference..
require_once "ajax.php";


	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">

<title>Main Property</title>
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
The Main property refers to HTML elements, assigned main property. Cjax can access/modify/remove/add anything from your HTML page, keeping this in mind
some times you may wish to only change add, or remove one thing, here is where the main property comes in handy, it allows you to do so with a simple line 
of code.
<br /><br />
Cjax categorizes the a main property on each HTML element. This allows for a speedy
interaction with that object while maintaining your code plain and simple.
<br />
<br />
When you think of an image, what comes to mind first when you think of its main html property?, I'd say it would be "src", when you think of checkbox or a radio
button, isn't the value or the check/unchecked the main property?. Think of these tags: a span, a div, p, what would you caracterize their main property?
I'd say the innerHTML.  That's all this is, is access these properties in the fastest and most convenient way possible so to speed up your development. 
<br />
<br />
Keep in mind, this works with all HTML elements, so think of the limiteless things you can do.
<br /><br />
All you need is the element ID and the value you wish to apply. $ajax->[element_id_here] = [value here];


<h2>Examples</h2>

Change an image. Lets assume there is an image in your html page, and it has the id of, "my_image". You can change the image just by assigning a new image
to it. The main property of an image is src. So when you assign a new image url, you are actually changing it's src property.
<?php 
echo $ajax->code("
\$ajax->my_image = 'http://cjax.sourceforge.net/media/logo.png';

");
?>
<br />
Check/Uncheck checkbox. In this example you want to know what is the quickes way to check/uncheck a checkbox, the main property makes it feel like breeze.
<?php 
echo $ajax->code("
//check it
\$ajax->checkbox_id = true;

//uncheck it
\$ajax->checkbox_id = false;

");
?>
<br />
Update a div or a span. Same logic applies to all elements, even divs and span elements.
<?php 
echo $ajax->code("
\$ajax->my_div = 'Some New HTML here';

\$ajax->my_span = 'Some New HTML here';
");
?>
<br />
Change a link URL. For links/anchors the href property is the main property.
<?php 
echo $ajax->code("
\$ajax->my_link = 'http://cjax.sourceforge.net/';

");
?>


<table cellspacing="1" cellpadding="0" border="0" class="tableborder" style="width:100%">
<tbody><tr>
	<th>Element</th>
	<th>Main Property</th>
	<th>Description</th>
</tr>
<tr>
	<td class="td"><strong>Image</strong></td>
	<td class="td">src</td>
	<td class="td">Any image</td>
</tr>
<tr>
	<td class="td"><strong>Link</strong></td>
	<td class="td">href</td>
	<td class="td">Any links</td>
</tr>
<tr>
	<td class="td"><strong>Checkbox</strong></td>
	<td class="td">checked/unchecked</td>
	<td class="td">Checkboxes, radios, etc</td>
</tr>
<tr>
	<td class="td"><strong>Input</strong></td>
	<td class="td">value</td>
	<td class="td">applies to (text,checkbox,hidden, etc)</td>
</tr>
<tr>
	<td class="td"><strong>Containers</strong></td>
	<td class="td">innerHTML</td>
	<td class="td">applies to div,span, p, etc</td>
</tr>
</tbody></table>



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
