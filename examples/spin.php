<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();

$ajax->spin('#spinning_text', 'spin', 200);
?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>Spin</title>
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
            Spin Effect
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->
    <h2>Spin Effect</h2>

    This effects applies spining, and rotating effects to text elements.

    <br />
    <h5>How does it work?</h5>
    This effect uses a Cjax plugin, and 3rd party code contained within the plugin.
    <h3>Examples</h3>


    <!-- Code Used -->
    Code Used:
    <?php
    echo $ajax->code("
	//
	\$ajax->spin('#spinning_text', 'spin', 200);


");
    ?>

    Code Used:
    <?php
    echo $ajax->code("

	    <span id=\"spinning_text\">Spinning Text</span>





", 'HTML', true);
    ?>

    <!-- HTML -->

    <span id="spinning_text">Spinning Text</span>


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
