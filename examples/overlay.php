<?php

require_once "ajax.php";

//The settings are optional.

//overlay using cache
//Elemene ID, URL
//no settings  ( default settings)
$ajax->click("#overlay_cache",$ajax->overlay("ajax.php?overlay/view_overlay",array(),true));



//no cache
//with dimension settings
// All of these settings are optional. If not specified, default settings are used.
// also these settings can be associated with css style properies, but may differ a little.
$settings['top'] = '150px';
$settings['left'] = '20%';
$settings['transparent'] = '60%'; // from 1 transparent to 100 solid, how transparent should it be? default is 80.
$settings['color'] = '#FF8040'; //color will only work if the setting above (transparent) is present. 
$settings['click_close'] = true;// click anywhere on the screen to close the overlay
$ajax->click("#overlay_no_cache",$ajax->overlay("ajax.php?overlay/view_overlay",$settings));


//pass content..
//with settings..
$ajax->click("#overlay_content",$ajax->overlayContent("Hello World",array('top'=> '200px')));


$ajax->click("#overlay_dialog", $ajax->dialog('Hello World','Dialog#1'));

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<?php echo $ajax->init();?>
<title>Ajax Overlays in PHP</title>
</head>
<body>
<h2>Overlay Examples</h2>
<br />
<br />
<p>These Ajax Overlays are built in Cjax's framework API. All overalys takes one line code to produce and you may also specify settings such as color and width.
You may supply the content/html directly or  provide a URL to fetch the content.
</p>
<br />
<br />
#1 triggers an ajax URL, and displays the response in the content area. The response is cached then the
next time it is requested, it displays the response from the cached request, does not make a new request.
<br />
<a id='overlay_cache' href='#'>See overlay (using cache)</a>
<br />
<br />
#2 Triggers an ajax URL and refreshes the content each time by making a new request. Also demonstrate how alternatively the content window can be
positioned in certain parts of the screen, not necesarly in the middle. It is also possible to customize colors.
<br />
<a id='overlay_no_cache' href='#'>See overlay (no cache)</a>
<br />
<br />
#3 Does not trigger a URL, the content is provided directly instead, and displayed, as simple as that.
<br />
<a id='overlay_content' href='#'>See overlay content</a>
<br />
<br />
#4 Show overlay dialog
<br />
<a id='overlay_dialog' href='#'>See a formatted overlay dialog</a>

<br />
<br />
<br />
Code used:
<?php 
echo $ajax->code("
//Overlay #1
\$ajax->click(\"#overlay_cache\",\$ajax->overlay(\"ajax.php?overlay/view_overlay\",array(),true));


//Overlay #2
\$settings['top'] = '150px'; //how far from the top of the screen
\$settings['left'] = '20%'; //how far from the left of the scree
\$settings['transparent'] = '60%'; //transparency percentange
\$settings['color'] = '#FF8040'; //change color
\$settings['click_close'] = true;// click anywhere on the screen to close the overlay
\$ajax->click(\"#overlay_no_cache\",\$ajax->overlay(\"ajax.php?overlay/view_overlay\",\$settings));


//Overlay #3
\$ajax->click(\"#overlay_content\",\$ajax->overlayContent(\"Hello World\",array('top'=> '200px')));


//Overlay #4
\$ajax->click(\"#overlay_dialog\",\$ajax->dialog(\"Hello World\",'Dialog#1'));

");?>

</body>
</html>
