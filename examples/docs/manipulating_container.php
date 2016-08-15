<?php

require_once 'ajax.php';

?>
<head>
<?php echo $ajax->init();?>
<title>Ajax Framework | Manipulating Elements</title>
</head>
<h2>Manipulating Elements/Containers</h2>
With the release of 5.0-RC1 One of the new features is the ability to manipulate any element on the HTML document through PHP.
<br />
All elements (divs,spans,buttons,images,anchors, etc) will accept general JavaScript properties if they are passed in an array.<br />
In addition some elements may accept Cjax Properties as well such as ajax requests, or ajax form, 
continue reading to see some examples.

<h4>Examples</h4>
The following example adds style properties to div HTML element with the ID of "div_container". <br />
These style properties  are a small example, there is no limitation
on which properties you may add, to see a full list of style properties <a target="_blank" href="dom_style_list.php">click here</a>.
<?php
echo $ajax->code("
\$ajax->div_container = array(
	'style' => array(
		'backgroundColor' => '#FF9E3E',
		'width' => '300px',
		'heigh' => '200px'
));");
?>
You may also assign/set direct element properties that would otherwise go in their tag constructor.
You may set element properties to any element as long that element has an id.
<h5>Example</h5>
<?php
echo $ajax->code("
\$ajax->html_table = array('width' => 600);

\$ajax->td_id = array('width' => 200,'height' => 100, 'colspan' => 3);

\$ajax->tr_id = array('innerHTML' => '<td>some data</td>');

");?>
<h5>Example</h5>
<?php
echo $ajax->code("
\$ajax->some_image = array('width' => 300,'height' => 200, 'src' => 'some/image/url');

//see 'Main Property' documentation for 'Elements Properties'
//changes the src property of an image
\$ajax->some_image = 'some/image/url';
");?>
<br />


While you assign some properties to an element, you may still continue manipulating it. All properties accumulate.
<br /><br />
If the container has node of type div or span, you may assign Ajax requests to it, the response of the request will flow to the container.

<?php 
echo $ajax->code("
\$ajax->div_container = \$ajax->call(\"url/to/a/controller\");
");?>
<br />
If the element you'd like to manipulate is a button, you may assign Ajax Forms to it (element must be inside a form).
<?php 
echo $ajax->code("
\$ajax->button_id = \$ajax->form(\"url/to/post/action\");
");?>
Assigning a string to the button will change it's value/label. While it still submits the ajax form above.
<?php 
echo $ajax->code("
\$ajax->button_id =  \"Button Label\";
");?>

<?php 
echo $ajax->code("
//change the id of the DIV
\$ajax->div_container = array('id' => 'New_div_id');

//div_container does exist anymore, now is New_div_id
\$ajax->New_div_id = \"Hello!\";
");?>








