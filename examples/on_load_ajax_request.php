<?php

require_once "ajax.php";

//call method AJAXRequest::onTheFly()  in controllers/ajaxrequest.php
$ajax->call("ajax.php?ajaxrequest/onTheFly");
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
\$ajax->call(\"ajax.php?ajaxrequest/onTheFly\");
");?>
<br />
<br />
<br />
Controller:
<?php 

echo $ajax->code("
use CJAX\Core\AJAXController;
class AJAXRequest extends AJAXController{
	
	public function onTheFly(){

		\$this->ajax->update('container', 'This text was updated through ajax...');
		
		\$this->ajax->wait(2);
		
		\$this->ajax->update('container2', 'This text too...');
		
		\$this->ajax->wait(3);
		
		\$this->ajax->update('container2', 'Updated...');
	}
}
");
?>

</body>
</html>