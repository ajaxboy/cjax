<?php

require_once "ajax.php";

//call method ajax_request::on_the_fly()  in controllers/ajax_request.php
$ajax->call("ajax.php?ajax_request/on_the_fly");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Fire Ajax request on load & do other actions</title>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Fire Ajax request on load &amp; do other actions</h2>
<div id='container1'></div>
<br />
<br />
<div id='container2'></div>
<br />
<br />
<br />
Code used:
<?php 
echo $ajax->code("
\$ajax->call(\"ajax.php?ajax_request/on_the_fly\");
");?>
<br />
<br />
<br />
Controller:
<?php 

echo $ajax->code("
class controller_ajax_request {
	
	function on_the_fly()
	{
		\$ajax = CJAX::getInstance();
		
		\$ajax->update('container','This text was updated through ajax...');
		
		\$ajax->wait(2);
		
		\$ajax->update('container2','This text too...');
		
		\$ajax->wait(3);
		
		\$ajax->update('container2','Updated...');
	}
}
");
?>

</body>
</html>
