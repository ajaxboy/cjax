<?php 

require_once  'ajax.php';


//** Press Enter, a, b c,  and the call go through **//
$ajax->click('image', $ajax->call("ajax.php?mouse/point/"));

?>
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Getting Mouse Pointer Coordinates</title>
	<?php echo $ajax->init(false);?>
</head>
<body>
<h3>Getting Mouse Pointer Coordinate</h3>
<p>
Support for mouse event properties such as (x, y) coordinate for mouse pointer.
<br />
</p>
Code Used:
<?php 
echo $ajax->code("
	//Click this image to get the x (horizontal) and y (vertical) coordinates of the mouse pointer when it was clicked. 
	\$ajax->click('image', \$ajax->call(\"ajax.php?mouse/point/\"));
");
?>
<img id="image" name="image" src="resources/images/earth.png">
</body>
</html>