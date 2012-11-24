<?php
require_once 'ajax.php';


$ajax->append('#response','This <span style=\'color:red\'>HTML</span> was appended to #response');

$ajax->append('#response','#other_element');

?>
<html>
<head>
<?php echo $ajax->init();?>
<title>Append</title>
</head>
<body>
<H2>Append</H2>
Append html or elements after target element 
<?php 
echo $ajax->code("
//Appending HTML
\$ajax->append('#response','This <span style=\'color:red\'>HTML</span> was appended to #response');
//Appending or moving an element to #response
\$ajax->append('#response','#other_element');
");
?>
<div id='response'>#Response</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div id='other_element'>#Other element</div>
</body>
</html>