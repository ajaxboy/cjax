<?php 

require_once  'ajax.php';


//** Press Enter, a, b c,  and the call go through **//
$ajax->click('image', $ajax->call("ajax.php?mouse/out/"));
$ajax->rightclick('image', $ajax->call("ajax.php?mouse/right/"));
$ajax->doubleclick('image', $ajax->call("ajax.php?mouse/double/"));

?>
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Mouse Right-click/Double-click</title>
	<?php echo $ajax->init(false);?>
</head>
<body>
<h3>Mouse Right-click/Double-click Event</h3>
<p>
Support for mouse right-click/double-click event (Cjax 6.0)
<br />
</p>
Code Used:
<?php 
echo $ajax->code("
	//Right click on this image, and it will change to another image.  
	\$ajax->rightclick('image', \$ajax->call(\"ajax.php?mouse/right/\"));
	//Double click on this image, and it will change to yet another image.  
	\$ajax->doubleclick('image', \$ajax->call(\"ajax.php?mouse/double/\"));
    //Single click on this image if you wish to revert it back to original image.
");
?>
<img id="image" name="image" src="resources/images/earth.png">
</body>
</html>