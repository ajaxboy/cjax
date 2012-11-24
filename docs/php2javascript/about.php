<?php
require '../ajax.php';
?>
<head>
<?php echo $ajax->init();?>
<title>JavaScript functions in PHP</title>
</head>
<body>
<H3>JavaScript functions in PHP</H3>
5.0-RC1 introduced a great future, which allows you to access a element's properties and assign all sort of properties, in 5.0-RC2 we're taking it a step further.
<br /><br />

The intention is not access all JavaScript function and Objects through PHP, we've already done that. In 5.0-RC2 you can and are able <br />
to access all properties, window, document, functions and Objects in Javascript through PHP, however this is a brand new feature - and 
not all functions are documented. 
<br />

The purpose of these features is not intention to lead the framework into working with raw Javascript in PHP, but rather to give more tools
to developers and to stay resourceful to face given problems.
<br /><br />
Since most of this is not documented, in the mean time fortunely they all follow a logical pattern, and it is possible to access them with basic knowledge of JavaScript functions.
<br /><br />


As of version 5.0-RC2, $ajax has direct acces to invoke ALL Javascript functions and Objects in the HTML document. That's right any.
 
<br /><br />
<h3>Usage</h3>

$ajax->[OBJECT]([getter], param, param, param, param);
<br />
<b>Importat</b>: If a plugin exists with name of the [OBJECT], the plugin will take priority over Js functions.
<br /><br />
All parameters are optional.
<br /><br />
[OBJECT] - Is the name of the JavaScript object or function you want to access. So the usage is very similar as if it is for JavaScript.<br /><br />                          
<br />
[getter] - If what you are accessing is a function within an object then you will need to specify,
which property or function you want to get to. 
<br />
For example to access the body's HTML you may do this:
Example:
<br />
<?php echo $ajax->code("
\$ajax->document('body.innerHTML','Content Here');
");?>


<br />
Other examples:<br />
<?php echo $ajax->code("
\$ajax->document('write','Content Here');
");?>

<br />
Other examples:<br />
<?php echo $ajax->code("
\$ajax->window('alert','Content Here');
");?>

<br />
This is the same as above:
<?php echo $ajax->code("
\$ajax->alert('Content Here'); 
");?>
If the function is just a normal function (not an object) and doesn't require a getter, then the [getter] will be treated as parameter also.
<br />
<br />
Some functions that are getters though, such as document.getElementById and window.confirm, were enhanced to permit a callback.
<br />
<br />
These two examples are the exceptions, and more will be allowed to have callbacks eventually.
<br />
<h4>Example</h4>
<?php
echo $ajax->code("
\$ajax->document(\"getElementById\",\"element_id\",\"function(element) {
		//your element is...
		alert(element);
	}
\");"
);
?>
<h4>Example</h4>
<?php
echo $ajax->code("
\$ajax->confirm(\"Are you sure?\",\"function() {
		//the user clicked yes
		
	}
\");"
);
?>
<br />
Please  be warned that this feature is still new and we can't guaranteed  all JS functions will work as expected. 
<br /><br /><br />
</body>
