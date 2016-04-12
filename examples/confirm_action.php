<?php

require_once "ajax.php";

//displays a confirmation box before executing an ajax call.

$ajax->click("button1",$ajax->call("ajax.php?confirm/confirm_action",null,"Are you sure?"));
?>
<html>
<head>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Confirm  before firing ajax request</h2>
<input type='submit' id='button1' value='Click this button to confirm'>
<br />
<br />
<br />
Code Used:
<?php 

echo $ajax->code("
\$ajax->click(\"button1\",\$ajax->call(\"ajax.php?confirm/confirm_action\",null,\"Are you sure?\"));
");
?>

</body>
</html>
