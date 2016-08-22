<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>Custom Development</title>
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
            Custom Development
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">

    <div style="margin: 20px;"> <div style="font-size: 12px;padding: 5px;">Project development is new to github. Give us a <span id="star">star</span>.</div>
        <iframe id='istar' src="https://ghbtns.com/github-btn.html?user=ajaxboy&repo=cjax&type=star&count=true" frameborder="0" scrolling="0" width="170px" height="20px"></iframe>
        <iframe src="https://ghbtns.com/github-btn.html?user=ajaxboy&repo=cjax&type=watch&count=true&v=2" frameborder="0" scrolling="0" width="170px" height="20px"></iframe>
    </div>

    <h3>Custom features in your application or website?</h3>
    <p>
        <!-- Text -->
        Seen a feature you love, and you can't install or implement it yourself? we'll do it for you!
   </p>
    <p>
        We are available for hire. Here is how <b>it brakes down</b>:
        <br />
        <br />
        We install or implement certain feature you'd love to have, for example the ajax uploader or the autocomplete, pagination, etc.
        If we do as shown in the  example. We'll charge of a flat fee.
        <br />
        If you'd like it customized, with specific changes, or additions, to fit specific needs of your website or application, then we'll charge you hourly.
        <br />
        <br />
        If you'd like to "ajaxify" your entire application or website, we may be available for that as well, let us know what you have in mind.
        <br />
        <br/>
        Let us know!, hire the experts directly! - <a href="mailto:&#099;&#106;&#120;&#120;&#105;&#050;&#049;&#064;&#103;&#109;&#097;&#105;&#108;&#046;&#099;&#111;&#109;?subject=Custom Development">contact us</a>
        <br />
        <br />
        Be sure to be as detailed as possible!, thank you, and hope to hear from you soon.

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
