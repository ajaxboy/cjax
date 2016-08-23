<?php

require_once "ajax.php";

$ajax = ajax();

$uploader = $ajax->uploader(
	//settings are optional
	array(
		'suffix' => md5(time(). rand(1,10000000)), // makes files names universally unique,
		//sends the value of checkbox with that id, you can also say true or false
		'selector' => '.file', // css selector to know which fields to use. Make sure you add that class to the field.
		'use_debug' => '|use_debug|',
		'ext' => array('jpg','gif', 'png','jpeg'),
		'no_files' => 'Please select a file',
		//div where the thumbnails will appear.
		'preview_container' => 'response',
		'preview_type' => 'multi', //or single - shows just the current upload by replacing, or shows collect not replace
		'preview_dir' => 'http://cjax.sourceforge.net/uploads/',
		'overlay' => true,
	)
,'../uploads/');


$uploader = $ajax->uploader(
//settings are optional
	array(
		'suffix' => md5(time(). rand(1,10000000)), // makes files names universally unique,
		//sends the value of checkbox with that id, you can also say true or false
		'selector' => '.file2', // css selector to know which fields to use. Make sure you add that class to the field.
		'ext' => array('jpg','gif', 'png','jpeg'),
		//div where the thumbnails will appear.
		'preview_container' => 'placeholder2',
		'preview_dir' => 'http://cjax.sourceforge.net/uploads/',
		'overlay' => true,
	)
	,'../uploads/');


/*
$uploader = $ajax->uploader(
//settings are optional
	array(
		'after' => 'ajax.php?upload_file/post', //post request after files are uploaded
		'suffix' => md5(time(). rand(1,10000000)), // makes files names universally unique,
		'debug' => 'Debug Option is turned on this Demo.',
		//sends the value of checkbox with that id, you can also say true or false
		'use_debug' => '|use_debug|',
		'success_message' => 'File(s) @files successfully uploaded.', //@files tag is replaced by files uploaded.
		'ext' => array('jpg','gif', 'png','jpeg'),
		'no_files' => 'Please select a file',
		'preview_container' => 'placeholder',
		'preview_dir' => 'http://cjax.sourceforge.net/uploads/',
		'img_class' => 'img',
		'overlay' => true,
		'overlay_img_class' => 'img_overlay'
	)
	,'../uploads/');*/

