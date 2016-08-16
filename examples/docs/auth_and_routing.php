<?php
//core file, reference..
require_once "../../ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="../resources/css/user_guide.css" media="all">
    <title>Auth and Routing</title>
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
            Auth and Routing
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->

    <h2>Custom Auth and Routing</h2>
    <br />
    Since 5.0RC3 the ajax framework allows for custom authentication and custom routing without making changes to the core files.
    <br /><br />
    There is a file: cjax/auth.default.php, in this file there is a further information and framework functionality
    to create custom validation and routes. For changes to take effect you must rename file auth.default.php to auth.php.
    <br />
    <h3>Auth and Routing</h3>
    <p>
    File auth.php has a class name "AjaxAuth", in this class there are two <span class="keyword">methods</span>,
    one of them is "validation" - triggers at validation before the
    ajax request is finished and allows you to write your own custom validation code.
    The other function is "intercept" - provides you with a section
    where you can create your custom code to route ajax requests to other parts of your application.

    <br /><br />
    <b>Note:</b>  If a controller name is the same name as a Cjax plugin, the request will be routed to that controller plugin's directory.
    </p>

    <h3>Auth</h3>
    Returning true indicates that the session is valid. If your return false the request will not proceed and will present an error.
    <?php
    echo $ajax->code("
function validate(\$controller = null, \$function = null, \$args = array())
{

	return true;
}");
    ?>
    <h3>Routing</h3>
    Ajax Routes are specially needed if your application
    supports plugins or addons, then these addons may also have full access to the ajax framework and feed
    ajax requests through your custom route.
    <br />
    The intercept function gives you space to write your own custom routes.
    Returning "true" in the intercept function would tell the framework not to persue the request any longer and indicates that your route has
    taken lead of the request. Returning false would give back the control to the framework and continue the request as it normally would.


    <br />

    <h3>Examples</h3>


    <!-- Code Used -->
    <?php
    echo $ajax->code("
function intercept(\$controller = null, \$function = null , \$args = array(), \$requestObj = null)
{
	return false;
}"
    );
    ?>

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