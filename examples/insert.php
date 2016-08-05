<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


$ajax->insert('#response','This <span style=\'color:red\'>HTML</span> was inserted into the start #response<br />');

$ajax->insert('#response','This <span style=\'color:red\'>HTML</span> was inserted into the end #response<br />', true);

$ajax->insert('#response','#other_element', true);


?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>Ajax Insert Data</title>
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
            Ajax Insert
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->
    Inserts html or elements inside an element.
    <br />

    <h3>Examples</h3>


    <!-- Code Used -->
    <?php
    echo $ajax->code("
//Insert into the start of an #response
\$ajax->insert('#response','This <span style=\'color:red\'>HTML</span> was inserted into the start #response');
//Insert into the end of an #response
\$ajax->insert('#response','This <span style=\'color:red\'>HTML</span> was inserted into the end #response', true);

//move #other_element into the end of #response
\$ajax->insert('#response','#other_element', true);

//move #other_element into the start of #response
\$ajax->insert('#response','#other_element');

", true, true);
    ?>

    <!-- HTML -->

    <div id='response'>[this is what what originally in #response]</div>
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    <div id='other_element'>#Other element</div>

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
