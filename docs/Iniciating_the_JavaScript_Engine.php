<?php

require 'ajax.php';

?>
<head>
<?php echo $ajax->init();?>
<title>Ajax Framework | Initial Setup</title>
</head>
<h2>Iniciating the JavaScript Engine</h2>
<br />
To initialize the JavaScript library included with Cjax,  have the $ajax Object do it for you, <br />
<br />
simply in the HEAD of the HTML page do:
<?php echo $ajax->code("
<head>
<?php echo \$ajax->init(); ?>
</head>  
", false);?>
<br />
$ajax->init() will print the script tag of cjax.js. 
<br /><br />
As of version 5.0-beta, By default the minified version of cjax.js is invoked, but you can change that by passing false in the init function, eg:  $ajax->init(false), then the full version would be used.
<br /><br />
- OR -
<br /><br />
As of 5.0-RC2 you can also do this:
<br /><br />
<?php echo $ajax->code("
<head>
<?php echo \$ajax->init('http://yoursite/url/here/'); ?>
</head>  
", false);?>
Where it says "http://yoursite/url/here/" Enter the path where ajax.php is, but withouth the "ajax.php".
<br /><br />
- OR - a work around for using init() function -
<br /><br />
Simply include file in the head of your HTML document:
<?php echo $ajax->code("
<script id='cjax_lib' type='text/javascript' src='cjax/core/js/cjax-[version].min.js'></script>
", false);?>
Replace [version] with the current version of the framework you are using (for full none minified version remove the ".min" suffix).

