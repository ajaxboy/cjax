<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


$ajax->click("button1",$ajax->call("ajax.php?recursive_ajax/call/0/|count|"));
?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>Recursive Ajax Requests</title>
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
            Recursive Ajax
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->
    Recursive ajax requests demo shows you how you can trigger ajax requests from the server, and if you can trigger
    an ajax request from the server, then you can do it recursively. First an ajax request is initiated, it goes to the
    ajax controller. Ajax controller, updates counter, and fires another ajax request to itself. This is truly non-asynchronous because
    it does not trigger all the requests at once, rather it wait for one to finish, and the ajax request itself triggers the next one
    until the count total is matched.


    <br />

    <h3>Examples</h3>


    <!-- Code Used -->
    <br />
    <?php
    echo $ajax->code("
<?php
\$ajax->click(\"button1\",\$ajax->call(\"ajax.php?recursive_ajax/call/0/|count|\"));
?>

<!--HTML-->
<input type='button' id='button1' value ='Start recursive requests'/>
<div id='div_counter'></div>
", false, true);
    ?>


    <!-- HTML -->
    <br />
    How many ajax requests would you like?.
    <input type='text' id='count' value='30'/>
    <br />
    <input type='submit' id='button1' value ='Start recursive requests'/>
    <div id='div_counter'></div>
    <br />

    <br />

    <br />
    <h2>Controller</h2>
    <?php
    echo $ajax->code("
class recursive_ajax {

	function call(\$counter = 0,\$count)
	{
		//force valid inputs
		\$counter = (int) \$counter;
		\$count = (int) \$count;

		\$counter++;

		\$ajax = ajax();

		//if you enter a number greate than 100
		if(\$count > 100) {

			//focus on textbox
			\$ajax->focus('count');

			//show warning
			\$ajax->warning(\"Too many requests can add overhead to our servers, please try reducing the number.\");

			//update textbox
			\$ajax->count = 30;
			return;
		}

		//update div
		\$ajax->div_counter = \"Call# \$counter..\";

		if(\$counter>=\$count) {
			\$ajax->div_counter = \"\$counter recursive AJAX requests were made.\";
		} else {

		//fire call
			\$ajax->call(\"ajax.php?recursive_ajax/call/\$counter/\$count\");
		}

	}

}
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