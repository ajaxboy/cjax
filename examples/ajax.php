<?php
	
if(!file_exists($f = '../ajaxfw.php') && !file_exists($f = '../ajax.php')) {
	die(
	"Cjax Framework was not detected in the parent directory. Make sure the framework is placed in the upper directory.
	<br />
	You may download the framework in the official  repository:<b>Download</b>
	<a href='http://sourceforge.net/projects/cjax/'>http://sourceforge.net/projects/cjax/</a>
	");
}
define('AJAX_CD','examples/controllers');

require_once $f;

if(!$ajax->isAjaxRequest()) {
	$ajax->insert('body', 
	"<div><a href='http://cjax.sourceforge.net'><img src='http://cjax.sourceforge.net/media/logo.png' border=0/></a></div>
	<br /><br />
	");
	
	$ajax->append('body', 
	"<h3>Download</h3>
	This demo/sample is part of a collection of 30+ <a target='_blank' href='http://cjax.sourceforge.net/examples'>demos</a> acompanied in <a target='_blank' href='http://cjax.sourceforge.net/'>AjaxFw</a> You may download
	these demos <a target='_blank' href='http://sourceforge.net/projects/cjax/files/Demos/'>here</a>. See Docs <a target='_blank' href='http://cjax.sourceforge.net/docs/'>here</a>.
	<br /><br /><br />
	");
}