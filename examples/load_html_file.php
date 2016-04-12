<?php

require_once "ajax.php";

//The simplest way to execute  a call

//load file "resources/html/test.html" into div
$ajax->div_container = $ajax->call("resources/html/test.html");

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Load html file</title>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Load external HTML file (or any plain file)</h2>
<br />

<div id='div_container'></div>
<br />
<br />
<br />
Code used:
<?php 
echo $ajax->code("
\$ajax->call(\"resources/html/test.html\",\"div_container\");

//As of 5.0-RC1 you can do this:

\$ajax->div_container = \$ajax->call(\"resources/html/test.html\");


");?>
</body>
</html>
