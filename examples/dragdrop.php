<?php 

require_once  'ajax.php';

//** Drag the item from left box to right box **//
$ajax->dragstart("ball", $ajax->call("ajax.php?dragdrop/dragstart/"));
$ajax->dragenter("box", $ajax->call("ajax.php?dragdrop/dragenter/"));
$ajax->dragleave("box", $ajax->call("ajax.php?dragdrop/dragleave/"));
$ajax->drop("box", $ajax->call("ajax.php?dragdrop/drop/"));

?>
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Drag and Drop</title>
	<?php echo $ajax->init(false);?>
</head>
<body>
<h3>Drag and Drop Event Support</h3>

<p>Drag the ball into the rectangle:</p>
<img id="ball" name="ball" src="resources/images/ball.png" width="40px" height="40px" draggable="true">
<div id="box" name="box" style="width: 100px; height: 40px; margin-right: 100px; padding: 10px; border: 1px solid #aaaaaa;"></div>
<p id="notes">Drag the ball and drop it on the box?</p>

Code Used:
<?php 
echo $ajax->code('
	//When starting to drag the ball, it fires a DragStart event.  
	$ajax->dragstart("ball", $ajax->call("ajax.php?dragdrop/dragstart/"));
	//When the ball enters the box(drag target), it triggers a DragEnter event, the box border changes to red dotted. 
	$ajax->dragenter("box", $ajax->call("ajax.php?dragdrop/dragenter/"));
	//When the ball leaves the box(drag target), it triggers a DragLeave event, the box border changes back to default. 
	$ajax->dragleave("box", $ajax->call("ajax.php?dragdrop/dragleave/"));
	//When dropping the ball onto the box(drag target), it triggers a Drop event, competing the sequences of actions. 
	$ajax->drop("box", $ajax->call("ajax.php?dragdrop/drop/"));
');
?>
</body>
</html>