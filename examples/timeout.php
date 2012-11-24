<?php

require_once "ajax.php";
$ajax = ajax();


//timeout 5 seconds
$ajax->wait(5);

//alert after the 5 seconds
$ajax->overlayContent("5 seconds passed before displaying this.");

//update the content on the page
$ajax->update('wait_div','wait 3 more..');

//wait 3 more seconds
$ajax->wait(4);

//clear overlay
$ajax->overlayContent();

//display a message in the middle of the screen, in warning format
$ajax->warning("3 more seconds passed before displaying this.");

//wait 2 more seconds
$ajax->wait(4);

//update page content
$ajax->update('wait_div','This was a timeout example..');

$ajax->wait(false);

$ajax->process("This message is last... but it has no waiting time..");

?>
<html>
<head>
<title>Timeout...</title>
<?php echo $ajax->init();?>
</head>
<body>
<div id='wait_div'>
Please wait.. (5 seconds )
</div>
<br />
Code used:
<?php 
echo $ajax->code("
\$ajax->wait(5);
\$ajax->overlayContent(\"5 seconds passed before displaying this.\");
\$ajax->update('wait_div','wait 3 more..');
\$ajax->wait(3);
//clear overlay
\$ajax->overlayContent();
\$ajax->warning(\"3 more seconds passed before displaying this.\");
\$ajax->wait(2);
\$ajax->update('wait_div','This was a timeout example..');
\$ajax->wait(false);
\$ajax->process(\"This message is last... but it has no waiting time..\");
");?>
</body>
</html>
