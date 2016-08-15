<?php

require 'ajax.php';

?>
<head>
<?php echo $ajax->init();?>
<title>Ajax Framework | Elements Functions</title>
</head>
<h2>Element Functions</h2>

<table class='table'>
<tr>
	<td>$alax->focus();</td>
	<td>Focus Element</td>
	<td>$alax->focus('#element_id');</td>
</tr>
<tr>
	<td>$alax->append();</td>
	<td>Append HTML to element</td>
	<td>
	$alax->append('#element_id','Content Here');
	<br />
	$alax->append('#element_id','#element_id2');
	</td>
</tr>
<tr>
	<td>$alax->prepend();</td>
	<td>Prepend HTML to element</td>
	<td>
	$alax->prepend('#element_id','Content Here');
	<br />
	$alax->prepend('#element_id','#element_id2');
	</td>
</tr>
<tr>
	<td>$alax->click();</td>
	<td>
	Triggers element's click. 
	Or triggers a callback function on element's click.</td>
	<td>
	$alax->click('#element_id');
	<br />
	$alax->click('#element_id',"function(element) {
		alert(element);
	}");
	</td>
</tr>
<tr>
	<td>$alax->click('#element_id');</td>
</tr>
</table>
