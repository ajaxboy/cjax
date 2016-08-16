<?php
//core file, reference..
require_once "../../ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="../resources/css/user_guide.css" media="all">
    <title>Moving Cjax directory</title>
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
            Moving Cjax directory
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->
    <h3>Moving Cjax directory</h3>
    If you want to move cjax directory from the root of your site. As of Cjax 5.9 that is possible.
    <br />
    You need to do two things.  Move the cjax directory to the location where you wish it to be moved and
    update file ajax.php with the location of the new path. Keep in mind, that cjax needs to remain accessible through the URL.
    <br />
    Add this line on the top of file ajax.php:

    <?php
       echo $ajax->code("

        define('AJAX_WD', '/new/location/where/cjax/is');

        ", 'HTML');
    ?>

    That should be all you need.

    <p>
        <b>Note:</b>  This could helpful with the creation of new integrations with other products/projects or frameworks.
        <br />
        Simply move the directory where otherwise the other product/project  requires it.  Also ajax.php is
        can be moved.
        <br />
        If you are interested in seeing how integrations work, look inside cjax/integration.php

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
