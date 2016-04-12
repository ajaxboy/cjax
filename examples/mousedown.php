<?php 

require_once  'ajax.php';


//** Press Enter, a, b c,  and the call go through **//
$ajax->mousedown('image', $ajax->call("ajax.php?mouse/down/"));
$ajax->mouseup('image', $ajax->call("ajax.php?mouse/up/"));

?>
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Mousedown/Mouseup</title>
	<?php echo $ajax->init(false);?>
</head>
<body>
<h3>Mousedown and Mouseup Event</h3>
<p>
Support for mousedown and mouseup event (Cjax 6.0)
<br />
</p>
Code Used:
<?php 
echo $ajax->code("
	//Press your button on the image, and it will change to larger size.  
	\$ajax->mousedown('image', \$ajax->call(\"ajax.php?mouse/down/\"));
	//Release your button out of the image, and it will shrink back to original size.  
	\$ajax->mouseup('image', \$ajax->call(\"ajax.php?mouse/up/\"));
");
?>
<img id="image" name="image" src="resources/images/earth large.jpg" width="250" height="250">
</body>
</html>