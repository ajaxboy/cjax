<?php
//core file, reference..
require_once "../../ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="../resources/css/user_guide.css" media="all">
	<title>Template</title>
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
			Template
		</td>
		<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
	</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


	<!-- Text -->
	<h2 id="install">Install/Download</h2>
	<br>
	Here are the steps to get the framework installed on your site, or test installation:<br>

	<br />
	<p>
	<b>Important Note:</p> Previously there were more than one package being distributed, the mains Cjax
		release and the CodeIgniter release. Starting from Cjax v 5.9, there will be only one single distribution
		package. This new distribution package has built-in support for CodeIgniter, rather that a separate package.
	</p>
	<ul>
		<li>
			1. <a target="_blank" href="https://github.com/ajaxboy/cjax">Download</a> the latest stable release
			<br />
		</li>
		<li>
			2. Place the contents of the zip on the root of the site merging it with your current site.
			<br>
			So you'd end up with your current structure plus:
			<ol>
				<div style="margin-left: 15px;">
		<pre>		 /
		 cjax/
		 controllers/
		 ajax.php
		 testing.php
		</pre>
				</div>
			</ol>
		</li>
		<li>
			You are set. Now lets test...
		</li>
	</ul>
	<h4>Testing your Cjax Installation</h4>
	For security reasons you cannot access ajax.php directly on your browser, so we'll use testing.php to use. <br>
	Go onto your browser and type in the url for your site, plus testing.php?test/test, eg:  http://yoursite.com/ajax.php?test/test
	<br>
	If you see the text "Ajax View..." on your browser, that means you have successfully installed and tested the ajax framework.
	<br>
	You may find the text in file controllers/test.php in function test(). If your installation was successful you may delete file testing.php.




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