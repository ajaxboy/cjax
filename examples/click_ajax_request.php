<?php

require_once "ajax.php";
$ajax = ajax();

$ajax->click("button1",$ajax->call("ajax.php?click_ajax_request/click_button/Hello!"));


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Simple ajax request binded to a button</title>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Simple ajax request binded to a button</h2>
<input type='button' id='button1' value='Click this button to make an ajax request'>
<div id='response'></div>
<br />
<br />
<br />
<br />
Code Used:
<?php
echo $ajax->code("
\$ajax->click(\"button1\",\$ajax->call(\"ajax.php?click_ajax_request/click_button/Hello!\"));
");
?>
</body>
</html>