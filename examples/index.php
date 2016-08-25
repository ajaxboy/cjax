<?php
require 'ajax.php';


$ajax->spin('star', 'spin');


?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" type="text/css" href="resources/css/user_guide.css" media="all">
<?php echo $ajax->init(false); ?>
<title>Demos</title>
<style>

ul li  {
	font-family:sans-serif;
	font-size: 12px;
	padding: 3px;
	
}
h4 {
 display: inline;
}


</style>
</head>
<body>
<div>
<a target='_blank' href='http://cjax.sourceforge.net'>
<img src='http://cjax.sourceforge.net/media/logo.png' border=0/>
</a>
</div>
<!-- START NAVIGATION -->
<div id="nav"><div id="nav_inner"></div></div>
<div id="nav2"><a name="top">&nbsp;</a></div>
<div id="masthead">
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
<tr>
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
<a href="http://cjax.sourceforge.net/examples/">Demos</a> 
</td>
<td id="searchbox"><form method="get" action="http://www.google.com/search"><input type="hidden" name="as_sitesearch" id="as_sitesearch" value="cjax.sourceforge.net/" />Search Project User Guide&nbsp; <input type="text" class="input" style="width:200px;" name="q" id="q" size="31" maxlength="255" value="" />&nbsp;<input type="submit" class="submit" name="sa" value="Go" /></form></td>
</tr>
</table>
<!-- END BREADCRUMB -->

<br clear="all" />


<div id="content">

<h2>Cjax Framework Demos/Samples </h2>

<h4 id="demos"><a target="_blank" href="https://github.com/ajaxboy/cjax">Download</a> all 70+Demos/Samples/Docs</h4>
<br />
<div style="margin: 20px;"> <div style="font-size: 12px;padding: 5px;">Project development is new to github. Give us a <span id="star">star</span>.</div>
	<iframe id='istar' src="https://ghbtns.com/github-btn.html?user=ajaxboy&repo=cjax&type=star&count=true" frameborder="0" scrolling="0" width="170px" height="20px"></iframe>
	<iframe src="https://ghbtns.com/github-btn.html?user=ajaxboy&repo=cjax&type=watch&count=true&v=2" frameborder="0" scrolling="0" width="170px" height="20px"></iframe>
</div>
<h5>Welcome to the World of Cjax</h5>
<p>
Let Cjax bring you to a whole new level of thinking when doing application interactions.
Let yourself loose, and explore the posiblities of what you can do with Cjax. Full professional installation is available, <a href="mailto:&#099;&#106;&#120;&#120;&#105;&#050;&#049;&#064;&#103;&#109;&#097;&#105;&#108;&#046;&#099;&#111;&#109;?subject=Questions About Cjax">contact author</a> if you have any questions.
</p>
<p class="soft-note">
	This site's examples and, Cjax in general are updated on regular basis from <a  target="_blank" href="https://github.com/ajaxboy/cjax/tree/master">development branch</a>.
	You may see things here that may not be available on the latest release. You are welcome to try the "latest" stuff. Though for production
	we recommend you use a stable release.
</p>

