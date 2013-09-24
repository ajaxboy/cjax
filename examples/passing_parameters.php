<?php

require_once "ajax.php";
$ajax = ajax();

//parameterts use alphabetical characters to pass parameters to the controller function.


//sending parameters to the backend controller is simple. They go in alphabetical order.
//Exampe:  a will be the first paramenter, b the second, 3 the 3rd, and so on..

$ajax->call("ajax.php?controller=parameters&function=send_params&a=test&b=test2&c=test3&d=test4");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Cjax Framework sending parameters to controller</title>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Ajax send parameters</h2>
<div id='params'></div>
<br />
<br />
Code used:
<?php 
echo $ajax->code("
\$ajax->call(\"ajax.php?controller=parameters&function=send_params&a=test&b=test2&c=test3&d=test4\");
");?>

<h4>Controller</h4>
In the controller you can access these parameters as such:
<?php 
echo $ajax->code("
class parameters {

	function send_params(\$a,\$b,\$c,\$d)
	{
	
	}
}
");?>
All parameters in alphabetic letters are atuomatically converted into function arguments.
</body>
</html>
