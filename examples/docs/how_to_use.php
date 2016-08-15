<?php
//core file, reference..
require_once "../../ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="../resources/css/user_guide.css" media="all">
	<title>How to use</title>
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
			<a href="../">Demos</a> &nbsp;&#8250;&nbsp;
			How to use
		</td>
		<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
	</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


	<!-- Text -->
	To start using Cjax follow these steps: <br />
	<br />
	If you'd like to use Cjax only as an ajax response handler to MVC requests, you don't need to do anything,
	just direct your requests to ajax.php file by following the specifications of URL <a href='url_styles.php'>here</a> and
	create controllers as specified <a href='creating_controllers.php'>here</a>.
	<br />
	<br />
	If you'd like to use the full power of Cjax including all Ajax functionality, follow these steps:<br />

	<br />

	<h3>Examples</h3>


	<ul>
		<li>
			1. Include ajax.php.
			<br />
			Example:

			<?php
			echo $ajax->code("
require_once 'ajax.php';
			");
			?>
		</li>
		<li>
			2.
			<br />
			<br />
			You may instantiate Cjax as follows:
			<?php echo $ajax->code("
\$ajax = ajax();
		", false);?>
			Once you have access to the $ajax object, simply in the HEAD of the HTML page do:
			<?php echo $ajax->code("
<head>
<?php echo \$ajax->init(); ?>
</head>
		", false);?>
			If you run into issues on this step review the specifications <a href='Iniciating_the_JavaScript_Engine.php'>here</a>:
			<br /><br />
		</li>
		<li> You are set - <br />
			That is all you need, to fully initiate Cjax. Now you may review the <a href='api_table.php'>APIs</a> that you can start using ASAP.
			<br />
			View/test and <a href='http://cjax.sourceforge.net/examples'>Download the demos</a> to review code samples. Then
			read the rest of the <a href='./'>docs</a>.
			<br />
			That should get you started.
			<br />
			<br />
		</li>
	</ul>

	<!-- Code Used -->


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