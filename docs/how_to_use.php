<?php

require 'ajax.php'
?>
<head>
<?php echo $ajax->init(); ?>
<title>Ajax Framework | How to use</title>
</head>
<h2>How To Use?</h2>
To start using Cjax follow these steps: <br />
<br />
If you'd like to use Cjax only as an ajax response handler to MVC requests, you don't need to do anything,
just direct your requests to ajax.php file by following the specifications of URL <a href='url_styles.php'>here</a> and
create controllers as specified <a href='creating_controllers.php'>here</a>.
<br />
<br />
If you'd like to use the full power of Cjax including all Ajax functionality, follow these steps:<br />
<ul>
	<li>
		1. Include ajax.php.
		<br />
		Example:
		
		<?php 
			echo $ajax->code("
require_once 'ajax.php';
			");
		?>
	</li>
	<li>
	2. 
		<br />
		<br />
		You may instantiate Cjax as follows:
		<?php echo $ajax->code("
\$ajax = ajax();
		", false);?>
		Once you have access to the $ajax object, simply in the HEAD of the HTML page do:
		<?php echo $ajax->code("
<head>
<?php echo \$ajax->init(); ?>
</head>  
		", false);?>
		If you run into issues on this step review the specifications <a href='Iniciating_the_JavaScript_Engine.php'>here</a>:
	<br /><br />
	</li>
	<li> You are set - <br />
	 That is all you need, to fully initiate Cjax. Now you may review the <a href='api_table.php'>APIs</a> that you can start using ASAP.
	<br />
	View/test and <a href='http://cjax.sourceforge.net/examples'>Download the demos</a> to review code samples. Then 
	read the rest of the <a href='./'>docs</a>.
	<br />
	That should get you started.
	<br />
	<br />
	</li>
</ul>