<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


/**
 * Progressbar code is just a one liner.
 */

$ajax->progressbar('#progressbar1', 20);

$ajax->progressbar('#progressbar2', 44);

$ajax->progressbar('#progressbar3', 67);

$ajax->progressbar('#progressbar4', 40, array('color' => 'red'));


/**
 *
 * This supporting methods is extra for the demo
 */

$ajax->click('.link', $ajax->call(array('progressbar','start', array('data.test'))));

$ajax->click('#link4', $ajax->call(array('progressbar','start', array('data.test','steps4'))));



?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <meta charset="utf-8">
	<title>Cjax | Ajax Progressbar</title>
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
			Ajax Progressbar
		</td>
		<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
	</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    Credits# Cj Galindo  and includes the work of
	<!-- Text -->
	Slick, simple and usable progressbar for your measuring needs.

	<h3>Examples</h3>


	<!-- Code Used -->
	<?php

	echo $ajax->code("
	//show progressbar at 1%
	\$ajax->progressbar('#progressbar1', 20);

    \$ajax->progressbar('#progressbar2', 44);
    
    \$ajax->progressbar('#progressbar3', 67);
    
    \$ajax->progressbar('#progressbar4', 40);

	", true, true);
		?>



    <h6>Example</h6>






    <ul class="inline">
        <li>
            <div id="progressbar1">
                <img src="/cjax/plugins/progressbar/img/check.png" />
            </div>
            <a href="#" class="link" data-test="1">Test</a>
        </li>
        <li>
            <div id="progressbar2">
                <img src="/cjax/plugins/progressbar/img/cj.png" />
            </div>
            <a href="#" class="link" data-test="2">Test</a>
        </li>
        <li>

            <div id="progressbar3">
            </div>
            <a href="#" class="link" data-test="3">Test</a>
        </li>
        <li>
            <div id="progressbar4">
            </div>
            <a href="#" id="link4" data-test="4">Test</a>
        </li>
    </uL>

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