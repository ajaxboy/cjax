<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


$ajax->click("button1",$ajax->call("ajax.php?click_ajax_request/click_button/Hello!"));

$ajax->click("button2",$ajax->call(array('click_ajax_request','click_button','Hello!')));

?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>Simple ajax request binded to a button</title>
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
            Simple ajax request binded to a button
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <h3>Examples</h3>

    <p>
    In this example there is a button you click on, and it <a href="triggers.php">triggers</a> an <a href="call.php">ajax request/call</a>.
    The request is routed to an <a href="docs/controllers.php">ajax controller</a>.

    The ajax controller goes a step further
    and triggers a <a href="display_messages.php">success message</a>, right from the back-end, and that is  what you see as end result.
    </p>


    <?php
    echo $ajax->code("
        \$ajax->click(\"#button1\",\$ajax->call(\"ajax.php?click_ajax_request/click_button/Hello!\"));
        ");
    ?>

    <?php
    echo $ajax->code("
        <input type='button' id='button1' value='Click this button to make an ajax request'>
        ", 'HTML', true);
    ?>
    <!-- HTML -->
    <input type='button' id='button1' value='Click this button to make an ajax request'>
    <div id='response'></div>


   <h5>As of <span class="req">CJAX 5.9+</span></h5>

    <?php
    echo $ajax->code("
        \$ajax->click(\"button2\",\$ajax->call(array('click_ajax_request','click_button','Hello!'));
        ");
    ?>

    <?php
    echo $ajax->code("
        <input type='button' id='button2' value='Click this button to make an ajax request'>
        ", 'HTML', true);
    ?>
    <input type='button' id='button2' value='Click this button to make an ajax request'>
    <div id='response'></div>


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