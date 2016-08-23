<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();

$ajax->keyup('search',$ajax->call('ajax.php?search/string/|search|','search_result'));

?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
    <title>Ajax Search</title>
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
            Ajax Search
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


    <!-- Text -->
    <br />
    Try typing a letter, it should find all finding starting with that letter.
    This is just a  demonstration, funcationality is intended to be adapted with a database. The backend controller is test data only.
    <br /><br />


    <br />

    <h3>Examples</h3>


    <!-- Code Used -->
    <br />
    <?php
    echo $ajax->code("
//first bild text element search to the ajax request
//pass |search|, passes the value of search field.
//search_result is the contained div
//keyup is the event (see: \$ajax->Exec() in API table)
\$ajax->keyup('search',\$ajax->call('ajax.php?search/string/|search|','search_result'));
");?>
    Controller:
    <?php
    echo $ajax->Code("
//controllers/search.php
class search {


	function string(\$string)
	{
		// Fill up array with some data
		\$a[]=\"Anna\";
		\$a[]=\"Amanda\";
		\$a[]=\"Amelia\";
		\$a[]=\"Armando\";
		\$a[]=\"Brittany\";
		\$a[]=\"Bob\";
		\$a[]=\"Bill\";
		\$a[]=\"Cinderella\";
		\$a[]=\"Cindy\";
		\$a[]=\"Carlos\";
		\$a[]=\"Diana\";
		\$a[]=\"Doris\";
		\$a[]=\"Eva\";
		\$a[]=\"Eve\";
		\$a[]=\"Evita\";
		\$a[]=\"Fiona\";
		\$a[]=\"Gunda\";
		\$a[]=\"Hege\";
		\$a[]=\"Inga\";
		\$a[]=\"Johanna\";
		\$a[]=\"Kitty\";
		\$a[]=\"Linda\";
		\$a[]=\"Nina\";
		\$a[]=\"Ophelia\";
		\$a[]=\"Petunia\";
		\$a[]=\"Raquel\";
		\$a[]=\"Sunniva\";
		\$a[]=\"Tove\";
		\$a[]=\"Unni\";
		\$a[]=\"Violet\";
		\$a[]=\"Liza\";
		\$a[]=\"Liz\";
		\$a[]=\"Elizabeth\";
		\$a[]=\"Ellen\";
		\$a[]=\"Wenche\";
		\$a[]=\"Vicky\";
		\$a[]=\"Quinton\";
		\$a[]=\"Yancy\";
		\$a[]=\"Yakecan\";


		\$out = array();

		foreach(\$a as \$v) {
			if(substr(strtolower(\$v), 0, strlen(\$string)) == strtolower(\$string)) {
				\$out[] = \$v;
			}
		}

		die('<pre>'.print_r(\$out,1).'<pre>');

	}

}
", true, true);
    ?>


    <!-- HTML -->

    Type Something <input type='text' id='search' />
    <div id='search_result'>
    </div>
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