<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();

$ajax = ajax();

$ajax->click("button1",$ajax->call("ajax.php?change_value/text/text1/|text1|"));

$ajax->click("button2",$ajax->call("ajax.php?change_value/check/check1/|check1|"));

$ajax->click("button3",$ajax->call("ajax.php?change_value/div/|rand|"));
?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>Ajax Update Elements</title>
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
            Ajax Update Elements
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->
    <br />
    You may change any element's value ranging from textboxes, checkboxes, divs,spans, and others.
    <br />
    Use the $ajax Object + the id of the element/contained to change the value/html/content.
    <br />
    <br />
    Change any element values from the backend


    <br />

    <h3>Examples</h3>


    <!-- Code Used -->
    <?php
    echo $ajax->code("
<?php

\$ajax->click(\"button1\",\$ajax->call(\"ajax.php?change_value/text/|text1|\"));

\$ajax->click(\"button2\",\$ajax->call(\"ajax.php?change_value/check/|check1|\"));

\$ajax->click(\"button3\",\$ajax->call(\"ajax.php?change_value/div/\");


?>

<!--HTML-->
<input type='text' id='text1' value=''>

<input type='checkbox' id='check1' />

<div id='DIV_1'></div>

",false);?>
    Controller:
    <?php
    echo $ajax->code("
class change_value {

	function div()
	{
		\$ajax = ajax();

		//Some random strings .......
		\$text[] = \"Lorem Ipsum is simply dummy text of the printing and typesetting industry. \";
		\$text[] = \"Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown \";
		\$text[] = \"printer took a galley of type and scrambled it to make a type\";
		\$text[] = \"specimen book. It has survived not only five centuries, but also the leap into electronic\";
		\$text[] = \"typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of \";
		\$text[] = \"Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\";
		\$text[] = \"it is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.\";
		\$text[] = \"The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using\";
		\$text[] = \"'Content here, content here', making it look like readable English. Many desktop publishing packages and \";
		\$text[] = \"web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many\";
		\$text[] = \"web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\";

		\$ajax->DIV_1 = \$text[rand(0, count(\$text)-1)];
	}

	function text(\$current_value)
	{
		\$ajax = ajax();

		\$ajax->text1 = \"Random number..\".rand(100,1000);
	}


	function check(\$current_value)
	{
		\$ajax = ajax();

		if(\$current_value) {
			\$ajax->check1 = false;
		} else {
			\$ajax->check1 = true;
		}
	}
}
", true, true);?>


    <!-- HTML -->

    <br />
    <br />
    <input type='text' id='text1' value=''>
    <br />
    <input type='button' id='button1' value='Change value'>
    <br />
    <br />
    <br />
    <input type='checkbox' id='check1' />
    <br />
    <input type='button' id='button2' value='Change value'>
    <br />
    <br />
    <div id='DIV_1'></div>
    <br />
    <input type='button' id='button3' value='Update div'>
    <br />

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
