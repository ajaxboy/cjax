<?php
require_once 'ajax.php';
?>
<head>
<?php echo $ajax->init();?>
<title>Binding Elements</title>
</head>
<body>
<h2>Binding Elements</h2>

To be able to perform actions in Cjax without them being executed on the spot, you'd need to bind these actions to an element.<br />
To to bind an action to an element, you'd need a window event such as "click", "blur", "change", "keyup", "keydown" etc.
<br /><br />
Cjax uses the $ajax->Exec() function to bind elements to actions. Below are some examples how Exec function is used.
<br /><br />
<h4>Example</h4>

Default window event is "click", since it's default you may go by without specifying it.<br />
The following example will assign the action $ajax->call() to element "element_id" on the click event.
<?php echo $ajax->code("
\$ajax->Exec('element_id', \$ajax->call('url/to/action'));
");?>
If you'd like to use a different window event then you would need to specify it
so that the specific actions trigger  when that window event happens.
<h4>Example</h4>
<?php echo $ajax->code("
//Sample #1 blur
\$ajax->Exec('element_id', \$ajax->call('url/to/action'),'blur');
//Sample #2 change
\$ajax->Exec('element_id', \$ajax->call('url/to/action'),'change');
//Sample #3 keyup
\$ajax->Exec('element_id', \$ajax->call('url/to/action'),'keyup');
//Sample #4 keydown
\$ajax->Exec('element_id', \$ajax->call('url/to/action'),'keydown');
");?>
<h3>Bind Multiple Events</h3>
Cjax also supports the ability to bind multiple actions to one single element through an array.
Lets say that you want to trigger multiple ajax requests, or want to show an overlay, or trigger other actions all at<br />
 the same time at a button's click, then
you may use an array of actions inside  . Other way of accomplishing this is<br />
 by using Exec() multiple times against the same element, that would work too.
<br /><br />
In the following example we are assigning a few actions to that element's click.
<h4>Example</h4>
<?php 
echo $ajax->code("
\$ajax->Exec('element_id', array(
	\$ajax->overlayContent('Hello'),
	\$ajax->alert('Hello'),
	\$ajax->info('Hello'),
));
");
?>
<h3>Bind action(s) to multiple elements</h3>
Cjax also has the  ability to bind multiple elements to one action or more actions.
<br />
<br />
The following statement would assign the same action to multiple elements.
<?php 
echo $ajax->code("
	\$ajax->Exec(array('element_1','element_2'), \$ajax->call('url/to/action'));
");

?>
</body>

