<?php

//core file, reference..
require_once "ajax.php";
//initiate CJAX..

//this example is almost identical to "propagate_dropdown" except a small change in the controler method.


$ajax->change("dropdown1",$ajax->call("ajax.php?dropdown/propagate_allow_input/|dropdown1|"));

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Dropdown input</title>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Dropdown input</h2>
<br />
This example is almost identical to the other example "propagate dropdown", except on this example when you select<br />
"other..", it displays a input box, to type in.
<br /><br />
<br />
<div>
	<select id='dropdown1'>
	<option value="" selected="selected">Other..</option>
	<option value="options">Options</option>
	<option value="states">Some States</option>
	</select>
	<br />
	<select id='dropdown2'>
	<option>Select something above..</option>
	</select>
</div>
<br />
<br />
<br />
Code used:
<?php
echo $ajax->code("
\$ajax->change(\"dropdown1\",\$ajax->call(\"ajax.php?dropdown/propagate_allow_input/|dropdown1|\"),\"change\");
");
?>

Controller:
<?php
echo $ajax->code("

class dropdown {
	function propagate_allow_input(\$selected)
	{
		\$ajax = ajax();
		\$data = array();
			
		switch(\$selected) {
			case 'options':
				\$data[] = \"Option 1\";
				\$data[] = \"Option 2\";
				\$data[] = \"Option 3\";
				\$data[] = \"Option 4\";
				\$data[] = \"Option 5\";
			break;
			case 'states':
				
				\$data[] = \"Texas\";
				\$data[] = \"Florida\";
				\$data[] = \"New York\";
				\$data[] = \"California\";
				\$data[] = \"New Mexico\";
				\$data[] = \"Maine\";
			break;
		}
		
		\$ajax->select('dropdown2',\$data,true);
			
	}
}
");?>
</body>
</html>
