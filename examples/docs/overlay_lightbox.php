<?php

require 'ajax.php';
?>
<head>
<?php echo $ajax->init(); ?>
<title>Overlay Lightbox</title>
</head>
<h2>Show Overlay Lightbox</h2>
(CJAX 2.0+)
<br />
Syntax:  $ajax->overlay([url], [boolean use_cache], [settings]);
<br />
Syntax:  $ajax->overlayContent([content], [settings]);
<br />
(CJAX 4.2+)
<br />
Syntax:  $ajax->dialog([content], [title], [settings]);
<br />
<H4>Available Settings</H4>
Optionally you may pass custom settings through the overlay function. The settings are in an array
format.
		

<br /> 
Settings:
<ul>
	<li>
		top
	</li>
	<li>
		left
	</li>
	<li>
		width (as of 5.0-RC2)
	</li>	
	<li>
		transparent
	</li>	
	<li>
		color
	</li>		
</ul>

<br />
To show an overlay with text:
<?php 
echo $ajax->code("
\$ajax->overlayContent(\"Your content here\"));
");
?>
<br />
To show an overlay with title:
<?php 
echo $ajax->code("
\$ajax->dialog(\"Your content here\",\"Title Here\"));
");
?>
<br />
To request a url to show inside the overlay:
<?php 
echo $ajax->code("
\$ajax->overlay(\"url/goes/here\"));
");
?>
<br />
The next example shows how to bind overlays to a element's click.
 Where says "OVERLAY_CODE", you
may enter any of the overlay functions.
<h4>Example</h4>
<?php 
echo $ajax->code("
\$ajax->Exec(\"button_id_here\", OVERLAY_CODE ));
");
?>

