<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


$values = array('text1','text2', 12345);
$ajax->click('#link_values', $ajax->call(array('call','options', $values)));

$ajax->click('#link_text3', $ajax->call(array('call','cache', null, array('cache' => true))));

$ajax->click('#link_container', $ajax->call(array('call','container'), 'my_div'));

$ajax->click('#link_confirm', $ajax->call(array('call','confirm'), null,'Are you absolutely sure you want to continue?'));



?>
<!doctype html>
<head>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">

    <title>Call</title>
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
            call
        </td>
        <td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
    </tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">

    The call() <span class="keyword">method</span> allows you to make ajax requests to <a href="controllers.php">ajax controllers</a>.
    You can pass multiple parameters to this method.

    <br />


    <p>Call() takes the following parameters</p>


    <table cellspacing="1" cellpadding="0" border="0" class="tableborder" style="width:100%">
        <tbody><tr>
            <th>Variable</th>
            <th>Required</th>
            <th>Type</th>
            <th>Options</th>
            <th>Description</th>
        </tr>
        <tr>
            <td class="td"><strong>$url</strong></td>
            <td class="td">Yes</td>
            <td class="td">Mixed</td>
            <td class="td">
                string <span class="param">$url</span>
                <br />
                <p>
                array <span class="req">Cjax 5.9+</span>
                <br />
                as an array the options are as follow:
                <br />
                string <span class="param">controller</span>, string <span class="param">method</span>, mixed <span class="param">parameters</span>, array <span class="param">options</span>
                <br />
                parameters - can pass a string with one or an array with more element ids, for its value.
                <br />
                options - cache =  true/false
                </p>
            </td>
            <td class="td">This url is fetched with ajax</td>
        </tr>
        <tr>
            <td class="td"><strong>$container_id</strong></td>
            <td class="td">No</td>
            <td class="td">String</td>
            <td class="td">div, span, p, td, etc
                <br />
                You must echo your desire content from the controller/method.
            </td>
            <td class="td">
                Update a specific container with this pararement, any text the ajax call comes back with in the response
                will be automatically propagated to this container.
            </td>
        </tr>
        <tr>
            <td class="td"><strong>$confirm</strong></td>
            <td class="td">No</td>
            <td class="td">String</td>
            <td class="td">string $message</td>
            <td class="td">Need to ask "Are you sure?" Before triggering the call() ?</td>
        </tr>
        </tbody></table>
    <br />

    <h3>Examples</h3>


    <h5>Simple Usage</h5>

    You can use the call() method without any other parameters. It will trigger the ajax request in the instant.
    <?php
    echo $ajax->code("
	\$ajax->call(\"ajax.php?controller/method\");


	//As of 5.9 you can do this way
	\$ajax->call(array(\"controller\",\"method\"));
	");
    ?>
    <h5>More Usages</h5>

    You can use the call() <span class="keyword">method</span> with any of the Cjax <a href="docs/triggers.php">trigger events</a>.
    <?php
    echo $ajax->code("

    //the most common usage
	\$ajax->click(\"#link1\", \$ajax->call(\"ajax.php?controller/method\"));


	//used in a text-type field.
    \$ajax->change(\"#text1\", \$ajax->call(\"ajax.php?controller/method\"));


    //used in a text-type field. In keyup event, basically every time you type
    \$ajax->keyup(\"#text1\", \$ajax->call(\"ajax.php?controller/method\"));

	");
    ?>

    <h5>Cjax 5.9+</h5>

    The call <span class="keyword">method</span> remains the same with the exception of the <span class="param">url$</span> argument, which now supports arrays as well as the previous method.
    As of Cjax 5.9, you can pass an array to the <span class="param">url$</span> argument specifying a <span class="keyword">controller</span> and a <span class="keyword">method</span>, and additional options.
    Passing an array allows you to enter the <span class="keyword">controller</span> , <span class="keyword">method</span>, without specifying the dispatcher file ajax.php.
    <br /><br />
    You can pass a 3rd parameter in the array to pass element values, generelly you would pass these in the url in between
    pine lines eg. |text1| would send the value of a text field which id is text1. You may pass one parameter, a string or
    you can pass an array of element, to pass their value. If the element is not found on the page, the raw text will be passed.
    <br /><br />

    <?php
    echo $ajax->code("

    //pass array
    \$ajax->call(array('controller','method'));


    //pass array with controller, method and one value
    \$ajax->call(array('controller','method', 'text1'));

	");
    ?>

    In the 3rd example below, we are passing multiple element values, as well as a direct id, that will work just fine.


    <?php
    echo $ajax->code("

    //pass array with controller, method and multiple values
    \$values = array('text1','text2', 12345);
    \$ajax->click('#link_values', \$ajax->call(array('controller','method', \$values));


    ",true,true);
    ?>

    <br />
    <a href="#" id="link_values">Test</a>
    <br /><br />
    <input type="text" id="text1" value="Text 1 Value"/>
    <br /><br />

    In the example above, we send text1, text2, and 12345. Since text1 element id exists, it passes its value, and text2
    does not exist, it just passes the raw text, all numeric values are passed as they are.


    <h5>Options / Caching</h5>

    The <span class="param">$url</span> parameter used as a array as explained in the previous section can support even more parameters.
    <br />
    One of the parameter is <span class="param">$options</span> parameter. Currently $options only have one option called cache.
    <br /><br />

    This cache option, lets you specify whether you want Cjax to cache the current ajax request. The ajax request is cached by saving
    the url as a unique key, so if you make more than one request to the same url, the response of the first request is always returned.
    If the url changes, then it will go through the same process. Say if you are sending a different id on within the same ajax request
    it will cache each one of these calls, the second call to the same url doesn't make it to the server, instead the first response is re-used.


    <?php
    echo $ajax->code("

    //using caching,
	\$ajax->click('#text3', \$ajax->call(array('controller','method', null, array('cache' => true)));


	", true, true);
    ?>

    <br />
    <a href="#" id="link_text3">Test</a>
    <br /><br />



    <h2>Parameters</h2>


    <h5>Container</h5>
    The call() <span class="keyword">method</span> contains 3 parameters and on itself, and the first <span class="param">parameter</span> $url
    can be used in two different ways. As a string and as an array.
    <br />
    This method also has other two parameters $container_id,   which allows pass a container id, (a div, span, td, etc) which you would want
    to be updated with the response of the ajax call.  If you intend to update something specific on the page this is a straight forward way
    to do it. For this to work, you will need to echo the content inside the controller method.
    <br />
    <br />


    <?php
    echo $ajax->code("

    //using container
	\$ajax->click('#link_container', \$ajax->call(array('call','container'), 'my_div'));


	", true, true);
    ?>
    <br />
    <a href="#" id="link_container">Test</a>
    <br />
    <div id="my_div"></div>
    <br /><br />


    <h5>Confirm</h5>

    The last parameter <span class="keyword">method</span> call() uses is  <span class="param">$confirm</span>. With this
    youu can ask as user if he is sure he wants to continue, and if the user clicks Ok, the ajax request continues, otherwise it cancels.

    <?php
    echo $ajax->code("

    //using container
	\$ajax->click('#link_confirm', \$ajax->call(array('call','confirm'), null,'Are you absolutely sure you want to continue?'));


	", true, true);
    ?>
    <br />
    <a href="#" id="link_confirm">Test (Click Ok)</a>
    <br />
    <br />
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
