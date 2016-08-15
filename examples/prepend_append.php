<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>Prepend, Append, Before, After</title>
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
            Prepend/Append
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->
    <h2>Prepend /Append /Before / After</h2>
    (5.0-RC2+)
    <br />
    <br />
    You can append or prepend HTML into any div/span or other elements on the page.
    <br />



    <br />

    <h3>Examples</h3>


    <!-- Code Used -->
    <h4>Example</h4>
    <?php echo $ajax->code(
        "
\$ajax->prepend('#div1','Some HTML here');

\$ajax->append('#div1','Some more HTML here');
"
    );?>
    You can  also use before, and after, and it will have the same effect.
    <h4>Example</h4>
    <?php echo $ajax->code(
        "
\$ajax->before('#div1','Some HTML here');

//insert html inside HTML's body before the body's content.
\$ajax->before('body','Some HTML here');

\$ajax->after('#div1','Some more HTML here');
"
    );?>

    You may also  append/prepend other elements on the page.
    While HTML/text appends to the inner HTML/text, appending elements
    will append it to upper in the hierarchy or  and prepend to the lower.
    <h4>Example</h4>
    <?php echo $ajax->code(
        "
//insert div2 before div1
\$ajax->before('#div1','#div2');

//insert div2 after div1
\$ajax->after('#div1','#div2');
"
    );?>

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