<?php
//core file, reference..
require_once "../../ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="../resources/css/user_guide.css" media="all">
    <title>Cjax Setup</title>
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
            Cjax Setup
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->

    <h2>Iniciating the JavaScript Engine</h2>
    <br />
    To initialize the JavaScript library included with Cjax,  have the $ajax Object do it for you, <br />
    <br />


    <br />

    <h3>Examples</h3>


    simply in the HEAD of the HTML page do:
    <?php echo $ajax->code("
<head>
<?php echo \$ajax->init(); ?>
</head>
", false);?>
    <br />
    $ajax->init() will print the script tag of cjax.js.
    <br /><br />
    As of version 5.0-beta, By default the minified version of cjax.js is invoked, but you can change that by passing false in the init function, eg:  $ajax->init(false), then the full version would be used.
    <br /><br />
    - OR -
    <br /><br />
    As of 5.0-RC2 you can also do this:
    <br /><br />
    <?php echo $ajax->code("
<head>
<?php echo \$ajax->init('http://yoursite/url/here/'); ?>
</head>
", false);?>
    Where it says "http://yoursite/url/here/" Enter the path where ajax.php is, but withouth the "ajax.php".
    <br /><br />
    - OR - a work around for using init() function -
    <br /><br />
    Simply include file in the head of your HTML document:
    <?php echo $ajax->code("
<script id='cjax_lib' type='text/javascript' src='cjax/core/js/cjax.min.js'></script>
", false);?>



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
