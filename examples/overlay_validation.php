<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


$rules = array(
	'rules' => array(
		'a[name]' => array(
			'required' => true,
			'minlength'  => 5,
		),
		'a[last_name]' => array(
			'required' => true,
			'minlength'  => 5,
		)
	),
	'messages' => array(
		'a[name]' => array(
			'required' => 'Please enter your name',
		),
		'a[last_name]' => array(
			'required' => 'Enter your last name',
		)
	)
);


//surging from $overlay ensures that it is ran after the html has been generated.
//$overlay->validate('button1','ajax.php?overlay_validation/form', $rules);

//die("cache<pre>".print_r(CoreEvents::$cache,1). "cbs<pre>".print_r(CoreEvents::$callbacks,1));

//ensure that it validation is ran after the html form is generated.
//$overlay->callback = $ajax->validate('button1','ajax.php?overlay_validation/form', $rules);

$ajax->click('link1',  $ajax->overLay('resources/html/test_form.html'));

$ajax->on('overlayPop', $ajax->validate('button1','ajax.php?overlay_validation/form', $rules));

$ajax->click('link2', $ajax->call('ajax.php?overlay_validation/overlay2'));

?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
	<title>Ajax Overlay and Validation</title>
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
			Ajax Overlay and Validation
		</td>
		<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
	</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


	<!-- Text -->
	<br />
	This sample makes use of different CJAX APIs to create a Overlay/validation functionality. The validation plugin makes use of
	Jquery.validate plugin.

	<br />

	<h3>Examples</h3>


	<!-- Code Used -->
	<?php
	echo $ajax->code("
	//5.0-RC3+
	//Total 3 lines of code!, (not including the customs rules)

	//Note: For sample#2 look inside the controller: examples/controllers/overlay_validation.php:overlay_validation::overlay2();

	#Sample #1
	//initial action to the 'launch' link
	\$rules = array(
		'rules' => array(
			'a[name]' => array(
				'required' => true,
				'minlength'  => 5,
				),
				'a[last_name]' => array(
				'required' => true,
				'minlength'  => 5,
				)
				),
				'messages' => array(
				'a[name]' => array(
				'required' => 'Please enter your name',
				),
				'a[last_name]' => array(
				'required' => 'Enter your last name',
			)
		)
	);


	\$overlay = \$ajax->overLay('resources/html/test_form.html');
	\$overlay->validate('button1','ajax.php?overlay_validation/form', \$rules);

	\$ajax->click('link', \$overlay);

	//Controller

	class overlay_validation {

		function form()
		{
			\$ajax = ajax();
			//show posted variables
			\$ajax->debug(\$_POST,'Post Debug Info',\"These are the fields posted.\");
		}
	}
	", true, true);
?>
	<!-- HTML -->

	<br />

	<a id='link1' href='#'>Launch Sample #1</a>
	<br />
	<br />
	<a id='link2' href='#'>Launch Sample #2</a>

	<br />

	<br />

	<br />
	Used in sample:
	<ul>
		<li>
			<a target='_blank' href='click_ajax_request.php'>$ajax->call()</a>
		</li>
		<li>
			<a target='_blank' href='overlay.php'>$ajax->overLay()</a> (Used in Sample #1)
		</li>
		<li>
			<a target='_blank' href='overlay.php'>$ajax->overlayContent()</a> (Used in Sample #2)
		</li>
		<li>
			<a target='_blank' href='plugin_validate.php'>Cjax Plugin Jquery Validate</a>
		</li>
	</ul>
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
