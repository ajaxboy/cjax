<?php

require 'ajax.php';

?>
<head>
<?php echo $ajax->init();?>
<title>Ajax Framework | elements properties</title>
</head>
<h2>Element Properties</h2>
Changin/Setting element properties with the $ajax object follows the same logic as changing them in JavaScript. 
All you need is the ID of the element to be able to change/set its properties. This applies to all elements:
divs,spans,images , text, buttons, inputs, and other elements. You may change ANY property that is available in JavaScript for that element. 
As long it is a valid property you will be able to change/set its value.
<h3>Main Property</h3>
<?php echo $ajax->code("\$ajax->element_id = 'something';");?>
In Cjax all elements have a main property. "element_id" would be of course the id of the element you wish to interact with. 'something' is the value, each element
has its main property, for example  an image's main property would be "src" so by using the statement above on an image
it would update its src property while if it is for a div or a span it would be updating/settings its innerHTML. For checkboxes
you may use boolean (true or false) inputs to check/uncheck.
<br /><br />
<B>Note:</B> <i>General Properies and Style Properties are only possible after</i> version 5.0-RC1.
<br />

<table>
<thead>
<tr>
<th>
Element
</th>
<th>
Main Property
</th>
</tr>
</thead>
	<tr>
		<td>
		Image
		</td>
		<td>
		src
		</td>
	</tr>
	<tr>
		<td>
		Div,Span
		</td>
		<td>
		innerHTML
		</td>
	</tr>
	<tr>
		<td>
		input (text,checkbox,hidden, etc)
		</td>
		<td>
		value
		</td>
	</tr>
	<tr>
		<td>
		link
		</td>
		<td>
		href
		</td>
	</tr>
</table>

<h3>General Properties</h3>
If you intend to update other properies in that element, use an array instead.
<br />
Example:
<?php echo $ajax->code("
\$ajax->element_id = array('width' => 200,'height'=> 100);
");?>
<h3>Style Properties</h3>
To update the style property of an element follow the same logic as before:
<?php echo $ajax->code("
\$ajax->element_id = array(
	'style' => array(
		'width' => '200px',
		'height' => '100px',
		'borderStyle' => 'solid',
		'borderWidth' => '1px'
	)
);
");?>
<h3>Properties Accumulate</h3>
Changing properies of an element, and later changing them again will not undo the previous set of properties, it will accumulate.
<br />
All properies will be applied to the element,  you can however overwrite  specific properties. If the same property is being use the latest one will stand.
<br />
In the example below all properties are taken into account, however the style property width and height will overwrite the previous width and height set.
<?php echo $ajax->code("
\$ajax->my_image = 'http://cjax.sourceforge.net/media/logo.png';
\$ajax->my_image = array('width' => 200,'height'=> 100, 'alt' => 'this is a logo');
\$ajax->my_image = array(
	'style' => array(
		'width' => '200px',
		'height' => '100px',
		'borderStyle' => 'solid',
		'borderWidth' => '1px'
	)
);
");?>



