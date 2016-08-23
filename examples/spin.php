<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();

$ajax->spin('.spinning_text', 'spin');
$ajax->spin('.flipping_text', 'flip');
$ajax->spin('.flip_cube', 'flipCube');
$ajax->spin('.flip_up_cube', 'flipCubeUp');


?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>Spin</title>
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
            Spin Effect
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
    <h2>Spin Effect <span class="req">Cjax 5.9+</span></h2>

    These text effects to spin, rotate, and apply other effects to text elements.


    <h4>Examples</h4>

    <p>
    Please note, these examples are based of a 3rd party component, Cjax only integrates these effects into a Cjax plugin for you to use.
    </p>

    <!-- Code Used -->
    <h3>Spin</h3>

    <?php
    echo $ajax->code("
	//
	\$ajax->spin('.spinning_text', 'spin', 200);


");
    ?>
    <?php
    echo $ajax->code("

	    <span class=\"spinning_text\">Spinning Text</span>


", 'HTML', true);
    ?>

    <!-- HTML -->

    <span class="spinning_text">Spinning Text</span>
    <span>Spinning Text</span>
    <span class="spinning_text">Spinning Text</span>
    <span>Spinning Text</span>



    <!-- Start new item-->

    <h3>FlipText</h3>

    <?php
    echo $ajax->code("

	\$ajax->spin('.flipping_text', 'flip');


    ");
    ?>

<?php
echo $ajax->code("

	    <span class=\"flipping_text\">Flipping Text</span>


", 'HTML', true);
?>
    <span class="flipping_text">Flipping Text</span>
    <span>Flipping Text</span>
    <span class="flipping_text">Flipping Text</span>
    <span>Flipping Text</span>




    <!-- Start new item-->

    <h3>FlipCube</h3>

    <?php
    echo $ajax->code("

	\$ajax->spin('.flip_cube', 'flipCube');


    ");
    ?>
    <?php
    echo $ajax->code("

	    <span class=\"flip_cube\">FlipCube Text</span>


", 'HTML', true);
    ?>
    <span class="flip_cube">FlipCube Text</span>
    <span>FlipCube Text</span>
    <span class="flip_cube">FlipCube Text</span>
    <span>FlipCube Text</span>



    <!-- Start new item-->

    <h3>flipCubeUp</h3>

    <?php
    echo $ajax->code("

	\$ajax->spin('.flip_up_cube', 'flipCubeUp');


    ");
    ?>

    <?php
    echo $ajax->code("

	    <span class=\"flip_up_cube\">flipCubeUp Text</span>


", 'HTML', true);
    ?>
    <span class="flip_up_cube">flipCubeUp Text</span>
    <span>flipCubeUp Text</span>
    <span class="flip_up_cube">flipCubeUp Text</span>
    <span>flipCubeUp Text</span>



    <br />
    <h3>Available Effects</h3>

    <table cellspacing="1" cellpadding="0" border="0" class="tableborder" style="width:100%">
        <tbody><tr>
            <th>Effect</th>
            <th>Options/Description</th>
        </tr>
        <tr>
            <td class="td"><strong>dissolve</strong></td>
            <td class="td">default effect</td>
        </tr>
            <td class="td"><strong>flip</strong></td>
            <td class="td">
                add a 3rd parameter to control the speed eg. 1000.

            </td>
        </tr>
        <tr>
            <td class="td"><strong>spin</strong></td>
            <td class="td">
            </td>
        </tr>
        <tr>
            <td class="td"><strong>flipUp</strong></td>
            <td class="td">
                add a 3rd parameter to control the speed eg. 2000.
            </td>
        </tr>
        <tr>
            <td class="td"><strong>flipCube</strong></td>
            <td class="td">
            </td>
        </tr>
        <tr>
            <td class="td"><strong>flipCubeUp</strong></td>
            <td class="td">
            </td>
        </tr>
        <tr>
            <td class="td"><strong>fade</strong></td>
            <td class="td">
            </td>
        </tr>

        </tbody></table>
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
