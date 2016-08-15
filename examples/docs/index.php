<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="http://cjax.sourceforge.net/examples/resources/css/user_guide.css" media="all">
	<title>Cjax Framework Docs</title>
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
			Docs
		</td>
		<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
	</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


	<!-- Text -->
	<p>
		Want to contribute to this documentation?, you may do so by folking the source code(under docs): <a target='_blank' href='https://github.com/ajaxboy/cjax'>https://github.com/ajaxboy/cjax</a>. We could use a hand.
	</p>




	<h3>Installing and Upgrading</h3>
	<ul>
		<li>
			<a href="installing.php"  target="_blank">Installing Cjax</a>
		</li>
		<li>
			<a href="upgrading.php"  target="_blank">Upgrading</a>
		</li>
	</ul>

	<h3>Troubleshooting</h3>
	<ul>
		<li>
			<a href="troubleshooting.php"  target="_blank">Troubleshooting</a>
		</li>
	</ul>


	<h3>Plugins Docs</h3>
	<ul>
		<li>
			<a href="http://cjax.sourceforge.net/examples/plugins.php"  target="_blank">View Plugins Docs</a>
		</li>
	</ul>


	<h3>Misc</h3>
	<ul>
		<li>
			<a href="http://cjax.sourceforge.net/distributions.php"  target="_blank">Cjax Distributions</a>
		</li>
	</ul>


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