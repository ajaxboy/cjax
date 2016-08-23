<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();

$ajax->change("dropdown1",$ajax->call("ajax.php?dropdown/propagate_allow_input/|dropdown1|"));

?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
	<title>Dropdown input</title>
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
			Dropdown input
		</td>
		<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
	</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


	<!-- Text -->
	This example is almost identical to the other example "propagate dropdown", except on this example when you select<br />
	"other..", it displays a input box, to type in.


	<br />

	<h3>Examples</h3>


	<!-- Code Used -->
	<br />
	<?php
	echo $ajax->code("
\$ajax->change(\"dropdown1\",\$ajax->call(\"ajax.php?dropdown/propagate_allow_input/|dropdown1|\"),\"change\");
", true, true);
	?>


	<div>
		<select id='dropdown1'>
			<option value="" selected="selected">Other..</option>
			<option value="options">Options</option>
			<option value="states">Some States</option>
		</select>
		<br />
		<select id='dropdown2'>
			<option>Select something above..</option>
		</select>
	</div>
	<br />
	<br />
	Controller:
	<?php
	echo $ajax->code("

class dropdown {
	function propagate_allow_input(\$selected)
	{
		\$ajax = ajax();
		\$data = array();

		switch(\$selected) {
			case 'options':
				\$data[] = \"Option 1\";
				\$data[] = \"Option 2\";
				\$data[] = \"Option 3\";
				\$data[] = \"Option 4\";
				\$data[] = \"Option 5\";
			break;
			case 'states':

				\$data[] = \"Texas\";
				\$data[] = \"Florida\";
				\$data[] = \"New York\";
				\$data[] = \"California\";
				\$data[] = \"New Mexico\";
				\$data[] = \"Maine\";
			break;
		}

		\$ajax->select('dropdown2',\$data,true);

	}
}
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
