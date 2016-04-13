<?php

//core file, reference..
require_once "ajax.php";
//initiate CJAX..

$ajax->click("button1",$ajax->call("ajax.php?change_value/text/text1/|text1|"));

$ajax->click("button2",$ajax->call("ajax.php?change_value/check/check1/|check1|"));

$ajax->click("button3",$ajax->call("ajax.php?change_value/div/|rand|"));
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Ajax setting elements values</title>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Ajax Update Elements/Containers</h2>
<br />
You may change any element's value ranging from textboxes, checkboxes, divs,spans, and others.
<br />
Use the $ajax Object + the id of the element/contained to change the value/html/content.
<br />
<br />
Change any element values from the backend
<br />
<br />
<input type='text' id='text1' value=''> 
<br />
<input type='button' id='button1' value='Change value'>
<br />
<br />
<br />
<input type='checkbox' id='check1' />
<br />
<input type='button' id='button2' value='Change value'>
<br />
<br />
<div id='DIV_1'></div>
<br />
<input type='button' id='button3' value='Update div'>
<br />
Code used:
<?php 
echo $ajax->code("
<?php

\$ajax->click(\"button1\",\$ajax->call(\"ajax.php?change_value/text/|text1|\"));

\$ajax->click(\"button2\",\$ajax->call(\"ajax.php?change_value/check/|check1|\"));

\$ajax->click(\"button3\",\$ajax->call(\"ajax.php?change_value/div/\");


?>

<!--HTML-->
<input type='text' id='text1' value=''> 

<input type='checkbox' id='check1' />

<div id='DIV_1'></div>

",false);?>
Controller:
<?php 
echo $ajax->code("
use CJAX\\Core\\CJAX;   
class change_value {

	function div(){
		\$ajax = CJAX::getInstance();
		
		//Some random strings .......
		\$text[] = \"Lorem Ipsum is simply dummy text of the printing and typesetting industry. \";
		\$text[] = \"Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown \";
		\$text[] = \"printer took a galley of type and scrambled it to make a type\";
		\$text[] = \"specimen book. It has survived not only five centuries, but also the leap into electronic\";
		\$text[] = \"typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of \";
		\$text[] = \"Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\";
		\$text[] = \"it is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.\"; 
		\$text[] = \"The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using\";
		\$text[] = \"'Content here, content here', making it look like readable English. Many desktop publishing packages and \";
		\$text[] = \"web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many\";
		\$text[] = \"web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\";
		
		\$ajax->DIV_1 = \$text[rand(0, count(\$text)-1)];
	}
	
	function text(\$current_value){
		\$ajax = CJAX::getInstance();
		
		\$ajax->text1 = \"Random number..\".rand(100,1000);
	}
	
	
	function check(\$current_value)
	{
		\$ajax = CJAX::getInstance();
		
		if(\$current_value) {
			\$ajax->check1 = false;
		} else {
			\$ajax->check1 = true;
		}
	}
}
");?>
</body>
</html>
