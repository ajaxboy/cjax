<?php

//core file, reference..
require_once "ajax.php";
//initiate CJAX..
$ajax = ajax();

//this is as simple as it gets..


$ajax->change("dropdown1",$ajax->call("ajax.php?dropdown/propagate/|dropdown1|"));

?>
<html>
<head>
<title>Propagate dropdowns through ajax</title>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Propagate dropdowns through ajax</h2>
<br />
<select id='dropdown1'>
<option value="" selected="selected">Other..</option>
<option value="options">Options</option>
<option value="states">Some States</option>
</select>
<br />
<select id='dropdown2'>
<option>Select something above..</option>
</select>
<br />
<br />
<br />
<br />
Code Used:
<?php
echo $ajax->code("

\$ajax->Exec(\"dropdown1\",\$ajax->call(\"ajax.php?dropdown/propagate/|dropdown1|\",\"change\"));

//OR as of 5.1

\$ajax->change(\"dropdown1\",\$ajax->call(\"ajax.php?dropdown/propagate/|dropdown1|\"));
");?>

Controller:
<?php
echo $ajax->code("


class dropdown {
	
	function propagate(\$selected)
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
		
		\$ajax->select('dropdown2',\$data);
		
	}
}
");?>
</body>
</html>
