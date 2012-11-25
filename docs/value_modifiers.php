<?php
require_once 'ajax.php';

?>
<html>
<head>
<?php echo $ajax->init();?>
<title>Value Modifiers</title>
</head>
<body>
<h2>Value Modifiers</h2>
Value pharser allows you to pass values within the url, for example:
<br /><br />
ajax.php?controller/function/|some_field|
<br /><br />
That 'some_field' is looked for by id then processed and the value of that field is passed in the final url to process.
Now value modifiers are functions and function references that you can pass along the field id to apply functionality to that value.
<br />
<h3>Apply  modifiers</h3>
Lets say for example that you want a value to be escaped when passed, then you could do this:
<br /><br />
ajax.php?controller/function/|some_field:escape|
<br /><br />

ajax.php?controller/function/|some_field:escape:toLowerCase|
<br /><br />
The value is passed through the function modifier. You may specify multiple JavaScript function modifiers.  You can even 
go as far as passing a full function in there, as follows:
<br /><br />
ajax.php?controller/function/|some_field:function(value) { value = value.replace(/a/g,'');return value;}|
<br /><br />
<h3>Avoid passing ":" character</h3>
The only condition to the value modifiers is that you do not pass a ':', this is because this character is
a seperator and if you pass it, the interpreter will think you are spliting the characters there.
<br />
</body>
</html>