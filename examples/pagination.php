<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();

$options  = array(
	'url' => 'ajax.php?pagination/page',
	'startPage' => 1,
	'totalPages' => 15,
	'visiblePages' => 7,
	'cache' => false,
	'pageContainer' => 'page_container'
);

$ajax->pagination('#pager1', $options);


$options  = array(
	'url' => 'ajax.php?pagination/page',
	'totalPages' => 10,
	'startPage' => 1,
	'visiblePages' => 7,
	'initiateStartPageClick' => false,
	'href' => false,
	'hrefVariable' => '{{number}}',
	'first' => 'First',
	'prev' => 'Previous',
	'next' => 'Next',
	'last' => 'Last',
	'loop' => false,
	'paginationClass' => 'pagination',
	'nextClass' => 'next',
	'prevClass' => 'prev',
	'lastClass' => 'last',
	'firstClass' => 'first',
	'pageClass' => 'page',
	'activeClass' => 'active',
	'disabledClass' => 'disabled',
	'pageContainer' => 'page',
	'cache' => true,
);

$ajax->pagination('#pager2', $options);
//$ajax->spin('page','page_container');


$options  = array(
	'url' => 'ajax.php?pagination/page',
	'totalPages' => 10,
	'startPage' => 1,
	'visiblePages' => 7,
	'size' => 'small'
);

$ajax->pagination('pager3', $options);

?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
	<title>Ajax Pagination</title>
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
			Ajax Pagination
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

	<h2>Pagination</h2>

	<!-- Text -->
	<p>
	Pagination plugin can easily be implement into pages, hassle free.
	<br />
	Requires <span class="req">Cjax 5.9+</span>.
	</p>
	<p class="note">
		This functionality has no dependencies, any dependencies are already built-in.
	</p>


	<p></p>
	Credit for this plugin goes to Cj Galindo and, also includes the works of Eugene Simakin.
	</p>

	<h3>Examples</h3>


	<h4>Basic Usage</h4>
	<!-- Code Used -->
	<p>
		This example using the very minimum settings. If you want to customize it the way you really want it, you
		could use some of the available options.
	</p>

	<?php
	echo $ajax->code("

	\$options  = array(
		'url' => 'ajax.php?pagination/page',
		'totalPages' => 15
	);

	\$ajax->pagination('pager1', \$options);
");
	?>


	<?php
	echo $ajax->code("

	<div id='pager1'></div>



", 'HTML', "<div class='try_it' style='margin-left: 250px;'><img src='resources/images/try_it.png' /></div>");
	?>
	<br />
	<div id='pager1'>Pagination Page One</div>
	<br />


	<h4>Advanced Usage</h4>
	<!-- Code Used -->

	<p>
		Here showcased all the possible options you can use.
	</p>
	<?php
	echo $ajax->code("

	\$options  = array(
		'url' => 'ajax.php?pagination/page',
		'totalPages' => 10,
        'startPage' => 1,
        'visiblePages' => 7,
        'initiateStartPageClick' => false,
        'href' => false,
        'first' => 'First',
        'prev' => 'Previous',
        'next' => 'Next',
        'last' => 'Last',
        'loop' => false,
        'paginationClass' => 'pagination',
        'nextClass' => 'next',
        'prevClass' => 'prev',
        'lastClass' => 'last',
        'firstClass' => 'first',
        'pageClass' => 'page',
        'activeClass' => 'active',
        'disabledClass' => 'disabled',
        'pageContainer' => 'page',
        'cache' => true,
        'size' => 'large'
	);

	\$ajax->pagination('pager2', \$options);
");
	?>

	<?php
	echo $ajax->code("

	<div id='pager2'>Pagination Page One</div>



", 'HTML', "<div class='try_it' style='margin-left: 250px;'><img src='resources/images/try_it.png' /></div>");
	?>
	<br />
	<div id='pager2'>Pagination Page One</div>
	<br />


	<br />



	<h4>Small Size</h4>

	<p>
	For the smaller size pagination
	</p>
	<!-- Code Used -->
	<?php
	echo $ajax->code("

	\$options  = array(
		'url' => 'ajax.php?pagination/page',
		'totalPages' => 50,
        'visiblePages' => 10,
        'size' => 'small'
	);

	\$ajax->pagination('pager3', \$options);
");
	?>

	<?php
	echo $ajax->code("

	<div id='pager3'>Pagination Page One</div>



", 'HTML', "<div class='try_it' style='margin-left: 250px;'><img src='resources/images/try_it.png' /></div>");
	?>


	<br />
	<div id='pager3'>Pagination Page One</div>
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
