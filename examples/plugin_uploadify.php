<?php

require 'ajax.php';

if($ajax->isPlugin('uploadify')) {

## The  settings below use the exact same format as it does in the Jquery.uploadify plugin javascript format.
	
	//Paths are relative to uploadify plugin directory.
	$uploadify = $ajax->uploadify('.upload', [
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
	]);
	
	
	//Example of overwritting options, you may overwrite any available options
	$uploadify->fileTypeDesc = 'Media Files';
	//Update extensions supported to upload
	$uploadify->fileTypeExts = '*.pdf;*.docx;*.doc;*.jpg;*.png;*.gif;*.zip;*.exe';
		
	#####UPLOAD DIRECTORY#######
	//enter your upload directory path here, make sure is writeable (chmoded)
	$uploadify->target = "../examples/resources/images/uploads";
	//replace the above line to the directory where you want the uploads to go
} else {
	$data = "
	<h2 style='color:red;'>Cjax uploadify plugin was not found. Install it, then refresh this page.</h2>
	<br />
	This plugin is by default not included in this package. You must  download the zip and place its content in cjax/plugins directory.
	<h4>Download This plugin</h4>
	<a target='_blank' href='https://sourceforge.net/projects/cjax/files/Plugins/'>https://sourceforge.net/projects/cjax/files/Plugins/</a>
	
	";
	$ajax->update("not_found",$data);
}

$code =  $ajax->code("

//Paths are relative to uploadify plugin directory.
\$uploadify = \$ajax->uploadify('.upload', [
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
]);

		
//Example of overwritting options, you may overwrite any available options
\$uploadify->fileTypeDesc = 'Media Files';
//Update extensions supported to upload
\$uploadify->fileTypeExts = '*.pdf;*.docx;*.doc;*.jpg;*.png;*.gif;*.zip';

//UPLOAD DIRECTORY
//if you remove this line, it will  be by default uploaded to the plugin uploads/ directory . (if writable)
\$uploadify->target = '../examples/resources/images/uploads';
//replace the above line to the directory where you want the uploads to go

");
$ajax->exec('see', $ajax->dialog($code, 'Code Used', array('width'=> '930px','top'=> 20)));

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Uploadify in PHP</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<?php  echo $ajax->init();?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script type="text/javascript" src="resources/send_form/view.js"></script>
	<link rel="stylesheet" type="text/css" href="resources/send_form/view.css" media="all">
</head>
<body>
<h2>uploadify 1.6</h2>

<div id='not_found'></div>
<h4 id='see'><a href='#'>See Code Used</a></h4>

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


?>
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
	</body>

</html>