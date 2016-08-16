<?php
//core file, reference..
require_once "../../ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="../resources/css/user_guide.css" media="all">
    <title>Cjax -  Creating Controllers</title>
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
            Creating Controllers
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->

    <h3>Ajax Controllers</h3>
<p>
    An ajax controller is a php file with a class that handles ajax requests. The ajax controller allows you to consolidate
    all your ajax requests to a single place of origin. An ajax controller has also Cjax pre-loaded. You can easily start
    creating more functionality right from your ajax controller. All Cjax functions will work on an ajax controller as they work
    when you first load tha page. This powerful feature lets you continue interacting with the server back and forth, using the same type of logic.
    Ajax controllers not only let you serve ajax requests, but it also can generate further actions, right from the back-end. For example,
    from an ajax controller you can create ajax requests, update elements on the page, issue <a href="triggers.php">triggers</a>. Anything else
    you can do on the page load, you can also do in an ajax controller, you can even use Cjax plugins from an ajax controller. Imagine having this power, on every ajax call you make!.
</p>
    <br />
    An ajax controller is automatically called when you route your ajax requests through file  ajax.php.
    <br />

    <h3>Example</h3>

    URL:  ajax.php?Controller/Method

    <br/>
    <br />
    The url above will load a file called Controller.php inside the controllers directory, and will trigger a method called 'Method'.

    <?php
    echo $ajax->code("

    //controllers/Controller.php
    class Controller {


        function Method()
        {
            \$ajax = ajax();

        }
    }
", true);
    ?>

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