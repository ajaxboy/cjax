<?php

require_once "ajax.php";
$ajax = ajax();

## The  validation array below uses the exact same format as it does in the Jquery.validate plugin javascript format.

# you may use custom handlers:
# submitHandler  => "function() {}"
# invalidHandler  => "function() {}"

### button_id, $validate - rules, messages, handlers, errorElement, see jquery.validation to see available options.

//$ajax->log = 1;
if($ajax->isPlugin('validate')) {
		
	$settings = array(
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
	
	$validate = $ajax->validate('btn_saveForm', null, $settings);
	
	//$validate->imports(array('jquery-1.7.2.min.js','jquery.validate.min.js'));
	
	
} else {
	$data = "
	<h2 style='color:red;'>Cjax validate plugin was not found. Install it, then refresh this page.</h2>
	<br />
	This plugin is by default not included in this package. You must  download the zip and place its content in cjax/plugins directory.
	<h4>Download This plugin</h4>
	<a target='_blank' href='https://sourceforge.net/projects/cjax/files/Plugins/'>https://sourceforge.net/projects/cjax/files/Plugins/</a>
	
	";
	$ajax->update("not_found",$data);
}


$ajax->Exec("btn_saveForm",$ajax->form("ajax.php?send_form/validate","form1"));

### below is an HTML form.  All you need is the id of the form, and all the code is needed is above. 
### look inside controllers/send_form.php for response code sample.


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $ajax->init();?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Validate Form...</title>
	<link rel="stylesheet" type="text/css" href="resources/send_form/view.css" media="all">
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
	 
	<script type="text/javascript" src="resources/send_form/view.js"></script>
</head>
<body>
<h2>Validate</h2>

<div id='not_found'></div>


<br />
<br />
This Plugins uses Jquery and Jquery.validate plugin to dynamically add validation functionality to your forms through CJAX Api.
<br />
<h4>Download Plugins</h4>
<ul>
 <li><a target="_blank" href="http://docs.jquery.com/Main_Page">http://docs.jquery.com/Main_Page</a></li>
 <li><a target="_blank" href="http://docs.jquery.com/Plugins/Validation">http://docs.jquery.com/Plugins/Validation</a></li>
 <li><a target="_blank" href="https://sourceforge.net/projects/cjax/files/Plugins/">https://sourceforge.net/projects/cjax/files/Plugins/</a></li>
</ul>
Code Used:
<?php 

echo $ajax->code("
\$validate = array(
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
			'email' => true
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

//add validation to btn_saveForm parent form
\$ajax->validate('btn_saveForm', \$validate);

\$ajax->Exec(\"btn_saveForm\",\$ajax->form(\"ajax.php?send_form/validate\",\"form1\"));
");
?>

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
				<input id="btn_saveForm" class="button_text" type="submit" name="btn_saveForm" value="Submit" />
		</li>
			</ul>
		</form>	
		<div id="footer">
			Generated by <a href="http://www.phpform.org">pForm</a>
		</div>
	</div>
	<img id="bottom" src="resources/send_form/bottom.png" alt="">
</div>
	</body>

</html>
