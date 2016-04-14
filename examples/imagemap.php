<?php 

require_once 'ajax.php';


//** Press Enter, a, b c,  and the call go through **//
$ajax->click('image', $ajax->call("ajax.php?mouse/map/"));

?>
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Creating Image Map with Mouse Event</title>
	<?php echo $ajax->init(false);?>
</head>
<body>
<h3>Creating Image Map with Mouse Event</h3>
<p>
Support for creating an Image Map using Mouse Pointer Coordinates
<br />
</p>
Code Used:
<?php 
echo $ajax->code("
	//Click anywhere on the image, and you will be notified whether you have clicked on the sun, a planet or just some empty space in our universe.
	\$ajax->click('image', \$ajax->call(\"ajax.php?mouse/map/\"));
");
?>
<p><span id="result">Click on the image below to see where you are at!</span></p>
<img id="image" name="image" src="resources/images/universe.jpg">
</body>
</html>