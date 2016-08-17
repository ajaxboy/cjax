<?php
//core file, reference..
require_once "../../ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="../resources/css/user_guide.css" media="all">
    <title>Template</title>
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
            Template
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->

    <h2>Troubleshooting</h2>

    <h3>Strict Standard</h3>
    Strict Stadards turned on is one of the most common causes for Cjax not working after the release of PHP 5.4.
    for Cjax version < 5.8 (5.7 and before), this of course broke many sites.
    <br />
    Cjax 5.8 added support to rid of this issue by changing this setting on the fly. It seems that this fixed the issue for everyone.
    As this has rarely been reported anymore.
    Cjax 5.9+ is strict standards compliant, and shouldn't need the on-the-fly setting change anymore, though the fix will remain until
    we are sure.
    <br />
    <h3>Fallback</h3>
    There is an option that allows you to switch how the data is tranfered across over to JavaScript. If you are  experiencing
    issues with commands not taking effect (while on page load) or with PHP SESSIONS, then you might want to use this :

    <?php echo $ajax->code("\$ajax->fallback = true;");?>
    This will print a script tag on the page instead of using  PHP SESSIONS to pass data.
    <br /><br />
    You may also find file cjax/config.default.php, rename this file to config.php.
    <br /> then find the option $config->fallback, and change it to true, this will apply the change globally.


    <h3>Cjax, not doing anything?</h3>
    You can access the page just fine, but when you click something, nothing happens.
   <h5>Server Error</h5>
    This could be a cause of multiple reasons, there could have been a server errors that prevent the server from being
    reached through an ajax call. This is rare, but it can happen, mostly by code error you may have in your ajax controller.
    <br />
    You may want to check your error logs and see what the latest errors are and see if something can explain this issue.

    <h5>Js Lib not loaded</h5>
    Some servers, may have odd configuration in their mod-rewrite rules. This could affect Cjax from reaching its Js Library.
    Follow the steps on <a href="Iniciating_the_JavaScript_Engine.php">Initiating the Js engine</a>.


    <h2>Found a new problem?</h2>

    Although Cjax works out of the box in 99% of the hosts where you use it, it is still posible something odd  might happen.
    <br/>
    You think you found a problem that prevents you from using Cjax? Let us know.
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