<div>
	<div style="width: 190px;float: left">
	<h3>Demos/APIs</h3>
	<ul>
		<li>
			<a href="bind_elements.php">Bind Elements</a>
		</li>
		<li>
			<a href="bind_actions.php">Bind Actions</a>
		</li>
		<li>
			<a href="click_ajax_request.php">Click Ajax Request</a>
		</li>
		<li>
			<a href="cross_domain_ajax.php">Cross Domain Ajax</a>
		</li>	
		<li>
			<a href="confirm_action.php">Confirm Action</a>
		</li>
		<li>
			<a href="keyup_request.php">Keyup Request</a>
		</li>
		<li>
			<a href="load_html_file.php">Load External HTML</a>
		</li>
		<li>
			<a href="on_load_ajax_request.php">Onload Ajax request</a>
		</li>
		<li>
			<a href="overlay.php">Overlay</a>
		</li>
		<li>
			<a href="post.php">Post ajax</a>
		</li>
		<li>
			<a href="propagate_dropdown.php">Propagate Dropdown</a>
		</li>
		<li>
			<a href="propagate_dropdown_input.php">Propagate Dropdown input</a>
		</li>
		<li>
			<a href="recursive_ajax.php">Recursive Ajax Requests</a>
		</li>
			<li>
			<a href="search.php">Search</a>
		</li>
		<li>
			<a href="send_form.php">Submit Form</a>
		</li>
		<li>
			<a href="send_input.php">Send inputs</a>
		</li>
		<li>
			<a href="parameters.php">Passing Parameters</a>
		</li>
		<li>
			<a href="setting_values.php">Setting Values</a>
		</li>
		<li>
			<a href="display_messages.php">Display Messages</a>
		</li>
		<li>
			<a href="timeout.php">Timeouts</a>
		</li>
	</ul>
	</div>
	<div style="width: 180px;float: left">
	<h3>Samples</h3>
		<ul>
			<li>
				<a href="overlay_validation.php">Overlay + Validation</a>
			</li>
			<li>
				<a href="ajax_login.php">Ajax Login</a>
			</li>
			<li>
				<a href="check_username.php">Check Username</a>
			</li>
			<li>
				<a href="calculator.php">Calculator</a>
			</li>
		</ul>
		
		<h3>Other</h3>

		<ul>
			<li>
				<a href="callbacks.php">Ajax Callbacks</a>
			</li>
			<li>
				<a href="sizzle.php">Advanced Selectors</a>
			</li>
			<li>
				<a href="js_properties.php">JS Properties</a>
			</li>
			<li>
				<a href="main_property.php">Main Property</a>
			</li>
			<li>
				<a href="js_functions.php">Access JS Functions</a>
			</li>
			<li>
				<a href="element_properties.php">Elements Properties</a>
			</li>
			<li>
				<a href="manipulating_container.php">Manipulating Elements</a>
			</li>
			<li>
				<a href="value_modifiers.php">Value Mofidifers</a>
			</li>
			<li>
				<a href="prepend_append.php">Prepend/Append</a>
			</li>
		</ul>
		
	</div>
	
	<div style="width: 120px;float: left">
	<h3>Functions</h3>
		<ul>
			<li>
				<a href="append.php">Append</a>
			</li>
			<li>
				<a href="prepend.php">Prepend</a>
			</li>
			<li>
				<a href="insert.php">Insert</a>
			</li>
			<li>
				<a href="replace.php">Replace</a>
			</li>
			<li>
				<a href="update.php">Update</a>
			</li>
			<li>
				<a href="updateX.php">UpdateX</a>
			</li>
			<li>
				<a href="call.php">Call</a>
			</li>
			<li>
				Form
			</li>
			<li>
				<a href="flush.php">Flush</a>
			</li>
			<li>
				<a href="keypress.php">Keypress</a>
			</li>
			<li>
				<a href="click.php">Click</a>
			</li>
			<li>
				wait()
			</li>
			<li>
				<a href="location.php">Location()</a>
			</li>
			<li>
				<a href="swap.php">Swap</a>
			</li>
		</ul>
		

	</div>
	
	
	<div style="width: 210px;float: left">
	<h3>Plugins</h3>
		<ul>
			<li>
				<a href="plugin_autocomplete.php">Autocomplete</a>
			</li>
			<li>
				<a href="plugin_validate.php">Validate</a> (Jquery.validate)
			</li>
			<li>
				<a href="plugin_uploadify.php">Uploadify</a> (Jquery.uploadify)
			</li>
			<li>
				<a href="validation_uploader.php">Validation + Uploader</a>
			</li>
			<li>
				<a href="plugins.php">Creating Plugins</a>(JS+PHP)
			</li>
		</ul>

		<h3>Effects</h3>

		<ul>
			<li>
				<a href="spin.php">Spin Text</a>
			</li>
		</ul>

		<h3>Tools</h3>

		<ul>

			<li>
				<a href="plugin_uploader.php">Ajax Uploader</a>
			</li>
			<li>
				<a href="pagination.php">Pagination</a>
			</li>
		</ul>

	</div>

	<div style="float: left; width: 220px">
		<h3>Docs</h3>
		<ul>
			<li>
				<a href="docs/installing.php">Installing</a>
			</li>
			<li>
				<a href="docs/upgrading.php">Upgrading</a>
			</li>
			<li>
				<a href="docs/how_to_use.php">How To Use</a>
			</li>
			<li>
				<a href="docs/Iniciating_the_JavaScript_Engine.php">Initiating the Javascript Engine</a>
			</li>
			<li>
				<a href="docs/controllers.php">Creating Controllers</a>
			</li>
			<li>
				<a href="docs/url_styles.php">URL Styles</a>
			</li>
			<li>
				<a href="docs/triggers.php">Triggers</a>
			</li>
			<li>
				<a href="parameters.php">Passing Parameters</a>
			</li>
			<li>
				<a href="docs/access_fields_in_parameters.php">Access fields in parameters</a>
			</li>
			<li>
				<a href="docs/includes.php">Includes</a>
			</li>
			<li>
				<a href="docs/auth_and_routing.php">Custom Auth and Routes</a>
			</li>
			<li>
				<a href="docs/debugging.php">Debugging</a>
			</li>
			<li>
				<a href="docs/moving_cjax.php">Movin Cjax Dir</a>
			</li>
			<li>
				<a href="docs/configuation.php">Configuration</a>
			</li>
			<li>
				<a href="docs/api_table.php">API Table</a>
			</li>
			<li>
				<a href="docs/troubleshooting.php">Troubleshooting</a>
			</li>
		</ul>

	</div>
	
	<div style='clear:both'></div>
</div>

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