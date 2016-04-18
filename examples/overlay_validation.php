<?php

require_once 'ajax.php';


//$ajax->log = true;

$rules = [
	'rules' => [
		'a[name]' => [
			'required' => true,
			'minlength'  => 5,
		],
		'a[last_name]' => [
			'required' => true,
			'minlength'  => 5,
		]
	],
	'messages' => [
		'a[name]' => [
			'required' => 'Please enter your name',
		],
		'a[last_name]' => [
			'required' => 'Enter your last name',
		]
	]
];

$overlay = $ajax->overLay('resources/html/test_form.html');
//surging from $overlay ensures that it is ran after the html has been generated.
$overlay->validate('button1','ajax.php?overlayvalidation/form', $rules);

//die("cache<pre>".print_r(CoreEvents::$cache,1). "cbs<pre>".print_r(CoreEvents::$callbacks,1));

//ensure that it validation is ran after the html form is generated.
//$overlay->callback = $ajax->validate('button1','ajax.php?overlayvalidation/form', $rules);

$ajax->click('link', $overlay);



$ajax->click('link2', $ajax->call('ajax.php?overlayvalidation/overlay2'));

## Display the code that is used
$code = $ajax->code("
//5.0-RC3+
//Total 3 lines of code!, (not including the customs rules)

//Note: For sample#2 look inside the controller: examples/controllers/overlayvalidation.php:OverlayValidation::overlay2();

#Sample #1
//initial action to the 'launch' link
\$rules = [
	'rules' => [
		'a[name]' => [
			'required' => true,
			'minlength'  => 5,
		],
		'a[last_name]' => [
			'required' => true,
			'minlength'  => 5,
		]
	],
	'messages' => [
		'a[name]' => [
			'required' => 'Please enter your name',
		],
		'a[last_name]' => [
			'required' => 'Enter your last name',
		]
	]
];

 
\$overlay = \$ajax->overLay('resources/html/test_form.html');
\$overlay->validate('button1','ajax.php?overlayvalidation/form', \$rules);

\$ajax->click('link', \$overlay);

//Controller
namespace Examples\\Controllers;
use CJAX\\Core\\AJAXController;

class OverlayValidation extends AJAXController{
	
	public function form(){
		//show posted variables
		\$this->ajax->debug(\$_POST,'Post Debug Info',\"These are the fields posted.\");
	}
}
");

$ajax->exec('code', $ajax->overlayContent($code, ['width'=> '950px','top'=> '40px']));
?>
<head>
<?php echo $ajax->init();?>
<title>Ajax Overlay and Validation</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
</head>
<h2>Ajax Overlay and Validation</h2>
<br />
This sample makes use of different CJAX APIs to create a Overlay/validation functionality. The validation plugin makes use of
Jquery.validate plugin.
<br />
<br />

This sample can be downloaded along with 20+ demos here: <a href='http://cjax.sourceforge.net/examples/'>http://cjax.sourceforge.net/examples/</a>
<br /><br />

<br />
<a id='code' href='#'>View Code Used</a>

<br />
<br />
Used in sample:
<ul>
	<li>
	<a target='_blank' href='click_ajax_request.php'>$ajax->call()</a>
	</li>
	<li>
	<a target='_blank' href='overlay.php'>$ajax->overLay()</a> (Used in Sample #1)
	</li>
	<li>
	<a target='_blank' href='overlay.php'>$ajax->overlayContent()</a> (Used in Sample #2)
	</li>
	<li>
	<a target='_blank' href='plugin_validate.php'>Cjax Plugin Jquery Validate</a>
	</li>
</ul>
<a id='link' href='#'>Launch Sample #1</a>
<br />
<br />
<a id='link2' href='#'>Launch Sample #2</a>

<br />