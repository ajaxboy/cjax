<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();

$ajax->click("button1", $ajax->updateX("content1","innerHTML","id"));
$ajax->click("button2", $ajax->updateX("content1","innerHTML","value"));
$ajax->click("button3", $ajax->updateX("content1","innerHTML","data-info"));
$ajax->click("button4", $ajax->updateX("text1","value","data-info"));

$ajax->click('#logo', $ajax->updateX('#text1','value','src'));

$ajax->click('#logo2', array(
        $ajax->overlayContent("<img id='some-image' src=''>"),
        $ajax->updateX('some-image', 'src','src')
    )
);
?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>UpdateX elements with Ajax</title>
    <?php echo $ajax->init(false);?>
    <style>
        .box {
            position:relative;
            overflow: auto;
            width: auto;
            height: auto;
            margin-right:1px;
            background-color: #CEFFCE;
        }
        input[type=text] {
            width: 300px;
        }
    </style>
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
            UpdateX
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->
    UpdateX  (<span class="req">Cjax 5.9+</span>) is a simple but very powerful feature. Lets you easily change specific data.
    <br />
    With UpdateX you can update images, hidden elements values and more.
    <br /><br />
    UpdateX consists of it being used with <a href="triggers.php">trigger events</a>.
    It lets you update data and other elements based on the element you click on.
    <br />
    Let that sync for a bit, anything you click on you can store any type of information, then you
    can use that information to update other elements on the page.
    <br /><br />
    Of course Cjax already lets you do all data, but this function would allow you to
    continue to update data on the page without making ajax requests. You could add
    extra attributes to elements, UpdateX lets you access these attributes and update
    other element, hidden value, or any object on that page with these attributes.
    This could save you requests to server to retrieve extra data!.
    <br /><br />
    UpdateX works with wildcard selectors as well, you could be interacting with hundreds of elements
    with one line of code you could easily add sofisticated interactions, based on data attributes within these elements.
    <br />

    Say you made an ajax request that returned a many items, when one of the items is clicked you want it to do a few things
    but at the same time, you think that a request to server may not be necesary. Here UpdateX comes handy.
    <br />
    Within the elements attributes you sent the items already containing attributes with the information you want to be used.
    Use UpdateX, when the element is clicked on perform all the actions. You can combine this with other Cjax API's.
    <br />
    For example, display an OverlayContent() window and update its content with UpdateX().
    <br /><br />

    Try the examples provided below, you will get the picture.

    <h3>Example #1</h3>


    Here are provided some example of usage, but keep in mind, there could be hundreds of different ways UpdateX could be
    used, for instance - 'innerHTML' is the property being used in some of the examples below. You can literally use
    any property existing to the element.
    <br />
    If you were to update other type of elements, such as a image, then you could update 'src' instead of the innerHTML.

    Note that the 'data-info' attribute you see in one of the examples below is completly made up, you can  make up your own data-x attributes.
    You are just placing information so you can access it later.
    <br />
    <!-- Code Used -->
    <br />
    <?php
    echo $ajax->code("
    //updates #content1's html with the id of the element you clicked on
    \$ajax->click('#button1', \$ajax->updateX('#content1','innerHTML','id'));


    //updates #content1's html with the value of the button you clicked on
    \$ajax->click('#button2', \$ajax->updateX('#content1','innerHTML','value'));


    //updates #content1's html with the value of the button you clicked on
    \$ajax->click('#button3', \$ajax->updateX('#content1','innerHTML','data-info'));

");?>

    <?php
    echo $ajax->code("

    <input type='button' id='button1' value='Update box below with content'>

    <input type='button' id='button2' value='Update box below with content'>

    <input type='button' id='button3' value='Update box below with content' data-info='Extra attribute here!'>




", 'HTML', true);?>
    <!-- HTML -->

    <br /><br />

    <input type='button' id='button1' value='Update box below with content'>

    <input type='button' id='button2' value='Update box below with content'>

    <input type='button' id='button3' value='Update box below with content' data-info='Extra attribute here!'>

    <div class='box' id='content1'></div>
    <br />



    <h3>Example #2</h3>



    <br />
    Code used:
    <?php
    echo $ajax->code("
    //updates #text's value
    // when you click the logo with id 'logo', text1 gets update, its value, for the images src.
    \$ajax->click('#logo', \$ajax->updateX('#text1','value','src'));



");?>


    <?php
    echo $ajax->code("

    <img id='logo' src='http://cjax.sourceforge.net/media/logo.png' border=0/>




", 'HTML', true);?>

    <h5>Click the logo image below</h5>

   <img id='logo' src='http://cjax.sourceforge.net/media/logo.png' border=0/>
    <br />

    <input type="text" id="text1" />

    <br /><br />

    <h3>Example #3</h3>



    Code used:
    <?php
    echo $ajax->code("
    //updates #overlayContent's image
    // #some-image, is the placeholder we put in the overlay. first src - we are saying to update that property in the #some-image element.
    // the second src, is the property we pick from the element that is clicked, which has to be an image, because we binded the click to an image.
    \$ajax->click('#logo2', array(
        \$ajax->overlayContent(\"<img id='some-image' src=''>\"),
        \$ajax->updateX('#some-image', 'src','src')
        )
    );

");?>


    <?php
    echo $ajax->code("

       <img id='logo2' src='http://cjax.sourceforge.net/media/logo.png' border=0/>




", 'HTML', true);?>


    <h5>Click the logo image below</h5>

    <img id='logo2' src='http://cjax.sourceforge.net/media/logo.png' border=0/>



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