?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
	<title>Ajax File Uploader</title>
	<?php echo $ajax->init(false);?>
	<style>
		.img {
			max-width: 250px;
			float: left;
			border: solid 1px #2a6496;
		}
		.img:hover {
			border: dashed 1px #8F5B00;
		}

		.img_overlay {
			max-width: 90%;
			text-align: center;
		}
		#placeholder {
			float: left;
			width: 555px;
		}
	</style>
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
			Ajax File Uploader
		</td>
		<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
	</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">

	<div style="margin: 20px;"> <div style="font-size: 12px;padding: 5px;">Project development is new to github. Give us a <span id="star">star</span>.</div>
		<iframe id='istar' src="https://ghbtns.com/github-btn.html?user=ajaxboy&repo=cjax&type=star&count=true" frameborder="0" scrolling="0" width="170px" height="20px"></iframe>
		<iframe src="https://ghbtns.com/github-btn.html?user=ajaxboy&repo=cjax&type=watch&count=true&v=2" frameborder="0" scrolling="0" width="170px" height="20px"></iframe>
	</div>

	<p>
		<!-- Text -->
	<p>Upload unlimited number of files, specific extensions allowed. Unique subfix/prefix to files names so that they will never overwrite other files already uploaded, customize it the way you want it.
		Works with just one line of code! everything else is optional. See Summary section for full details.</p>
	</p>

	<p>This plugin is straight forward, uploads files through ajax, with some good features. Allows for unique file names (so that
		if more than one person uploads a file with the same name, it won't conflict).

	</p>

	<p class="note">
		Brand new updates have been made in <span class="req">Cjax 5.9+</span> . This plugin now doesn't need a button to submit the files, just select the file and it
		gets uploaded.
	</p>

	<h4>Update Summary</h4>
	<p>
		Now you can not only preview the file that is uploaded, you can also view it on an overlay. Select a file, then it will preview automatically.
		Then, click the preview, and see!.
	</p>

	<p class="info">
		Envision this functionality (or a customized version of it) on your website or application?,  and can't do it yourself? Not a problem. <a href="custom_delopment.php">We'll do it for you</a>.
	</p>
	<h3>Example</h3>

	<?php
	echo $ajax->code("
	\$uploader = \$ajax->uploader(
	//settings are optional
	array(
		'suffix' => md5(time(). rand(1,10000000)), // makes files names universally unique,
		'use_debug' => '|use_debug|', //sends the value of checkbox with that id, you can also say true or false
		'ext' => array('jpg','gif', 'png','jpeg'), // extensions allowed
		'no_files' => 'Please select a file',
		'preview_container' => 'response', 		// div where the thumbnails will appear.
		'preview_dir' => 'http://cjax.sourceforge.net/uploads/', // directory url, where images are, if you want to show previews.
		'overlay' => true, // make previews clickable, to display bigger image
	)
,'../uploads/');
	", true, true);?>

		<p>
			<div style="width: 900px;">
			<div style="float: left; width: 300px;">
			<form>
			<ul class="normal">
				<li id="li_3" >
					Enable Debug: &nbsp;&nbsp; <input name="check" id="use_debug" type="checkbox" value=""/>

				</li>
				<li id="li_3" >
					<div>
						<input name="my_file[]" id="file1" class="file" type="file" maxlength="255" value=""/>
					</div>
				</li>
				<li id="li_4" >
					<label class="description" for="element_4"> </label>
	
					<div>
						<input name="my_file[]" class="file" type="file" maxlength="255" value=""/>
					</div>
				</li>
				<li id="li_4" >
					<label class="description" for="element_4"> </label>
	
					<div>
						<input name="xfile" class="file" type="file" maxlength="255" value=""/>
					</div>
				</li>
				</ul>
				</form>
			</div>
			<div style="float: left; width: 500px">
				<div id="response"></div>
			</div>
			<div style="clear: both;"></div>
			</div>
		</p>





	<h5>Basic Usage</h5>
	<?php
	echo $ajax->code("
	\$uploader = \$ajax->uploader(
	//settings are optional
		array(
		'suffix' => md5(time(). rand(1,10000000)), // makes files names universally unique,
		//sends the value of checkbox with that id, you can also say true or false
		'selector' => '.file2', // css selector to know which fields to use. Make sure you add that class to the field.
		'ext' => array('jpg','gif', 'png','jpeg'),
		//div where the thumbnails will appear.
		'preview_container' => 'response',
		'preview_dir' => 'http://cjax.sourceforge.net/uploads/',
		'overlay' => true,
		)
	,'../uploads/');
	", true, true);?>
	<p>
	<div style="width: 900px;">
		<div style="float: left; width: 300px;">
			<form>
				<ul class="normal">
					<li id="li_3" >
						<div>
							<input name="my_file[]" id="file2" class="file2" type="file" maxlength="255" value=""/>
						</div>
					</li>
					<li id="li_4" >
						<label class="description" for="element_4"> </label>

						<div>
							<input name="my_file[]" class="file2" type="file" maxlength="255" value=""/>
						</div>
					</li>
				</ul>
			</form>
		</div>
		<div style="float: left; width: 500px">
			<div id="placeholder2"></div>
		</div>
		<div style="clear: both;"></div>
	</div>
	</p>



	<h3>Examples</h3>


	<!-- Code Used -->
		<p>Features:</p>

		<ul>
			<li>Upload one file or Multitple Files at once</li>
			<li>URL triggers (before, and after files are uploaded)</li>
			<li>Auto-Upload(<span class="req">Cjax 5.9+</span>, no need to click anything to upload! </li>
			<li>Debug capabilities</li>
			<li>Prefix and Subfix- Allows to add unique variables at the beginning and end of each file uploaded.</li>
			<li>Error Handling and verbose response</li>
			<li>Smooth and silent file uploads (you don't interfere at all), while all settings are optinal.
			<li>Img preview once the files are up!</li>

		</ul>






		<h2>Plugin Usage</h2>

		<h3>Defining Settings</h3>

		<p>This plugin takes a maximum of 3 parameters, the first two are required, the third one is optional - the third parameter is an array with options
			you may specify to costimize the uploader, all options are optinal. </p>
		<br />


		<h3>URL Triggers</h3>

		<p>
			It has URL action triggers. For example, you can ask this plugin to execute an ajax call before the file(s) are uploaded.
			You can also make an ajax call after the files are uploaded, the uploading on itself is independent.
			The ajax call will contain the file names, and information about the uploads.
		</p>

		<p>
			The convenience of such triggers is so that if you happen to want to add more things during these events, you can. They are optional.
			For lack of suggestions
			we'd say you want add additional checks, file names, file types, create directories, etc, etc, you can.

		</p>

		<h2>Parameters</h2>

		<p>Uploader plugin takes the following parameters</p>


		<table cellspacing="1" cellpadding="0" border="0" class="tableborder" style="width:100%">
			<tbody><tr>
				<th>Variable</th>
				<th>Required</th>
				<th>Type</th>
				<th>Options</th>
				<th>Description</th>
			</tr>
			<tr>
				<td class="td"><strong><s>$button_id</s></strong></td>
				<td class="td">Yes</td>
				<td class="td">String</td>
				<td class="td">
					<s>May be a submit button, image or any element.</s>
						<br />
						This option has been deprecated. <span class="req">Cjax 5.9</span> doesn't require it.
				</td>
				<td class="td">
					<s>Button Id which you click on to upload the file(s). Button <span>MUST</span> be inside a form.

					</s>
					<br />
					This option has been deprecated.
				</td>
			</tr>
			<tr>
				<td class="td"><strong>$upload_directory</strong></td>
				<td class="td">Yes</td>
				<td class="td">String</td>
				<td class="td">directory/uploads/</td>
				<td class="td">The uploads directory is where the files will be uploaded, it must have the proper permissions.</td>
			</tr>
			<tr>
				<td class="td"><strong>$options</strong></td>
				<td class="td">No</td>
				<td class="td">Array</td>
				<td class="td">
					<h3>Possible Options</h3>
					<p class="note">
						All options are optional.
					</p>
					<ul>
						<li>after - [default empty] ajax controller URL -  will post files names after the files are uploaded.</li>
						<li>before - [default empty] ajax controller URL - will send an ajax request before the files are uploaded.</li>
						<li>subfix - [default empty] string/variable at the beginning of the file name.</li>
						<li>prefix - [default empty] string/variable at the end of the file name.</li>
						<li>use_debug - display debug information after files are uploaded.</li>
						<li>success_message [default empty] - message to display after files are uploaded.</li>
						<li>ext - [default empty] list of file extensions allowed.</li>
						<li>no_files - message to display if user tries to upload/submit without selecting any files</li>
						<li>
							preview_container - [default empty] div id where the thumbnails will be shown. If not specified
							the preview feature will not be shown.
						</li>
						<li>
							preview_dir - [default empty] full or relative URL where the new uploads are.
						</li>
						<li>
							preview_type - [options single/multi] [default multi] show a single thumbnail by replacing any other one previous shown, or collect all uploaded thumbnails.
						</li>
						<li>
							img_class - [default img] CSS class for the thumbnails
						</li>
						<li>
							overlay -  [true or false ] make thumbnails click-able, and display them in full overlay size.
						</li>
						<li>
							overlay_img_class  [default img_overlay] - CSS class for the overlay where the pop displays the image.
						</li>
					</ul>
				</td>
				<td class="td">You may use these options to make the uploader work for you.</td>
			</tr>
			</tbody>
		</table>


		<h4>Additional Details About $options</h4>
		<p> The "before" url serves with the purpose of confirmation, lets say that you want to perform one or more operations right after the
			uploader has uploaded the files, (enter data to database, make new settings or files, you name it) or do more $ajax functions
			all this is possible because this callback is fired right after the files are uploaded and it posts the files names of the files
			that were successfully upload (it won't post the names of the files that might have failed).
			In the same way, the "before" setting can allow you to do additional tasks before the upload is performed. For instance if you wanted
			to create a new directory for each user that uploads files, you will want to do that before the files are uploaded!. The reason for all
			these settings is to allow you to fully operate with versatility and define and create your tasks within the scope of the uploader without modifying core files but instead just defining what you need and
			using your own controllers.
		</p>


		<h2>Example Code</h2>
		<?php
		$code = $ajax->code("

\$options = array(
		'after' => 'ajax.php?upload_file/post', //submit request after files are uploaded
		'suffix' => md5(time(). rand(1,10000000)), // makes files names universally unique
		'debug' => true, //Remove if you are not debugging.
		'success_message' => 'File(s) @files successfully uploaded.',//@files tag is replaced by files uploaded.
		'ext' => array('jpg','gif', 'png','jpeg'),
		'no_files' => 'Please select a file.',
		'preview_container' => 'placeholder',   // a div where you want the previews to appear
		'preview_dir' => '../',   //enter a url, or relative dir, where they images are uploaded
		'img_class' => 'img',  //optional - css class for thumbnails of the new uploads
		'overlay' => true,  //optional - Image view when you click the thumbnails?
		'overlay_img_class' => 'img_overlay' //optional - class overlay that displays the new image
	);

//button id, upload directory
\$ajax->uploader(\$options,'your/upload/directory');


");

		echo $code;?>

		<h2>Professional Installation</h2>
		<a href='custom_delopment.php'>Professional installation</a> is  available.


	<!-- HTML -->
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