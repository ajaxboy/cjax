<?php

require_once 'ajax.php';


//$ajax->log = true;

$rules = array(
	'rules' => array(
		'file1' => array(
			'required' => true
		),
		'file2' => array(
			'required' => true
		),
	
	),
	'messages' => array(
		'file1' => array(
			'required' => 'Please select a file'
			),
		'file2' => array(
			'required' => 'Please select a file'
			)
		)
);

	
$ajax->validate('btnSubmit', null, $rules)->uploader(
	array(
		'target' => './',//$ajax->config->uploader_dir.'validation_uploader/',
		'text'=> 'Submitting Form..',
		'url' => 'ajax.php?validation_uploader/post',
		'success_message' => 'Form submitted successfully.',
		'form_id' => 'form1',
		'suffix' => time()
		)
	);


## Display the code that is used
$code = $ajax->code("
//5.1+

\$rules = array(
	'rules' => array(
		'file1' => array(
			'required' => true
		),
		'file2' => array(
			'required' => true
		),
	
	),
	'messages' => array(
		'file1' => array(
			'required' => 'Please select a file'
			),
		'file2' => array(
			'required' => 'Please select a file'
			)
		)
);


\$ajax->validate('btnSubmit', null, \$rules)->uploader(
	array(
		'target' => 'upload/directory/',
		'url' => 'ajax.php?validation_uploader/post',
		'success_message' => 'Form submitted successfully.'
		)
	);
");

$ajax->Exec('code', $ajax->overlayContent($code, array('width'=> '950px','top'=> '40px')));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Validation and Uploader</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="resources/send_form/view.css" media="all">
<script type="text/javascript" src="resources/send_form/view.js"></script>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Validation and Uploader Integration - Cjax 5.1+</h2>
<br />
This sample makes use of two different CJAX Plugins "validation" and "uploader" to create a full form-submission functionality.
The validation plugin makes use of Jquery and
Jquery.validate plugin, the uploader plugin is independent.
<br />
Validation plugin allows you to add unlimited validatation to your forms through the validate plugin, and the
uploader plugin allows you to upload as many files as you like through ajax, the convination of these two plugins
provide alot of flexibility such as pre-upload form submittion functionality (optionally the form can be submitted before the files are uploaded, then it can upload the files) and the post-form submittion which 
submits the form after the files have been uploaded, so there are three stages (pre, upload and post, the upload is automatic - while you control the pre and post). You may want to check out these two plugins invidiually to get a full idea how each one of them work.
<br />
<br />
This integration can be as simple as you want you or as sofisticated as you  want!, since all settings are optional except the button_id and the upload directory!.
<br />
<br />
This integration allows you to do advanced functionality that can fit just about any project due to the flexiblity on both plugins.
If you need to create directories before the the files are uploaded you may do so with the pre-post submition with the second validate parameter (specify a url). Then
the post-form submition  (url setting in the uploader)  to save the form data, while both are optional. And the footprint is so small!.
<br />
<a id='code' href='#'>View Code Used</a>

<br />
<br />
Used in sample:
<ul>
	<li>
	<a target='_blank' href='plugin_validate.php'>Cjax Plugin Jquery Validate</a>
	</li>
	<li>
	<a target='_blank' href='plugin_upload_files.php'>Uploader Plugin</a>
	</li>
</ul>

<div id="main_body" >
	<img id="top" src="resources/send_form/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Send form to server using ajax..</a></h1>

		<form id="form1" name="form1" class="appnitro"  method="POST" action="/">
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
			<li id="li_4">
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
			<li id="li_4" >
				<label class="description" for="element_1">File#1 </label>
				<div>
					<input id="file1" name="file1" class="element text medium" type="file" maxlength="255"/> 
				</div> 
			</li>
			<li id="li_5" >
				<label class="description" for="element_1">File#2 </label>
				<div>
					<input id="file2" name="file2" class="element text medium" type="file" maxlength="255"/> 
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
				<input id="btnSubmit" class="button_text" type="submit" name="btnSubmit" value="Submit" />
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