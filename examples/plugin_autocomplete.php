<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();

$ajax->keyup('#text1', $ajax->autocomplete('ajax.php?autocomplete/update'));

?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
	<title>Ajax Autocomplete</title>
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
			Ajax Autocomplete
		</td>
		<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
	</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


	<!-- Text -->
	Slick, simple and usable autocomplete. This plugin ready to use when you download Cjax, as it already comes included.
	<br />
	From your <a href="docs/controllers.php">Ajax controller</a> return an array. That array, is then converted into autocomplete options.
	<br />
	Caching is enabled. If you have already typed a word and undo then retype, it won't make more ajax calls. It will attain previous data.
	<br />

	<h3>Examples</h3>


	<!-- Code Used -->
	<?php

	echo $ajax->code("
	\$ajax->keyup('#text1', \$ajax->autocomplete('ajax.php?autocomplete/update'));

	", true, true);
		?>


	<!-- HTML -->
	Type Something <input type="text" id="text1" value="" /> (like a country name).
	<br /><br />

	<h2>Cjax 5.9+</h2>
	<p>
	Cjax 5.9 adds alot of power to autocomplete. More stability, more scalability, more caching and overall more complete and more features.
	</p>

	<p class="note">Note: These new features should be considered beta, which means, they could change in the future.</p>

	<p>
	Two more optional parameters. boolean <span class="param">$full_load</span> and  string <span class="param">$url2</span>
	</p>

	<h5>$full_load</h5>
	<p>
	Realizing that every time you type a key, triggers an ajax call to the server, you may want to instead load all data at
	once, and not request the server as much.
	True / False, this options lets you load all the data at once. Intead of making an ajax request for each letter you
	type, you can dump a full array  of data once, this data is then cached.  When used this way, only one ajax call to the server is made.
	When you type more, the data obtained is filtered to serve the other keys you type.
	</p>
	<p>
	Additionally, you can -
	</p>
	<br />
	<p>
	<b>Preload</b>: Need to load large amount of data? No problem. You can preload it. This can ensure that the
	autocomplete acts really fast even with very large amounts of data.
	<br />
	With the new caching capabilities, you can take advantage of these caching capabilities by preloading
	the data you want to use. When the autocomplete kicks in all the data will be already be in place.
	You can take advanage of this by  <a href="call.php">making an ajax request</a> to the same url you are using for the
	autocomplete, and using the cache flag in the call() <span class="keyword">method</span>.
	This wil cache data, when the autocomplete triggers the request, it will be served from cache, without making any other ajax request.
	</p>
	<h6>Preload Example</h6>
	<?php
	echo $ajax->code("
	//assuming the method is ajax.php?autocomplete/full
	//this will cache this data in the client side.
	//If you trigger any more requests to this url they will be served from cache, and the same response that was obtained the first time
	//will be served all the time.
	\$ajax->call(array('autocomplete','full',null, array('cache' => true)));

	");
	?>

	<h5>$url2</h5>

	If you would like to trigger an ajax request when of the one items is selected in the autocomplete, here is where you do it. Specifiy a <span class="param">$url</span>
	by default, the name of the item you select will be added to the url as a controller parameter. In your ajax contoller you should get
	this name in the first argument. You can also choose to send an id instead, if your original data array contains ids, you can specify a forth
	parameter with the word 'id'  and the id will be sent.

	<?php
	echo $ajax->code("
	\$ajax->keyup('#text2', \$ajax->autocomplete('ajax.php?autocomplete/full', true ,'ajax.php?controller/method','id'));

	");
	?>
<br />

	Note: Current limitation in autocomplete you can only have one instance on a page.


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