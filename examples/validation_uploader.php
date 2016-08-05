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
?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
	<title>Validation and Ajax Uploader</title>
	<?php echo $ajax->init();?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Validation and Uploader</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
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
			Validation and Ajax File(s) Uploader
		</td>
		<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
	</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">

	<h2>Validation and Uploader Integration - Cjax 5.1+</h2>

	<!-- Text -->
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


	<br />

	<h3>Examples</h3>


	<!-- Code Used -->
	<?php
	echo $code = $ajax->code("
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
	?>

	<!-- HTML -->

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

	<br />


	<br />
	Used in sample:
	<ul>
		<li>
			<a target='_blank' href='plugin_validate.php'>Cjax Plugin Jquery Validate</a>
		</li>
		<li>
			<a target='_blank' href='plugin_uploader.php'>Uploader Plugin</a>
		</li>
	</ul>
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
