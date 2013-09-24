<?php

//core file, reference..
require_once "ajax.php";
//initiate CJAX..
$ajax = ajax();

// 1. test field
// 2. URL to be requested.
// 3. Event. onKeyUp event is used.
$ajax->keyup("text1", $ajax->call("ajax.php?keyup_update/update/|text1|"));
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Keyup Ajax Request</title>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Keyup ajax request</h2>
<br />
Basically send an ajax request to the server every time you type something..
<br />
<br />
Type Something... <input type='text' id='text1'>
<br />
<div id='div_response'></div>
<br />
<br />
<br />
Code Used:
<?php 
echo $ajax->code("
\$ajax->keyup(\"text1\", \$ajax->call(\"ajax.php?keyup_update/update/|text1|\"));"
);
?>
Controller:
<?php 
echo $ajax->code("
class Keyup_update {
	
	function update(\$text)
	{
		\$ajax = ajax();
		
		//update page title
		\$ajax->document('title', \$text);
		
		//update div
		\$ajax->div_response = \$text;
	}
}
);");
?>
</body>
</html>
