<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


$ajax->click("button1",$ajax->call("ajax.php?send_input/send_text/|text1|"));

$ajax->click("button2",$ajax->call("ajax.php?send_input/send_checkbox/|check1|"));

?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>Ajax Send inputs</title>
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
            Ajax Send inputs
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->
    Ajax Send inputs


    <br />

    <h3>Examples</h3>


    <!-- Code Used -->

    <br />
    <?php
    echo $ajax->code("
\$ajax->click(\"button1\",\$ajax->call(\"ajax.php?send_input/send_text/|text1|\"));

\$ajax->click(\"button2\",\$ajax->call(\"ajax.php?send_input/send_checkbox/|check1|\"));
");?>
    Controller:
    <?php
    echo $ajax->code("
class controller_send_input {

	function send_text( \$text )
	{

		\$ajax = ajax();

		\$ajax->success(\"This message was sent: \$text\",30);
	}

	function send_checkbox( \$check )
	{
		\$ajax = ajax();

		if(\$check) {
			\$ajax->success(\"Is checked..\");
		} else {
			\$ajax->warning(\"Is not checked..\");
		}
	}
}
", true, true);?>

    <!-- HTML -->

    <input id='text1' type='text' value='Send this text'>
    <br />
    <input type='submit' id='button1' value='Send text..'>
    <br />
    <br />
    <br />
    <input type='checkbox' id='check1' checked='checked'>
    <input type='submit' id='button2' value='Send Checkbox value..'>
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
