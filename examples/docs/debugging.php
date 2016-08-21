<?php
//core file, reference..
require_once "../ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="../resources/css/user_guide.css" media="all">
    <title>Debugging</title>
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
            <a href="../">Demos</a> &nbsp;&#8250;&nbsp;
            Debugging
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

    <h3>Debugging Cjax</h3>
    <p>
        <!-- Text -->
        Debugging is an essential part of building ajax functionality.  Without it, wouldn't know how you got this far.


    </p>
    <p>
        To debug Cjax, you are required to use a browser console. Most modern browsers will already have a console or 'web inspector' bult-in.
        <a target="_blank" href="http://getfirebug.com/">Firefox</a>,  Chrome, <a target="_blank" href="https://developer.apple.com/library/iad/documentation/AppleApplications/Conceptual/Safari_Developer_Guide/GettingStarted/GettingStarted.html">Safari</a>, IE, MS Edge, come included with one. Any of them will do nicely.
        Firefox's plugin <a target="_blank" href="http://getfirebug.com/">firebug</a> is highly recommend to debug Cjax, as it includes many useful tools and is second to none compared to the others.
        <br />
    </p>

    <p>
        The console will feed you everything you need to know about what's hapenning with Cjax.
        From whether a file is loaded or not, to whether you enter
        a valid URL or if there is a server error,   all this important and many times crusial information can be found on the console.
    </p>

    <p>
        Particularly, there are certain things to watch out for, coming out of the console if you are testing any type of ajax call.
    </p>

    <p class="note">
        Keep in mind that web-inspector include many tabs. Cjax information can be found in the response tab, 95% of the time.
        The network tab, some times is useful as well to get information about whether a file has been loaded, or if a file has been hard-cached.
    </p>
    <br />
    <P>
        A simple look at this can give you so much information, and can help you be on your way to focus on building more things and spend
        less time wondering what went wrong.
    </P>
    <p>
        <img src="../resources/images/console_error.png" />
        <ul style=" list-style-type: decimal;">
            <li>
                1 Information about the URL, including any parameters passed
            </li>
            <li>
                2 Response Status, it could be a forbidden status (403) or a server error (500),  this information is useful for you to know where to look next.
            </li>
            <li>
                3  Response Tab
            </li>
            <li>
                4 Response,  to get this information click the URL being displayed. If an error occured, most of the time you will be able to see that error here. That error
                is the key to keep you up and running as it includes what went wrong, and where you need to look to fix it.
            </li>
        </ul>
    </p>
    <br />
    <p>
    <ul>
    <li>
        Request status response
        <ol>
           <li>
               This is a number status the server responds with depending on how the request went. 404, indicating that the controller file was not found.
                500 indicating a server error, and there are other types of responses you may see.
                If there is a php error, the console always will give you the error message, unless you have error messaging completly turned off in your server settings.
               If you can't find the error on the console, the next place to look is your apache log files.
           </li>
        </ol>
    </li>
    <li>
        Console log
        <ol>
            <li>
                If there is an error, for instance produced some where in the Cjax JS library, or in a plugin, the error will show up in the
                console. This error can give you explicit information of why something didn't work. Many times it will give the specific line number
                where the error occured, and you can click it and it will take you to the file in question.
            </li>
            <li>
                A plugin's dependencies could trigger one of the console errors. Dependencies are encapsulated within a plugin, they are loaded
                dynamically from the plugin directory by the plugin js file in cjax/plugins/[plugin-name], dependecies be found within the same directory.
            </li>
        </ol>
    </li>
    <li>
        No Error
        <ol>
            <li>
                If you are looking at the console, you click on the URL, and view the response, and you do not see an error
                (and the response status is 200)  - this could be something
                within the scope of your ajax controller.
                Try an exit test  -  eg:  exit("It's getting here"); , then go to back to the console and
                if you see this message it's telling you that there is no problem, and the response you expect, is not a Cjax error, rather
                a product of your code or lack of.
            </li>
        </ol>
    </li>
       <li>
           Plugin Errors
           <ol>
               If you are within a plugin, you can use CJAX.debug = true;,  to enable further logs to show up in the console.
           </ol>
       </li>
    </ul>
    </p>

   <p>
       These methods described above, should be able to catch 99% of any issue you may experience. If you experience something different, be sure to create
       an issue in: <a target="_blank" href="https://github.com/ajaxboy/cjax/issues">https://github.com/ajaxboy/cjax/issues</a>.
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
