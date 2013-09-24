<?php

require 'ajax.php';
?>
<head>
<?php echo $ajax->init();?>
<title>Ajax Framework | Access fields in parameters </title>
</head>
<body>
<h2>Access fields in parameters</h2>

To be able to access your form fields through parameters in your ajax controllers you will need to name your fields the following way:
<br />
<br />
<?php 

echo $ajax->code("
<input type='text' id='field1'  name='a[field1]' />
<input type='text' id='field2'  name='a[field2]' />
<input type='text' id='some_field'  name='a[some_field]' />
");
?>


</body>