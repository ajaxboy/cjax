<?php
//core file, reference..
require_once "../../ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="../resources/css/user_guide.css" media="all">
    <title>Parameters</title>
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
            Parameters
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->

    <h2>Passing Parameters</h2>
    <ul>
        <li>
            <h4>Followed order</h4>
            Cjax uses URL query string to pass parameters into the controller by using function parameters. <br />
            There is more than one way to pass parameters, depending on the way you are using the URL.<br />
            You can pass "followed order" or "alphabetic letters order" onto your methods/functions inside the controllers. <br />
            <?php echo $ajax->code("
//controller/function/arg1/arg2
ajax.php?test/test/123/someID
// this also applies to mod_rewrite urls such as: ajax/test/test/arg1/someID
");?>



    <br />

    <h3>Examples</h3>


    <!-- Code Used -->

            The above URL passes two parameters 123 and someID, test/test indicates the controller and the method.
            Anything after the method will translate into paratemeters. You may pass up to 26 parameteres respectively symbolizing the English Alphabeth.
            <?php echo $ajax->code("
class test  {

    function test(\$arg1, \$arg2)
    {
        echo \$arg1;
        echo '<br />';
        echo \$arg2;
    }
    //prints  123
    //        someID
}
");?>
            Parameters are passed into method/function arguments, and you may access them directly inside your controller.
        </li>
        <li>
            <h4>Alphabetic letter order</h4>
            <br />
            A less Organized way to pass parameters that may accept any order within the URL:
            <?php echo $ajax->code("
ajax.php?controller=test&function=test&a=Hello&c=Hello World&b=World
");?>
            The above URL uses alphabetic letters to pass parameters, and has the same effect as if you used "followed order",
            but gives you the flexiblity to pass any order and additional parameters with different names that can be accessible
            through $_GET or $_REQUEST.
            <?php echo $ajax->code("
class test  {

    function test(\$a, \$b, \$c)
    {
        echo \$a;
        echo '<br />';
        echo \$b;
        echo '<br />';
        echo \$c;
    }
    //prints  Hello
    //        World
    //        Hello World
}
");?>
        </li>
    </ul>
    <h4>Passing Element Values in the URL</h4>
    Sometimes you might need to pass element values such as these of inputs. To accomplish this, in the url pass the element_id
    wrapped with vertical bars.
    <br />
    Example:
    <?php echo $ajax->code("
ajax.php?controller/function/arg1/arg2/|text1|/|checkbox1|
",false);?>
    The above URL will automatically seek for these elements on the HTML document and pass their value in the URL.

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