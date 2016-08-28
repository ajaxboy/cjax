<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


//The settings are optional.

//overlay using cache
//Elemene ID, URL
//no settings  ( default settings)
$ajax->click("#overlay_cache",$ajax->overlay("ajax.php?overlay/view_overlay",array(),true));



//no cache
//with dimension settings
// All of these settings are optional. If not specified, default settings are used.
// also these settings can be associated with css style properies, but may differ a little.
$settings['top'] = '150px';
$settings['left'] = '20%';
$settings['transparent'] = '60%'; // from 1 transparent to 100 solid, how transparent should it be? default is 80.
$settings['color'] = '#FF8040'; //color will only work if the setting above (transparent) is present.
$settings['click_close'] = true;// click anywhere on the screen to close the overlay
$ajax->click("#overlay_no_cache",$ajax->overlay("ajax.php?overlay/view_overlay",$settings));


//pass content..
//with settings..
$ajax->click("overlay_content",$ajax->overlayContent("Hello World",array('top'=> '200px')));


$ajax->click("#overlay_dialog", $ajax->dialog('Hello World','Dialog#1'));

?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>Ajax Overlays in PHP</title>
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
            Overlays
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->

    These Ajax Overlays are built in Cjax's framework API. All overalys takes one line code to produce and you may also specify settings such as color and width.
        You may supply the content/html directly or  provide a URL to fetch the content.


    <br />

    <h3>Examples</h3>


    <!-- Code Used -->
    <br />
    <?php
    echo $ajax->code("
//Overlay #1
\$ajax->click(\"#overlay_cache\",\$ajax->overlay(\"ajax.php?overlay/view_overlay\",array(),true));


//Overlay #2
\$settings['top'] = '150px'; //how far from the top of the screen
\$settings['left'] = '20%'; //how far from the left of the scree
\$settings['transparent'] = '60%'; //transparency percentange
\$settings['color'] = '#FF8040'; //change color
\$settings['click_close'] = true;// click anywhere on the screen to close the overlay
\$ajax->click(\"#overlay_no_cache\",\$ajax->overlay(\"ajax.php?overlay/view_overlay\",\$settings));


//Overlay #3
\$ajax->click(\"#overlay_content\",\$ajax->overlayContent(\"Hello World\",array('top'=> '200px')));


//Overlay #4
\$ajax->click(\"#overlay_dialog\",\$ajax->dialog(\"Hello World\",'Dialog#1'));

", true, true);?>


    <!-- HTML -->

    <br />
    <br />
    #1 triggers an ajax URL, and displays the response in the content area. The response is cached then the
    next time it is requested, it displays the response from the cached request, does not make a new request.
    <br />
    <a id='overlay_cache' href='#'>See overlay (using cache)</a>
    <br />
    <br />
    #2 Triggers an ajax URL and refreshes the content each time by making a new request. Also demonstrate how alternatively the content window can be
    positioned in certain parts of the screen, not necesarly in the middle. It is also possible to customize colors.
    <br />
    <a id='overlay_no_cache' href='#'>See overlay (no cache)</a>
    <br />
    <br />
    #3 Does not trigger a URL, the content is provided directly instead, and displayed, as simple as that.
    <br />
    <a id='overlay_content' href='#'>See overlay content</a>
    <br />
    <br />
    #4 Show overlay dialog
    <br />
    <a id='overlay_dialog' href='#'>See a formatted overlay dialog</a>

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