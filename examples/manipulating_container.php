<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>Ajax Manipulating Elements</title>
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
            Manipulating Elements
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->

    <h2>Manipulating Elements/Containers</h2>
    With the release of 5.0-RC1 One of the new features is the ability to manipulate any element on the HTML document through PHP.
    <br />
    All elements (divs,spans,buttons,images,anchors, etc) will accept general JavaScript properties if they are passed in an array.<br />
    In addition some elements may accept Cjax Properties as well such as ajax requests, or ajax form,
    continue reading to see some examples.


    <br />

    <h3>Examples</h3>


    <!-- Code Used -->
    The following example adds style properties to div HTML element with the ID of "div_container". <br />
    These style properties  are a small example, there is no limitation
    on which properties you may add, to see a full list of style properties <a target="_blank" href="dom_style_list.php">click here</a>.
    <?php
    echo $ajax->code("
\$ajax->div_container = array(
	'style' => array(
		'backgroundColor' => '#FF9E3E',
		'width' => '300px',
		'heigh' => '200px'
));");
    ?>
    You may also assign/set direct element properties that would otherwise go in their tag constructor.
    You may set element properties to any element as long that element has an id.
    <h5>Example</h5>
    <?php
    echo $ajax->code("
\$ajax->html_table = array('width' => 600);

\$ajax->td_id = array('width' => 200,'height' => 100, 'colspan' => 3);

\$ajax->tr_id = array('innerHTML' => '<td>some data</td>');

");?>
    <h5>Example</h5>
    <?php
    echo $ajax->code("
\$ajax->some_image = array('width' => 300,'height' => 200, 'src' => 'some/image/url');

//see 'Main Property' documentation for 'Elements Properties'
//changes the src property of an image
\$ajax->some_image = 'some/image/url';
");?>
    <br />


    While you assign some properties to an element, you may still continue manipulating it. All properties accumulate.
    <br /><br />
    If the container has node of type div or span, you may assign Ajax requests to it, the response of the request will flow to the container.

    <?php
    echo $ajax->code("
\$ajax->div_container = \$ajax->call(\"url/to/a/controller\");
");?>
    <br />
    If the element you'd like to manipulate is a button, you may assign Ajax Forms to it (element must be inside a form).
    <?php
    echo $ajax->code("
\$ajax->button_id = \$ajax->form(\"url/to/post/action\");
");?>
    Assigning a string to the button will change it's value/label. While it still submits the ajax form above.
    <?php
    echo $ajax->code("
\$ajax->button_id =  \"Button Label\";
");?>

    <?php
    echo $ajax->code("
//change the id of the DIV
\$ajax->div_container = array('id' => 'New_div_id');

//div_container does exist anymore, now is New_div_id
\$ajax->New_div_id = \"Hello!\";
");?>

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







