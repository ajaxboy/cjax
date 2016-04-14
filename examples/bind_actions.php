<?php

//core file, reference..
require_once "ajax.php";


//This example shows how to send more than 1 ajax call, 
//( or any other command for tha matter) within 1 single command as nested.



//multiple commands can be binded..
//defeault event is "click"
$ajax->click("link1", [
    $ajax->call("ajax.php?bind/link2"), 
    $ajax->alert("Hello World 1"), 
    $ajax->alert("Hello World 2")]);//default event is "click"
		

//different event.. "blur"
$ajax->blur("link2", [
    $ajax->call("ajax.php?bind/link2"),
	$ajax->alert("Hello World 3"),
	$ajax->alert("Hello World 4")]
);
	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Bind Ajax Actions</title>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Bind multiple events into one event</h2>
<br />
You may bind as many commands as needed inside the exec() binder function.<br />

<br />
the following is on "click" event..
<br />
<a href='#' id='link1'>Click Me</a>
<br />
<br />
the following is on "blur" event..
<br />
<a href='#' id='link2'>Click Me</a>
<br />
<br />
Code Used:
<?php 

echo $ajax->code("
//default event is \"click\"
\$ajax->click(\"link1\", [
			\$ajax->call(\"ajax.php?bind/link2\"),
			\$ajax->alert(\"Hello World 1\"),
			\$ajax->alert(\"Hello World 2\")]);
		

//different event.. \"blur\"
\$ajax->blur(\"link2\", [
		\$ajax->call(\"ajax.php?bind/link2\"),
		\$ajax->alert(\"Hello World 3\"),
		\$ajax->alert(\"Hello World 4\")]
);

");
?>

</body>
</html>
