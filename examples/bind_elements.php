<?php

//core file, reference..
require_once "ajax.php";
//initiate CJAX..

$ajax = ajax();

//This shows how to assign the same ajax call to 2 or more elements

//bind two elements with one command. So when these elements are fired.. the same command is fired..
//$ajax->Exec("link1|link2",$ajax->call("ajax.php?controller=bind&function=bild_elements"));

$ajax->click("link1|link2", $ajax->call("ajax.php?bind/bind_elements") );

### look inside controllers/bind.php for response code sample.
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Bind Elements</title>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Bind elements into same commands</h2>
<br />
Basically both anchor are hooked by the same event used
<br />
<br />
<a href='#' id='link1'>Click Me (element 1)</a>
<br />
<br />
<a href='#' id='link2'>Click Me (element 2)</a>
<br />
<br />
<br />
Code used:
<?php 
echo $ajax->code("
\$ajax->click(\"link1|link2\",\$ajax->call(\"ajax.php?bind/bild_elements\"));
");

?>
</body>
</html>
