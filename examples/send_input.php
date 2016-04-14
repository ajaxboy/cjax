<?php

require_once "ajax.php";

$ajax->click("button1",$ajax->call("ajax.php?send_input/send_text/|text1|"));

$ajax->click("button2",$ajax->call("ajax.php?send_input/send_checkbox/|check1|"));

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Ajax Send inputs</title>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Send individual inputs</h2>
<input id='text1' type='text' value='Send this text'>
<br />
<input type='submit' id='button1' value='Send text..'>
<br />
<br />
<br />
<input type='checkbox' id='check1' checked='checked'>
<input type='submit' id='button2' value='Send Checkbox value..'>
<br />
<br />
Code used:
<?php 
echo $ajax->code("
\$ajax->click(\"button1\",\$ajax->call(\"ajax.php?send_input/send_text/|text1|\"));

\$ajax->click(\"button2\",\$ajax->call(\"ajax.php?send_input/send_checkbox/|check1|\"));
");?>
Controller:
<?php 
echo $ajax->code("
use CJAX\\Core\\CJAX;    
class Send_input {
	
	function send_text( \$text ){
		
		\$ajax = CJAX::getInstance();
		
		\$ajax->success(\"This message was sent: \$text\",30);
	}
	
	function send_checkbox( \$check ){
		\$ajax = CJAX::getInstance();
		
		if(\$check) {
			\$ajax->success(\"Is checked..\");
		} else {
			\$ajax->warning(\"Is not checked..\");
		}
	}
}
");?>


</body>
</html>
