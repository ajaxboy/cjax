<?php 

require_once  'ajax.php';

//** Drag the item into either left box or right box **//
$ajax->config->sizzle = true;
$ajax->dragstart(".ball", $ajax->call("ajax.php?dragdrop/dragstart/"));
$ajax->dragenter(".box", $ajax->call("ajax.php?dragdrop/dragenter/"));
$ajax->dragleave(".box", $ajax->call("ajax.php?dragdrop/dragleave/"));
$ajax->drop("leftbox", $ajax->call("ajax.php?dragdrop/drop/"), ["dropEffect" => "move", "effectAllowed" => "move", "multiDrop" => true]);
$ajax->drop("rightbox", $ajax->call("ajax.php?dragdrop/drop/"), ["dropEffect" => "move", "effectAllowed" => "move", "multiDrop" => true, "sortable" => true]);

?>
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Drag and Drop Multiple Items</title>
	<?php echo $ajax->init(false);?>
</head>
<body>
<h3>Drag and Drop Multiple Items</h3>

<p>
    Drag the balls into the left box and they will align next to each other based on the insertion order,
    or drag the balls into right box and they will be sorted depending on the position of the newly dropped ball. 
</p>
    This is done by passing a data transfer attribute array to the third optional parameter of AJAX call.
    You may also change other attributes for javascript data transfer object, such as dropEffect, effectAllowed, etc.
</p>
<p>Note: You can also exchange balls between left and right boxes.</p>

<img id="soccer" name="soccer" class="ball" src="resources/images/soccer.png" width="40px" height="40px" draggable="true">
<img id="basketball" name="basketball" class="ball" src="resources/images/basketball.png" width="40px" height="40px" draggable="true">
<img id="football" name="football" class="ball" src="resources/images/football.png" width="40px" height="40px" draggable="true">
</br>
<div id="leftbox" name="leftbox" class="box" style="float:left; width: 120px; height: 40px; margin-right: 100px; padding: 10px; border: 1px solid #aaaaaa;"></div>
<div id="rightbox" name="rightbox" class="box" style="float:left; width: 120px; height: 40px; margin-right: 100px; padding: 10px; border: 1px solid #aaaaaa;"></div>
</br></br></br>
<p>
    <span style="float:left; margin-left:30px; margin-right:200px;">Left Box</span>
    <span style="float:left; margin-right:200px;">Right Box</span>
</p>
</br>
<p id="notes">Drag the ball and drop it on the box?</p>

Code Used:
<?php 
echo $ajax->code('
    //Enable Sizzle to use advanced selectors for dropbox class, it is recommended if you have multiple drag targets.  
    $ajax->config->sizzle = true;
    //When starting to drag the balls, they fire DragStart events. Soccer, Basketball and Football are all draggable, note the usable of .ball class selector.
    $ajax->dragstart(".ball", $ajax->call("ajax.php?dragdrop/dragstart/"));
    //When the balls enter or leave the boxes(drag target), they trigger DragEnter/DragLeave events as usual, note the usable of .box class selector.
    $ajax->dragenter(".box", $ajax->call("ajax.php?dragdrop/dragenter/"));
    $ajax->dragleave(".box", $ajax->call("ajax.php?dragdrop/dragleave/"));
    //When dropping the ball onto the boxes(drag target), it triggers a Drop event. Both boxes allow drops of multiple items, while the right box will also sort the orders of items based on the position they are dropped.  
    $ajax->drop("leftbox", $ajax->call("ajax.php?dragdrop/drop/"), ["dropEffect" => "move", "effectAllowed" => "move", "multiDrop" => true]);
    $ajax->drop("rightbox", $ajax->call("ajax.php?dragdrop/drop/"), ["dropEffect" => "move", "effectAllowed" => "move", "multiDrop" => true, "sortable" => true]);
');
?>
</body>
</html>