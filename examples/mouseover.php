<?php 

require_once  'ajax.php';


//** Press Enter, a, b c,  and the call go through **//
$ajax->mouseover('image', $ajax->call("ajax.php?mouse/over/"));
$ajax->mouseout('image', $ajax->call("ajax.php?mouse/out/"));

?>
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Mouseover/Mouseout</title>
	<?php echo $ajax->init(false);?>
</head>
<body>
<h3>Mouseover and Mouseout Event</h3>
<p>
Support for mouseover and mouseout event (Cjax 6.0)
<br />
</p>
Code Used:
<?php 
echo $ajax->code("
	//Move your mouse over to the image, and it will change to another image.  
	\$ajax->mouseover('image', \$ajax->call(\"ajax.php?mouse/over/\"));
	//Move your mouse out of the image, and it will change to the original image.  
	\$ajax->mouseout('image', \$ajax->call(\"ajax.php?mouse/out/\"));
");
?>
<img id="image" name="image" src="resources/images/earth.png">
</body>
</html>