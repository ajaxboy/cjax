<?php

require 'ajax.php';

$ajax =  ajax();


## The  settings below use the exact same format as it does in the Jquery.uploadify plugin javascript format.

//Paths are relative to uploadify plugin directory.
$uploadify = $ajax->uploadify('.upload', array(
	'height' => 22,
	'checkExisting' => true, //or false
	'fileTypeDesc' => 'Images Files',
	'fileTypeExts' => '*.jpg;*.png;*.gif',
	'onUploadStart' => "function(obj, file) {
		uploadify.loading('Uploading '+file+'...');
	}",
	'onUploadProgress' => "function(file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {
		uploadify.loading(totalBytesUploaded + ' bytes uploaded of ' + totalBytesTotal + ' bytes.');
	}",
	'onUploadSuccess' => "function(file, data, response) {
		uploadify.success('The file ' + file.name + ' was successfully uploaded.');
	}",
	'onUploadError' => "function() {
		uploadify.warning('An error occurred!');
	}",
	'onError' => "function() {
		uploadify.error('An error occurred!');
	}"
));


	//Example of overwritting options, you may overwrite any available options
	$uploadify->fileTypeDesc = 'Media Files';
	//Update extensions supported to upload
	$uploadify->fileTypeExts = '*.pdf;*.docx;*.doc;*.jpg;*.png;*.gif;*.zip;*.exe';

	#####UPLOAD DIRECTORY#######
	//enter your upload directory path here, make sure is writeable (chmoded)
	$uploadify->target = $_SERVER['DOCUMENT_ROOT'];
	//replace the above line to the directory where you want the uploads to go

?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
	<title>Uploadify in PHP</title>
	<?php  echo $ajax->init(false);?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script type="text/javascript" src="resources/send_form/view.js"></script>
	<link rel="stylesheet" type="text/css" href="resources/send_form/view.css" media="all">
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
			Uploadify and Cjax
		</td>
		<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
	</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


	<!-- Text -->
	Upload files with Flash and Cjax, by using Uploadify - completely in PHP!

	<!-- Code Used -->
	<?php
	echo $ajax->code("

	//Paths are relative to uploadify plugin directory.
	\$uploadify = \$ajax->uploadify('.upload', array(
	'height' => 22,
	'checkExisting' => true, //or false
	'fileTypeDesc' => 'Images Files',
	'fileTypeExts' => '*.jpg;*.png;*.gif',
	'onUploadStart' => \"function() {
	uploadify.loading('Uploading file...');
	}\",
	'onUploadProgress' => \"function(file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {
	uploadify.loading(totalBytesUploaded + ' bytes uploaded of ' + totalBytesTotal + ' bytes.');
	}\",
	'onUploadSuccess' => \"function(file, data, response) {
	uploadify.success('The file ' + file.name + ' was successfully uploaded.');
	}\",
	'onUploadError' => \"function() {
	uploadify.warning('An error occurred!');
	}\",
	'onError' => \"function() {
	uploadify.error('An error occurred!');
	}\"
	));


	//Example of overwritting options, you may overwrite any available options
	\$uploadify->fileTypeDesc = 'Media Files';
	//Update extensions supported to upload
	\$uploadify->fileTypeExts = '*.pdf;*.docx;*.doc;*.jpg;*.png;*.gif;*.zip';

	//UPLOAD DIRECTORY
	//if you remove this line, it will  be by default uploaded to the plugin uploads/ directory . (if writable)
	\$uploadify->target = \$_SERVER['DOCUMENT_ROOT'];
	//replace the above line to the directory where you want the uploads to go

	");?>

	<!-- HTML -->

	<div id="main_body" >
		<img id="top" src="resources/send_form/top.png" alt="">
		<div id="form_container">

			<h1><a>Upload..</a></h1>

			<form id="form1" class="appnitro"  method="POST" action="">
				<div class="form_description">
					<h2>Submit Form</h2>
					<p>Upload files through uploadify plugin...</p>
				</div>
				<ul>
					<li id="li_2" >
						<label class="description" for="element_3">Pick1 </label>

						<div>
							<input  id="upload1" name="upload1" class="upload element text medium" type="file" maxlength="255" value=""/>
						</div>
					</li>
					<li id="li_3" >
						<label class="description" for="element_3">Pick2 </label>

						<div>
							<input  id="upload2" name="upload2" class="upload element text medium" type="file" maxlength="255" value=""/>
						</div>
					</li>
					<li id="li_1" >
						<label class="description" for="element_1">Pick3</label>
						<div>
							<div style="width:100%">
								<input  id="upload3" name="upload3" class="upload element text medium" type="file" maxlength="255" value=""/>
							</div>
						</div>
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
	<br />
	This Plugins uses Jquery and Jquery.uploadify plugin to upload files through flash and CJAX Api.
	<br />
	<ul>
		<li><a target="_blank" href="http://docs.jquery.com/Main_Page">http://docs.jquery.com/Main_Page</a></li>
		<li><a target="_blank" href="http://www.uploadify.com/documentation/">http://www.uploadify.com/documentation/</a></li>
		<li><a target="_blank" href="http://sourceforge.net/projects/cjax/files/Plugins/">http://sourceforge.net/projects/cjax/files/Plugins/</a></li>
	</ul>

	All methods available in uploadify are also available here, you may change these settings.
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
