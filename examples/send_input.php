<?php

require_once "ajax.php";

$ajax->click("button1",$ajax->call("ajax.php?sendinput/sendText/|text1|"));

$ajax->click("button2",$ajax->call("ajax.php?sendinput/sendCheckbox/|check1|"));

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
\$ajax->click(\"button1\",\$ajax->call(\"ajax.php?sendinput/sendText/|text1|\"));

\$ajax->click(\"button2\",\$ajax->call(\"ajax.php?sendinput/sendCheckbox/|check1|\"));
");?>
Controller:
<?php 
echo $ajax->code("
namespace Examples\\Controllers;
use CJAX\\Core\\AJAXController;    

class SendInput extends AJAXController{
	
	public function sendText(\$text){		
		\$this->ajax->success(\"This message was sent: \$text\",30);
	}
	
	public function sendCheckbox(\$check){
		if(\$check){
			\$this->ajax->success(\"Is checked..\");
		} 
        else{
			\$this->ajax->warning(\"Is not checked..\");
		}
	}
}
");?>


</body>
</html>