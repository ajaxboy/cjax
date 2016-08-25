<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


//multiple commands can be binded..
//defeault event is "click"
$ajax->click("link1",
	array(
		$ajax->call("ajax.php?bind/link2"),
		$ajax->success("Hello World 1"),
		$ajax->overlayContent("Hello World 2"),
	));//default event is "click"


?>
<!doctype html>
<head>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">

	<title>Bind Actions</title>
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
			Bind Ajax Actions
		</td>
		<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
	</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">

	Binding actions, means you can pass multiple actions all at once in a single $ajax line, when genereally it is one action
	per line.
	You may bind as many commands as needed inside the <a href="triggers.php">triggers</a> click(), blur(), change(), keyup(), keydown(),  function.<br />

	<h3>Examples</h3>


	<h5>Normal</h5>
	This is an example how you genereally only pass one action to an event. See below for multiple action bind to an event.
<?php
echo $ajax->code("
	//Normal, only one actions passed.
	\$ajax->click(\"#link1\",\$ajax->call(\"ajax.php?bind/link2\"),);
	");
?>
	<h5>Bind Multiple Actions</h5>
	<?php
	echo $ajax->code("
	//default event is \"click\"
	\$ajax->click(\"#link1\",
		array(
			\$ajax->call(\"ajax.php?bind/link2\"),
			\$ajax->succcess(\"Hello World 1\"),
			\$ajax->overlayCotent(\"Hello World 2\"),
		)
	);


	//change color of the link, when it loses color
	\$ajax->blur(\"#link2\", \$ajax->prop(array('color' => 'red')));



	//ajax request when text in a text field changes
	\$ajax->change(\"#textfield\",\$ajax->call(\"ajax.php?bind/link2/|textfield|\"));

	");
	?>

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
