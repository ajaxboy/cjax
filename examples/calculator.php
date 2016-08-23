<?php
//core file, reference..
require_once "ajax.php";

$ajax = ajax();


//add ajax call to each button, so when you click it it fires and sends the desired operation.

$buttons = array(0,1,2,3,4,5,6,7,8,9,'p','m','x','c','e','d');

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
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
	<title>Ajax Calculator</title>
	<?php echo $ajax->init();?>
</head>
<body>
<header>
	<div style='padding: 15px;'>
		<a href='http://cjax.sourceforge.net'><img src='http://cjax.sourceforge.net/media/logo.png' border=0/></a>
	</div>
</header>
<!-- START NAVIGATION -->
<div id="nav"><div id="nav_inner"></div></div>
<div id="nav2"><a name="top">&nbsp;</a></div>
<div id="masthead">
	<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
		<tr>
			<td><h1>Cjax Framework</h1></td>
			<td id="breadcrumb_right"><a href="#">Demos</a></td>
		</tr>
	</table>
</div>
<!-- END NAVIGATION -->



<!-- START BREADCRUMB -->
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
	<tr>
		<td id="breadcrumb">
			<a href="http://cjax.sourceforge.net/">Project Home</a> &nbsp;&#8250;&nbsp;
			<a href="./">Demos</a> &nbsp;&#8250;&nbsp;
			Ajax Calculator
		</td>
		<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
	</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


	<!-- Text -->
	This is a fully functional ajax calculator, for each operation fires an ajax call and uses the ajax controller to process it.
	<br />
	Although it is not a scientific calculator, it is the most advanced ajax calculator powered by an Ajax Framework, most just do simple addition of 2 numbers.
	<br />
	This is just an example of what you can do with the Cjax Framework.
	<br /><br />


	<br />

	<h3>Examples</h3>


	<!-- Code Used -->

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
class Calc {

	function math(\$action, \$buffer)
	{
		\$ajax = ajax();

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
", true, true);
	?>


	<!-- HTML -->

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

	<br />
</div>
<!-- END CONTENT -->

<div id="myfooter">
	<p>
		Previous Topic:&nbsp;&nbsp;<a href="#">Previous Class</a>
		&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;
		<a href="#top">Top of Page</a>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;
		<a href="http://cjax.sourceforge.net/examples">Demos Home</a>&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;
		<!-- Next Topic:&nbsp;&nbsp;<a href="#">Next Class</a> -->
	</p>
	<p>
		<a href="http://codeigniter.com">CodeIgniter</a> &nbsp;&middot;&nbsp; Copyright &#169; 2006 - 2012 &nbsp;&middot;&nbsp;
		<a href="http://cjax.sourceforge.net/">Cjax</a>
	</p>
</div>

</body>
</html>