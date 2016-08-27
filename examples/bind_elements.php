<?php

//core file, reference..
require_once "ajax.php";
//initiate CJAX..

$ajax = ajax();


/**
 * You can pass two elements ids separate by pipe lines.
 */
$ajax->click('#link1, #link2', $ajax->call("ajax.php?bind/bind_elements") );


/**
 * Update Style, to green.
 * Note: You can update any property in CSS, make sure you know their JavaScript name,
 * as they are are not the same as they in styles sheets.
 * See a list here: http://cjax.sourceforge.net/examples/docs/dom_style_list.php
 */
$style = array(
    'style' => array(
        'backgroundColor' => 'green'
    ));

$ajax->click('.red', $ajax->prop($style));


/**
 * Update Style, to yellow.
 * Note: You can update any property in CSS, make sure you know their JavaScript name,
 * as they are are not the same as they in styles sheets.
 * See a list here: http://cjax.sourceforge.net/examples/docs/dom_style_list.php
 */
$style = array(
    'style' => array(
        'backgroundColor' => 'yellow'
    ));

$ajax->click('.blue', $ajax->prop($style));



/**
 * Reset style property before we can swap (in case they have changed)
 * Swapping a class doesn't particularly overwrite the style, you would end up with the class swapped
 * but they would look the same color provided by style.backgroundColor.
 */
$style = array(
    'style' => array(
        'backgroundColor' => ''
    ));
$ajax->click('.grey', $ajax->prop($style,'.blue , .red'));

/**
 * Swap class
 */
$ajax->click('.grey', array($ajax->swap('blue','red')));


### look inside controllers/bind.php for response code sample.
?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>Bind Elements</title>
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
            Bind Elements
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

        <!-- Text -->
    <h2>Bind elements to commands</h2>
    <p>
    <br />
    Basically both anchor are hooked by the same event used
    </p>

    <h3>Examples</h3>


    <!-- Code Used -->

<?php
echo $ajax->code("
\$ajax->click(\"#link1,#link2\",\$ajax->call(\"ajax.php?bind/bild_elements\"));
");?>

<?php
echo $ajax->code("
    <a href='#' id='link1'>Click Me (element 1)</a>
    <a href='#' id='link2'>Click Me (element 2)</a>
",'HTML', true); ?>
    <br />
    <a href='#' id='link1'>Click Me (element 1)</a>
    <br />
    <a href='#' id='link2'>Click Me (element 2)</a>


    <h4>Using Advanced Selector <span class="req">Cjax 5.9+</span> </h4>
    <!-- HTML -->
    <p>
    You can use wildcard selectors, or class selectors, or any type of advanced selectors, supported by popular libraries.
    </p>
    <p>
        In these examples we feature CSS/style properties, you can use any <a target="_blank" href="docs/dom_style_list.php">available property</a> in CSS.
    </p>
    <p class="note">
        This does not limit the properties you may use to CSS. You may use any DOM property entirely, that the element may support.
    </p>

    <p>If you know CSS, you already know how to use this whole system, without much of a learning curve. If you know even a little
    about the properties in JavaScript, this is a walk in the park. Otherwise you can just review the <a target="_blank" href="docs/dom_style_list.php">docs</a>
    </p>

    <p class="note">
        Although advanced selectors are available since Cjax 5.7 (2012), the uses in these examples are new. For example: Using
        <span clas="keyword">prop()</span> and <span clas="keyword">swap()</span> methods.
    </p>
    <?php
    echo $ajax->code("


     //Apply CSS properties to any element you click on, containing the class '.red'. When clicked on, will change to green.
    \$style = array(
        'style' => array(
            'backgroundColor' => 'green'
        ));

    \$ajax->click('.red', \$ajax->prop(\$style));


    //Apply CSS properties to any element you click on, containing the class '.blue'. When clicked on, will change to yellow.
    \$style = array(
        'style' => array(
            'backgroundColor' => 'yellow'
        ));

    \$ajax->click('.blue', \$ajax->prop(\$style));


    //Reset the style.backgroundColor property style
    \$style = array(
    'style' => array(
        'backgroundColor' => ''
    ));

    //prop() supports parameter to specify selectors to apply the properties to.
    //If not specified - by default it would apply them to the element you click on.
    \$ajax->click('.grey', \$ajax->prop(\$style,'.blue , .red'));


    //When you click on any element that contains the class .grey, it will trigger a swap of class red and blue.
    \$ajax->click('.grey', \$ajax->swap('blue','red'));

    ");?>

    <?php
    echo $ajax->code('

        <div class="red"></div>
        <div class="blue"></div>
        <div class="red"></div>
        <div class="blue"></div>
        <div class="red"></div>
        <div class="grey"></div>

    ',"HTML",true);?>



    <p>
    <div>
        <div class="red"></div>
        <div class="blue"></div>
        <div class="red"></div>
        <div class="blue"></div>
        <div class="red"></div>
        <div class="blue"></div>
        <div class="grey"></div>
        <div style="clear: both"></div>
    </div>
    </p>



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