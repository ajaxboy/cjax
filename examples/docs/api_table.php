<?php
//core file, reference..
require_once "../../ajax.php";

$ajax = ajax();


?>
<!doctype html>
<head>
	<link rel="stylesheet" type="text/css" href="../resources/css/user_guide.css" media="all">
	<?php if(!isset($css)):?>
		<link rel="stylesheet" type="text/css" href="resources/css/table.css" media="all">
	<?php endif;?>
	<title>Ajax Framework API Table</title>
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
			<a href="../">Demos</a> &nbsp;&#8250;&nbsp;
			API Table
		</td>
		<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
	</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />

<div id="content">


	<!-- Text -->
	<h2 id='api'>Ajax Framework API Table</h2>

	<table class='table'>
		<thead>
		<tr>
			<th>API</th>
			<th>Params</th>
			<th>Description</th>
		</tr>
		</thead>
		<tr>
			<td width="150">
				$ajax->call()
			</td>
			<td width="350">
				$url - required string
				<br />
				$cointainer_id - optional string
				<br />
				$confirm - optional string
			</td>
			<td width="350">
				Allows you to perform ajax requests.
				If $container_id is specified, the response of the request
				will be sent in the container.
				If $confirm is specified, a prompt for confirmation in form of question is displayed before the request is performed.
			</td>
		</tr>
		<tr>
			<td>
				$ajax->form()
			</td>
			<td>
				$url - required string
				<br />
				$form_id - required string
				<br />
				$confirm - optional string
			</td>
			<td>
				Allows you turn a form into an AJAX-form.
				If $confirm is specified, a prompt for confirmation is displayed before the form is submited.
			</td>
		</tr>

		<tr>
			<td>
				$ajax->overlay()
			</td>
			<td>
				$url - required string
				<br />
				$use_cache - optional boolean
				<br />
				$options - optional array
				<br />
				<div style="margin-left: 15px">
					<i>top</i> - position from top of the page
					<br />
					<i>left</i> - position from left
					<br />
					<i>transparent</i> - from 1 to 100 level of background transparency.
					<br />
					<i>color</i> - color of the background
				</div>
			</td>
			<td>
				Displays a lightbox overlay on the screen by supplied content request from a url.
				If $use_cache is specified, it will only request url content once and place it in cache.
			</td>
		</tr>

		<tr>
			<td>
				$ajax->dialog()
			</td>
			<td>
				$content - required string
				<br />
				$title - optional string
				<br />
				$options - optional array
				<br />
				<div style="margin-left: 15px">
					<i>top</i> - position from top of the page
					<br />
					<i>left</i> - position from left
					<br />
					<i>transparent</i> - from 1 to 100 level of background transparency.
					<br />
					<i>color</i> - color of the background
				</div>
			</td>
			<td>
				Uses overLayContent to display a dialog formatted screen.
			</td>
		</tr>



		<tr>
			<td>
				$ajax->overlayContent()
			</td>
			<td>
				$content - required string
				<br />
				$options - optional array
				<br />
				<div style="margin-left: 15px">
					<i>top</i> - position from top of the page
					<br />
					<i>left</i> - position from left
					<br />
					<i>transparent</i> - from 1 to 100 level of background transparency.
					<br />
					<i>color</i> - color of the background
				</div>
			</td>
			<td>
				Displays supplied content in a lightbox overlay.
			</td>
		</tr>


		<tr>
			<td>
				<s>$ajax->upload()</s>
			</td>
			<td>
				$btn_id - required string
				<br />
				$target_directory - require string
				<br />
				$options - optional array
				<br />
				<div style="margin-left: 15px">
					<i><b>url</b> [string]</i> - post form to a controller or url.
					<br />
					<i><b>ext</b> [array]</i> - extensions allowed eg: array('gif','png','pdf')
					<br />
					<i><b>form_id</b> [string]</i> - you can specify the form id, will try  detect it otherwise.
					<br />
					<i><b>text</b> [string]</i> - the "Uploading File(s)" indicator, you may costimize the text here.
					<br />
					<i><b>prefix</b> [string]</i> -  a prefix can create unique names for uploads avoiding<br />
					them being overwritten, prefix goes at the start of the file name.
					<br />
					<i><b>sufix</b> [string]</i> -  a sufix can create unique names for uploads avoiding <br />
					them being overwritten, subfix goes at the end of the file name.
					<br />
					<i><b>files_require</b> [boolean default true]</i> - if no files are selected, <br />
					shows a message "No files were selected".

				</div>
			</td>
			<td>
				<b>Note:</b> This API is not longer supported, and has been moved into an stand alone plugin.
				See: http://cjax.sourceforge.net/examples/plugin_upload_files.php
				<br /><br  />
				[Cjax 5.0+]<br />
				<b>Upload all files in a form using  Ajax</b> <br />
				$btn_id - button id is required to obtain parent form. You may upload one or as many files as you need.
				<br />
				<b>$target_directory</b> - where files will be uploaded to.
				<br />
				<b>$options</b> array - <b>All options are optional.</b>
				<br />
				<b>url</b> In addition to uploading the files, you may still post the form to a controller, <br />
				the form will be posted after  the files are uploaded.
				<br />
				<b>prefix</b> Can allow unique names. using: 'time' keyword adds a timestamp, using 'rand' <br />
				keyword adds a random number. If you  use the <b>url</b> option, the converted names will be <br />
				returned as POST variables - $_POST['files'] to the form, and  be posted to the url if provided.
				<br />
				<b>sufix</b> Can allow unique names, similar to prefix, but applied to the end of the file name.
				<br />
				<b>files_require</b> -(if false) hides error message "No files were selected".

			</td>
		</tr>


		<tr>
			<td>
				$ajax->Exec()
			</td>
			<td>
				$element_id - required mixed[string,array]
				<br />
				$actions - require mixed API
				<br />
				$event - optional string [default click]
				<br />
				<div style="margin-left: 15px">
					<i>click</i>
					<br />
					<i>keyup</i>
					<br />
					<i>keydown</i>
					<br />
					<i>blur</i>
				</div>
			</td>
			<td>
				Bind APIs to elements.
				$element_id - you may pass more than one element by spliting the id with a vertical bar "|",
				you may also supply  an array.
				$actions - any API on this table such as $ajax->call() can be binded to an element. You may also supply
				mutlple APIs in an array.
			</td>
		</tr>

		<tr>
			<td>
				$ajax->message()
			</td>
			<td>
				$message - required string
				<br />
				$seconds - optional integer [default 3]
			</td>
			<td>
				Displays supplied text/content on the screen in form of message.
				if $seconds is provided, that is how long the message will last on the screen
				before it disappears, 0 would remove time limit.
			</td>
		</tr>

		<tr>
			<td>
				$ajax->success()
			</td>
			<td>
				$message - required string
				<br />
				$seconds - optional integer [default 3]
			</td>
			<td>
				Makes use of $ajax->message() to display a success formatted message.
			</td>
		</tr>
		<tr>
			<td>
				$ajax->warning()
			</td>
			<td>
				$message - required string
				<br />
				$seconds - optional integer [default 3]
			</td>
			<td>
				Makes use of $ajax->message() to display a warning formatted message.
			</td>
		</tr>
		<tr>
			<td>
				$ajax->info()
			</td>
			<td>
				$message - required string
				<br />
				$seconds - optional integer [default 3]
			</td>
			<td>
				Makes use of $ajax->message() to display a info formatted message.
			</td>
		</tr>
		<tr>
			<td>
				$ajax->error()
			</td>
			<td>
				$message - required string
				<br />
				$seconds - optional integer [default 3]
			</td>
			<td>
				Makes use of $ajax->message() to display a error formatted message.
			</td>
		</tr>

		<tr>
			<td>
				$ajax->update()
			</td>
			<td>
				$element_id - required string
				<br />
				$data - optional string
			</td>
			<td>
				Update element with HTML. You may also use update() to update element values.
			</td>
		</tr>

		<tr>
			<td>
				$ajax->wait()
			</td>
			<td>
				$seconds - required integer
			</td>
			<td>
				Sets a timeout to the next API used.
			</td>
		</tr>
		<tr>
			<td>
				$ajax->location()
			</td>
			<td>
				$url - required string
			</td>
			<td>
				Redirect page
			</td>
		</tr>


		<tr>
			<td>
				$ajax->alert()
			</td>
			<td>
				$message - required string
			</td>
			<td>
				Display alert
			</td>
		</tr>

		<tr>
			<td>
				$ajax->focus()
			</td>
			<td>
				$element_id - required string
			</td>
			<td>
				Set focus to input or element
			</td>
		</tr>

		<tr>
			<td>
				$ajax->remove()
			</td>
			<td>
				$element_id - required string
			</td>
			<td>
				Remove an  element from the page
			</td>
		</tr>

		<tr>
			<td>
				$ajax->debug
			</td>
			<td>
				boolean  variable - true or false [default false]
			</td>
			<td>
				Debug console mode compatible with firebug.
			</td>
		</tr>

		<tr>
			<td>
				$ajax->log
			</td>
			<td>
				boolean  variable - true or false [default false]
			</td>
			<td>
				Debug PHP output before is processed (stops the application).
			</td>
		</tr>


		<tr>
			<td width="150">
				AJAX_CD
			</td>
			<td width="350">
				AJAX_CD - String Constant [default 'controllers']
			</td>
			<td width="350">
				Define where the controllers directory is. By default the controllers directory is "controllers", and you don't need to worry about defining it.
				However if you happen to use  a different controllers directory, you may defined it with AJAX_CD, and will seek for controllers  there.
				If you do define it, make you sure you do it before you include file ajax.php.
			</td>
		</tr>

		<tr>
			<td width="150">
				AJAX_VIEW
			</td>
			<td width="350">
				AJAX_VIEW - Boolean Constant [default false]
			</td>
			<td width="350">
				If you wish to view the response on the browser, by default the framework will not allow you for security reasons, you may bypass that
				by defining AJAX_VIEW.
			</td>
		</tr>

	</table>


	<br />

	<h3>Examples</h3>


	<!-- Code Used -->


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