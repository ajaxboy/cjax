<?php

require_once "ajax.php";


//look inside controller/post.php for code that handles this request.

$vars = [
	'hello' => 'world',
	'world' => 'hello!',
	'someVar' => 'someValue',
	'x' => 'y'
];

$ajax->post = $vars;
$ajax->call("ajax.php?post/postSample",'div_response');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<?php echo $ajax->init();?>
</head>
<body>
<h2>Post variables using POST</h2>
POST:
<div id='div_response'></div>
<br />
code used:
<?php
echo $ajax->code("
\$vars = [
	'hello' => 'world',
	'world' => 'hello!',
	'someVar' => 'someValue',
	'x' => 'y'
];

\$ajax->post = \$vars;
\$ajax->call(\"ajax.php?post/postSample\",'div_response');
");
?>
Controller:
<?php
echo $ajax->code("
namespace Examples\\Controllers;
use CJAX\\Core\\AJAXController;

class Post extends AJAXController{
		
	public function postSample(){
		echo 'Response is<pre>'.print_r(\$_POST,1).'</pre>';
	}
}
");
?>


</body>
</html>