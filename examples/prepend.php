<?php
require_once 'ajax.php';

$ajax->prepend('#response','#other_element');
$ajax->prepend('#response','This <span style=\'color:red\'>HTML</span> was prepended to #response');



?>
<html>
<head>
<?php echo $ajax->init();?>
<title>Cjax - Prepend</title>
</head>
<body>
	<H2>Prepend</H2>
	Prepend html or elements before target element.
	
	<?php 
	echo $ajax->code("
	//Appending HTML
	\$ajax->prepend('#response','This <span style=\'color:red\'>HTML</span> was prepended to #response');
	//Appending or moving an element to #response
	\$ajax->prepend('#response','#other_element');
	");
	?>
	<div id='response'>#Response</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div id='other_element'>#Other element</div>
</body>
</html>