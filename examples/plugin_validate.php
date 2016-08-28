<?php

require_once "ajax.php";
$ajax = ajax();

## The  validation array below uses the exact same format as it does in the Jquery.validate plugin javascript format.

# you may use custom handlers:
# submitHandler  => "function() {}"
# invalidHandler  => "function() {}"

### button_id, $validate - rules, messages, handlers, errorElement, see jquery.validation to see available options.

//$ajax->log = 1;

$rules = array(
	'rules' => array(
		'a[name]' => array(
			'required' => true,
			'minlength'  => 5,
		),
		'a[last_name]' => array(
			'required' => true,
			'minlength'  => 5,
		),
		'a[email]' => array(
			'required' => false,
			'email' => false
		)
	),
	'messages' => array(
		'a[name]' => array(
			'required' => 'Please enter your name',
		),
		'a[last_name]' => array(
			'required' => 'Enter your last name',
		),
		'a[email]' => array(
			'required' => 'Email is required',
		)

	)
);

$validate = $ajax->validate('btn_saveForm', 'ajax.php?send_form/validate', $rules);

$rule  = array(
	'required' => array( true , 'This field is required!'),
	'minlength'=> array( 2 ,'Minimum length is 2!')
);

$validate->rule('a[state]',$rule);
	
	
	//$validate->imports(array('jquery-1.7.2.min.js','jquery.validate.min.js'));
	


$rules = $ajax->code("
\$rules = array(
	'rules' => array(
		'a[name]' => array(
			'required' => true,
			'minlength'  => 5,
		),
		'a[last_name]' => array(
			'required' => true,
			'minlength'  => 5,
		),
		'a[email]' => array(
			'required' => true,
			'email' => true  //in this demo is set to false to make it faster but it works.
		)
	),
	'messages' => array(
		'a[name]' => array(
			'required' => 'Please enter your name',
		),
		'a[last_name]' => array(
			'required' => 'Enter your last name',
		),
		'a[email]' => array(
			'required' => 'Email is required',
		)
		
	)
);
");


$code = $ajax->code("
\$validate = \$ajax->validate('btn_saveForm', 'ajax.php?send_form/validate', \$rules);
");

$ajax->click('code', $ajax->overlayContent($code, array('width'=> '800px','top'=>30)));


$more_code = $ajax->code("
\$rule  = array(
	'required' => true, //no custom message
	'minlength'=> array( 2 ,'Minimum length is 2!') //with custom message
);
// field name, rule
\$validate->rule('a[state]',\$rule);
");




### below is an HTML form.  All you need is the id of the form, and all the code is needed is above. 
### look inside controllers/send_form.php for response code sample.


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $ajax->init(false);?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Validate Form...</title>
	<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
	<link rel="stylesheet" type="text/css" href="resources/send_form/view.css" media="all">
	<script type="text/javascript" src="resources/send_form/view.js"></script>
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
Validate Plugin
</td>
<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


<h1>Validate Plugin</h1>

<p>This Plugins uses Jquery and Jquery.validate plugin to dynamically add validation functionality to your forms through CJAX Api.</p>

<p>Features:</p>

<ul>
	<li>Validate Unlimited forms & unlimited fields through Ajax API</li>
	<li>Specify POST URL</li>
</ul>

<h2>Plugin Usage</h2>

<h3>Defining Rules</h3>

<p>Rules are defined in an array and take exactly the same format they take in the original jquery.validate plugin. You may also specify messages that goes with each rule.
<br />
Enter an field entry to for each field you which to validate. Each entry takes the field's "name" not the id.

</p>

<?php echo $rules;?>

<h2>Parameters</h2>

<p>Validate plugin takes the following parameters</p>


<table cellspacing="1" cellpadding="0" border="0" class="tableborder" style="width:100%">
<tbody><tr>
	<th>Variable</th>
	<th>Required</th>
	<th>Type</th>
	<th>Options</th>
	<th>Description</th>
</tr>
<tr>
	<td class="td"><strong>$button_id</strong></td>
	<td class="td">Yes</td>
	<td class="td">String</td>
	<td class="td">May be a submit button, image or any element.</td>
	<td class="td">Button Id which you click on to submit the form. Button <kbd>MUST</kbd> be inside a form.</td>
</tr>
<tr>
	<td class="td"><strong>$post_url</strong></td>
	<td class="td">Yes</td>
	<td class="td">String</td>
	<td class="td">ajax.php?controller/action</td>
	<td class="td">Url which the form will be posted to if all fields are valid.</td>
</tr>
<tr>
	<td class="td"><strong>$rules</strong></td>
	<td class="td">Yes</td>
	<td class="td">Array</td>
	<td class="td">rules, messages, and others.</td>
	<td class="td">Rules to validate the form.</td>
</tr>
</tbody></table>

<?php echo $code;?>

<h3>Additional Rules</h3>

<p>You may add addional rules to your already defined rules.</p>

<?php echo $more_code; ?>

<p>Additional Resources:</p>

<ul>
	<li><a target="_blank" href="http://docs.jquery.com/Main_Page">http://docs.jquery.com/Main_Page</a></li>
	<li><a target="_blank" href="http://docs.jquery.com/Plugins/Validation">http://docs.jquery.com/Plugins/Validation</a></li>
	<li><a target="_blank" href="https://sourceforge.net/projects/cjax/files/Plugins/">https://sourceforge.net/projects/cjax/files/Plugins/</a></li>
</ul>

<h2>Demo</h2>

<a href="#" id="code">View</a>

<div id='not_found'></div>

<div id="main_body" >
	<img id="top" src="resources/send_form/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Test validation..</a></h1>

		<form id="form1" class="appnitro"  method="POST" action="">
					<div class="form_description">
			<h2>Submit Form</h2>
			<p>Send any form data through ajax...</p>
		</div>						
		<ul>
		<li id="li_2" >
			<label class="description" for="element_2">Name </label>
	
			<span>
				<input id="a[name]" name="a[name]" class="element text" maxlength="255" size="8" value=""/>
				<label>First</label>
			</span>
			<span>
				<input id="a[last_name]" name="a[last_name]" class="element text" maxlength="255" size="14" value=""/>
				<label>Last</label>
			</span> 
		</li>
		<li id="li_4" >
			<label class="description" for="element_4">Drop Down </label>
			<div>
			<select class="element select medium" id="a[drop_down]" name="a[drop_down]"> 
				<option value="" selected="selected"></option>
				<option value="1" >First option</option>
				<option value="2" >Second option</option>
				<option value="3" >Third option</option>
			</select>
	
			</div> 
		</li>
		<li id="li_3" >
			<label class="description" for="element_3">Email </label>
	
			<div>
				<input id="a[email]" name="a[email]" class="element text medium" type="text" maxlength="255" value=""/> 
			</div> 
		</li>
		<li id="li_1" >
			<label class="description" for="element_1">Country </label>
			<div>
				<input id="a[country]" name="a[country]" class="element text medium" type="text" maxlength="255" value=""/> 
			</div> 
			</li>
		<li id="li_3" >
			<label class="description" for="element_3">State </label>
	
			<div>
				<input id="a[state]" name="a[state]" class="element text medium" type="text" maxlength="255" value=""/> 
			</div> 
		</li>
			
		<li class="buttons">
				<input id="btn_saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>	
		<div id="footer">
			Generated by <a href="http://www.phpform.org">pForm</a>
		</div>
	</div>
	<img id="bottom" src="resources/send_form/bottom.png" alt="">
</div><!-- END demo -->

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