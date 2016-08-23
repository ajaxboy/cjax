<?php 

require_once  'ajax.php';


//** Press Enter, a, b c,  and the call go through **//
$ajax->keypress('url', $ajax->call("ajax.php?test/remote/|url:encodeURIComponent|"), array(13,97,98,99));

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Test...</title>
	<?php echo $ajax->init();?>
</head>
<body>
<h3>Keypress Event</h3>
<p>
Support for keypress event (Cjax 5.4)
<br />
</p>
<?php 
echo $ajax->code("
	//Press enter, a, b or c, and the ajax request will go throgh.  
	\$ajax->keypress('url', \$ajax->call(\"ajax.php?test/remote/|url:encodeURIComponent|\"), array(13,97,98,99));
	
	//press enter and request will go through:
	\$ajax->keypress('url', \$ajax->call(\"ajax.php?test/remote/|url:encodeURIComponent|\"), 13);
");
?>
<input type='text'  id="url" value="" />
</body>
</html>