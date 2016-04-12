<?php 

require_once  'ajax.php';

//** Drag a ball image to the box and you will be notified if you have the correct answer. **//
$balls = ["soccer", "basketball", "football", "baseball", "tennis", "billiardball"];
$ball = $balls[mt_rand(0, 5)];

$ajax->config->sizzle = true;
$ajax->dragstart(".ball", $ajax->call("ajax.php?captcha/dragstart/"));
$ajax->dragenter("box", $ajax->call("ajax.php?captcha/dragenter/"));
$ajax->dragleave("box", $ajax->call("ajax.php?captcha/dragleave/"));
$ajax->drop(".box", $ajax->call("ajax.php?captcha/drop/{$ball}/"));

?>
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Image Captcha with Drag and Drop</title>
	<?php echo $ajax->init(false);?>
</head>
<body>
<h3>Image Captcha with Drag and Drop</h3>

<p>Please drag and correct ball image and drop it to the box below:</p>
<p>Note: If you pick the wrong ball, you may drag it back to the location where the image used to be, and then pick another ball.</p>

<table border="1">
    <tr>
        <td class="box" style="width:60px;height:60px;"><img id="soccer" name="soccer" class="ball" src="resources/images/soccer.png" width="60px" height="60px" draggable="true"></td>
        <td class="box" style="width:60px;height:60px;"><img id="basketball" name="basketball" class="ball" src="resources/images/basketball.png" width="60px" height="60px" draggable="true"></td>
        <td class="box" style="width:60px;height:60px;"><img id="football" name="football" class="ball" src="resources/images/football.png" width="60px" height="60px" draggable="true"></td>
    </tr>
    <tr>
        <td class="box" style="width:60px;height:60px;"><img id="baseball" name="baseball" class="ball" src="resources/images/baseball.png" width="60px" height="60px" draggable="true"></td>
        <td class="box" style="width:60px;height:60px;"><img id="tennis" name="tennis" class="ball" src="resources/images/tennis.png" width="60px" height="60px" draggable="true"></td>
        <td class="box" style="width:60px;height:60px;"><img id="billiardball" name="billiardball" class="ball" src="resources/images/billiardball.png" width="60px" height="60px" draggable="true"></td>
    </tr>
</table>
<p>Please drag the <?php echo $ball; ?> image and drop it onto the box:</p>
<div id="box" name="box" class="box" style="float: left; width: 60px; height: 60px; margin-right: 100px; padding: 10px; border: 1px solid #aaaaaa;"></div>
</br></br></br></br></br>
<p id="notes"></p>
Code Used:
<?php 
echo $ajax->code('
    //Enable Sizzle to use advanced selectors for dropbox class, it is recommended if you have multiple drag targets.  
    $ajax->config->sizzle = true;
    //When starting to drag the balls, they fire DragStart events. Note the usable of .ball class selector.
    $ajax->dragstart(".ball", $ajax->call("ajax.php?captcha/dragstart/"));
    //When the balls enter or leave the box(drag target), they trigger DragEnter/DragLeave events as usual.
    $ajax->dragenter("box", $ajax->call("ajax.php?captcha/dragenter/"));
    $ajax->dragleave("box", $ajax->call("ajax.php?captcha/dragleave/"));
    //When dropping the ball onto the box(drag target), it triggers a Drop event. If the ball is the correct one, captcha test will pass, otherwise it will fail and you can try again.
    $ajax->drop(".box", $ajax->call("ajax.php?captcha/drop/{$ball}/"));
');
?>
</body>
</html>