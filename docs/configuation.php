<?php
require_once 'ajax.php';
?>
<html>
<head>
<?php echo $ajax->init();?>
<title>Ajax Framework | Configuration</title>
</head>
<body>
<h2>Configuration</h2>
<br />
Since 5.0-RC2 the ajax framework includes optional settings to better optimize your preferences and settings.
Some settings are only available until 5.0-RC3.
<br /><br />
To make use of the ajax framework settings see file: <b>cjax/config.default.php</b>. For settings to take effect you must
rename file config.default.php to <b>config.php</b>.
<br />
<br />
Settings are specially useful if you have more than one installation and you share changes among installations as well 
for plugins. Plugins may instruct custom settings which are easily accesible through the $ajax object.
<br /><br />
<h3>Settings Avaliable</h3>
	<ul>
	<li>
	$config->fallback - true or false
	<br />
	<br />

Having issues on page load not loading some times?
 Cjax uses PHP sessions to pass data across, some times sessions fail or some setting on the server's cache
 may cause unexpented behavior, and could cause cjax not to able to pass the data - in that  case 
 this option allows cjax to fallback on a small footprint on the page to be able to pass the pending data.
<br /><br />
	</li>
	<li>
	$config->caching - true or false
	<br /><br />
	Uses server default temporary folder to write "onLoad" events (not ajax requests). 
	<br /><br />
	</li>
	<li>
	$config->ajax_view - true or false
	<br /><br />
	Allows direct access to ajax.php.
	<br /><br />
	</li>
	<li>
	$config->debug - true or false
	<br /><br />
	Config displays javaScript debug information in firebug console.
	<br /><br />
	</li>
	<li>
	$config->ip_debug
	<br /><br />
Allows $config->debug to selective ips addresses. You may enter an id or an array with multiple ips.
	<br /><br />
	</li>
	<li>
	$config->init_url
	<br /><br />

 Init URL
 <br />
 <br />
 Generally you won't need to touch this. If you experience problems where the script path is not being 
 set correctly, or you are using very fancy URLs where the paths can be confusing, then you might find
 this helpful. This will help the framework find the correct path to the js file in a case where it cannot 
 be found.
 <br />
 Eg: http://your/site/url (where ajax.php is located).
	<br /><br />
	</li>
		<li>
	$config->camelize - true or false
 <br />
 <br />
	Submits your controllers class names to use camelized style. Eg:  likeThis instead of like_this.
	<br /><br />
	</li>
	</li>
		<li>
	$config->camelizeUcfirst - true or false
 <br />
 <br />
	If setting $config->camelize is on, you may specify the first letter to be capital letter or lower case. True indicates
	capital letter.
	<br /><br />
	</li>	
</ul>

</body>
</html>