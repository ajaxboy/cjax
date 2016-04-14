<?php

require_once "ajax.php";

//call method ajax_request::on_the_fly()  in controllers/ajax_request.php
$ajax->click("button1",$ajax->call("ajax.php?recursive_ajax/call/0/|count|"));
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<?php echo $ajax->init();?>
<title>Ajax Framework | Recursive ajax request</title>
</head>
<body>
Recursive ajax requests
<br />
<br />
How many ajax requests would you like?.
<input type='text' id='count' value='30'/>
<br />
<input type='submit' id='button1' value ='Start recursive requests'/>
<div id='div_counter'></div>
<br />
<br />
<br />
Code used:
<?php
echo $ajax->code("
<?php
\$ajax->click(\"button1\",\$ajax->call(\"ajax.php?recursive_ajax/call/0/|count|\"));
?>

<!--HTML-->
<input type='button' id='button1' value ='Start recursive requests'/>
<div id='div_counter'></div>
", false);
?>
<br />
<h2>Controller</h2>
<?php
echo $ajax->code("
use CJAX\\Core\\CJAX; 

class recursive_ajax {
	
	public function call(\$counter = 0,\$count){
		//force valid inputs
		\$counter = (int) \$counter;
		\$count = (int) \$count;
		
		\$counter++;
		
		\$ajax = CJAX::getInstance();
		
		//if you enter a number greate than 100
		if(\$count > 100) {
			
			//focus on textbox
			\$ajax->focus('count');
			
			//show warning
			\$ajax->warning(\"Too many requests can add overhead to our servers, please try reducing the number.\");
			
			//update textbox
			\$ajax->count = 30;
			return;
		}
		
		//update div
		\$ajax->div_counter = \"Call# \$counter..\";
		
		if(\$counter>=\$count) {
			\$ajax->div_counter = \"\$counter recursive AJAX requests were made.\";
		} else {
		
		//fire call
			\$ajax->call(\"ajax.php?recursive_ajax/call/\$counter/\$count\");
		}

	}
	
}
");
?>
</body>
</html>
