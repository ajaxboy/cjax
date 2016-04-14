<?php

require_once 'ajax.php';

//add ajax call to each button, so when you click it it fires and sends the desired operation.

$buttons = [0,1,2,3,4,5,6,7,8,9,'p','m','x','c','e','d'];

do {
	$button = current($buttons);
	$ajax->click("button{$button}", $ajax->call("ajax.php?calc/math/{$button}/|buffer|"));
} while($buttons && next($buttons));


/*
 * //OR you could add the even to each button.
$ajax->click('button1', $ajax->call('ajax.php?calc/math/1/|buffer|'));
$ajax->click('button2', $ajax->call('ajax.php?calc/math/2/|buffer|'));
$ajax->click('button3', $ajax->call('ajax.php?calc/math/3/|buffer|'));
$ajax->click('buttonp', $ajax->call('ajax.php?calc/math/p/|buffer|'));
$ajax->click('button4', $ajax->call('ajax.php?calc/math/4/|buffer|'));
$ajax->click('button5', $ajax->call('ajax.php?calc/math/5/|buffer|'));
$ajax->click('button6', $ajax->call('ajax.php?calc/math/6/|buffer|'));
$ajax->click('buttonm', $ajax->call('ajax.php?calc/math/m/|buffer|'));
$ajax->click('button7', $ajax->call('ajax.php?calc/math/7/|buffer|'));
$ajax->click('button8', $ajax->call('ajax.php?calc/math/8/|buffer|'));
$ajax->click('button9', $ajax->call('ajax.php?calc/math/9/|buffer|'));
$ajax->click('buttonx', $ajax->call('ajax.php?calc/math/x/|buffer|'));
$ajax->click('buttonc', $ajax->call('ajax.php?calc/math/c/|buffer|'));
$ajax->click('button0', $ajax->call('ajax.php?calc/math/0/|buffer|'));
$ajax->click('buttone', $ajax->call('ajax.php?calc/math/e/|buffer|'));
$ajax->click('buttond', $ajax->call('ajax.php?calc/math/d/|buffer|'));
*/
?>
<html>
<head>
<title>Ajax Calculator</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<?php echo $ajax->init();?>
</head>
<body>
<h3>Ajax Calculator</h3>
This is a fully functional ajax calculator, for each operation fires an ajax call and uses the ajax controller to process it.
<br />
Although it is not a scientific calculator, it is the most advanced ajax calculator powered by an Ajax Framework, most just do simple addition of 2 numbers.
<br />
This is just an example of what you can do with the Cjax Framework.
<br /><br />
<form name="calc">
	<table border=4>
	<tr>
		<td>
		<input id='result' type="text"  name="input" size="16" value="0">
		<input id='buffer' type="hidden"   name="buffer">
		<br>
		</td>
	</tr>
	<tr>
		<td>
		<input id='button1' class='button' type="button" name="one"   value="  1  " />
		<input id='button2' class='button' type="button" name="two"   value="  2  " />
		<input id='button3' class='button' type="button" name="three" value="  3  " />
		<input id='buttonp' class='button' type="button" name="plus"  value="  +  " />
		<br>
		<input id='button4' class='button' type="button" name="four"  value="  4  " />
		<input id='button5' class='button' type="button" name="five"  value="  5  " />
		<input id='button6' class='button' type="button" name="six"   value="  6  " />
		<input id='buttonm' class='button' type="button" name="minus" value="  -  " />
		<br>
		<input id='button7' class='button' type="button" name="seven" value="  7  " />
		<input id='button8' class='button' type="button" name="eight" value="  8  " />
		<input id='button9' class='button' type="button" name="nine"  value="  9  " />
		<input id='buttonx' class='button' type="button" name="times" value="  x  " />
		<br>
		<input id='buttonc' class='button' type="button" name="clear" value="  c  " />
		<input id='button0' class='button' type="button" name="zero"  value="  0  " />
		<input id='buttone' class='button' type="button" name="doit"  value="  =  " />
		<input id='buttond' class='button' type="button" name="div"   value="  /  " />
		<br>
		</td>
	</tr>
</table>
</form>
<h4>Code Used</h4>
<?php 

echo $ajax->code("
\$buttons = array(0,1,2,3,4,5,6,7,8,9,'p','m','x','c','e','d');

do {
	\$button = current(\$buttons);
	\$ajax->click(\"button{\$button}\", \$ajax->call(\"ajax.php?calc/math/{\$button}/|buffer|\"));
} while(\$buttons && next(\$buttons));
");
?>
<h4>Controller</h4>
<?php 

echo $ajax->code("
    
use CJAX\\Core\\CJAX;
class Calc {
	
	function math(\$action, \$buffer){
		\$ajax = CJAX::getInstance();
		
		\$operators_signs = array('[plus]','p','m','x','d');
		\$operators = array('p','+','-','*','/');
		
		\$pre_buffer = \$buffer;
		\$buffer = \$ajax->buffer = \$buffer.\$action;
		\$buffer = str_replace(\$operators_signs, \$operators, \$buffer);
		
		switch(\$action) {
			case 'm'://minus
			case 'p'://plus
			case 'd'://divide
			case 'x'://times
			break;
			case 'c': //clear
				\$ajax->buffer = null;
				\$ajax->result = null;
			break;
			case '=': //equal
				\$buffer = rtrim(\$buffer,\"=+-\/*\");
				
				eval(\"\\\$action = ({\$buffer});\");
				
				\$ajax->result = \$action;
				\$ajax->buffer = \$action;
			break;
			default: //number
				
				//get previous operator used, if not then keep putting numbers together
				\$prev = rtrim(\$pre_buffer, \$action);
				\$prev = preg_replace(\"/[0-9]/\", '', \$prev);
				if(!in_array(\$prev, \$operators_signs)) {
					\$action = \$buffer;
				} else {
					\$action =  preg_replace(\"/.+[^0-9]/\", '', \$buffer);
				}
				\$ajax->result = \$action;
		
		}
	}
}
");
?>
</body>
</html>
