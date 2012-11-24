<?php

require_once 'ajax.php';
?>

<h2 id="install">Install/Download</h2>
		<br>
		Here are the steps to get the framework installed on your site, or test installation:<br>
		<ul>
			<li>
				1. <a target="_blank" href="http://sourceforge.net/projects/cjax/files/CJAXFW_5.0-Beta3.zip/download">Download</a> the latest stable release
				<br />
			</li>
			<li>
				2. Place the contents of the zip on the root of the site merging it with your current site.
				<br>
					So you'd end up with your current structure plus:
				<ol>
		<div style="margin-left: 15px;">
		<pre>		 /
		 cjax/
		 controllers/
		 ajax.php
		 testing.php
		</pre>
		</div>
				</ol>
			</li>
			<li>
				You are set. Now lets test...
			</li>
		</ul>
		<h4>Testing your Cjax Installation</h4>
		For security reasons you cannot access ajax.php directly on your browser, so we'll use testing.php to use. <br>
		Go onto your browser and type in the url for your site, plus testing.php?test/test, eg:  http://yoursite.com/testing.php?test/test
		<br>
		If you see the text "Ajax View..." on your browser, that means you have successfully installed and tested the ajax framework.
		<br>
		You may find the text in file controllers/test.php in function test(). If your installation was successful you may delete file testing.php.
		