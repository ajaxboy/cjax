<?php if(!file_exists($f = '../ajax.php')):?>

	"Cjax Framework was not detected in the parent directory. Make sure the framework is placed in the upper directory.
	<br />
	You may download the framework in the official  repository:<b>Download</b>
	<a href='http://sourceforge.net/projects/cjax/'>http://sourceforge.net/projects/cjax/</a>

<?php exit(0);?>
<? endif; ?>
define('AJAX_CD','examples/controllers');

chdir(dirname(__FILE__));

require_once $f;