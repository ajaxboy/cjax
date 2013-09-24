<?php
require_once 'ajax.php';


$ajax->insert('#response','This <span style=\'color:red\'>HTML</span> was inserted into the start #response<br />');

$ajax->insert('#response','This <span style=\'color:red\'>HTML</span> was inserted into the end #response<br />', true);

$ajax->insert('#response','#other_element', true);


?>
<html>
<head>
<?php echo $ajax->init();?>
<title>Insert</title>
</head>
<body>
<H2>Insert</H2>
Inserts html or elements inside an element.
<?php 
echo $ajax->code("
//Insert into the start of an #response
\$ajax->insert('#response','This <span style=\'color:red\'>HTML</span> was inserted into the start #response');
//Insert into the end of an #response
\$ajax->insert('#response','This <span style=\'color:red\'>HTML</span> was inserted into the end #response', true);

//move #other_element into the end of #response
\$ajax->insert('#response','#other_element', true);

//move #other_element into the start of #response
\$ajax->insert('#response','#other_element');

");
?>
<div id='response'>[this is what what originally in #response]</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div id='other_element'>#Other element</div>
</body>
</html>