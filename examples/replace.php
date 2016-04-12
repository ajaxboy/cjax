<?php
require_once 'ajax.php';


$ajax->replace('#response',"<div id='response2'><span style='color:red'>#response</span> was replaced with this html</div>");

$ajax->replace('#other_element',"#other_element2");

?>
<html>
<head>
<?php echo $ajax->init();?>
<title>Replace</title>
</head>
<body>
<H2>Replace</H2>
Replace an element with other element or with HTML.
<?php 
echo $ajax->code("
\$ajax->replace('#response',\"<div id='response2'><span style='color:red'>#response</span> was replaced with this html</div>\");
//Appending or moving an element to #response
\$ajax->replace('#other_element',\"#other_element2\");
");
?>
<div id='response'>#Response</div>
<div>&nbsp;</div>
<div id='other_element'>#Other element</div>
<div id='other_element2'>#Other element2: This element replace #Other element</div>
</body>
</html>