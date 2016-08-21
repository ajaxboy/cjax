<?php
//core file, reference..
require_once "../../ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="../resources/css/user_guide.css" media="all">
		<title>Installing Cjax Framework</title>
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
			Installing
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

	<!-- Text -->
	<h2 id="install">Install/Download</h2>
	<br>
	Here are the steps to get the framework installed on your site, or test installation:<br>

	<br />
	<p class="soft-note">
		Previously there were multiple packages being distributed. Starting from <span class="req">Cjax v 5.9</span>, there will be a one single distribution
		package. It includes CI Integration. Cjax is a general purpose ajax framework, it is not exclusive to CodeIgniter (many people seem to think it is).
	</p>
	<ul>
		<li>
			1. <a target="_blank" href="https://github.com/ajaxboy/cjax/releases">Download</a> the latest stable release
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
		 response/
		 ajax.php
		</pre>
				</div>
			</ol>
		</li>
		<li>
			You are set. Now lets test...
		</li>
	</ul>
	<h4>Testing your Cjax Installation</h4>
	<p>
	For security reasons you cannot access ajax.php directly on your browser, however there is a special case allowed for this <span class="keyword">test</span> controller.
	Go onto your browser and type in your site url + /ajax.php?test/test  eg: http://yoursite.com/ajax.php?test/test
	<br />
	You will see further confirmation on that page, and instructions.
	<br>
	You may find the text in file response/test.php in function test(). If your installation was successful you may delete file test.php.
	</p>

	<p class="info">
		If you run into any issues while installing, consider <a href="troubleshooting.php">Troubleshooting</a>, and <a href="debugging.php">debugging</a>.
		<br />
		Should you have additional questions, you can contact the <a href="mailto:&#099;&#106;&#120;&#120;&#105;&#050;&#049;&#064;&#103;&#109;&#097;&#105;&#108;&#046;&#099;&#111;&#109;?subject=Questions About Cjax">author</a>. If all else fails, professional installation is available for a feed 100% guarateed or your money back.
	</p>



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