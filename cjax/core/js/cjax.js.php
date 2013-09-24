<?php
header('Content-type: application/x-javascript');
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
header("Cache-Control: no-cache");
header("Pragma: no-cache");

define('AJAX_VIEW', true);
require '../../cjax.php';

$ajax = ajax();

function tryAgain()
{
	usleep(1000);
	$ajax = ajax();
	$_cache = $ajax->get('cjax_x_cache');
	echo "//trying\n";
	return $_cache;
}
if(isset($_REQUEST['json'])) {
	echo 'init();';
} else {
	if($ajax->config->caching && isset($_REQUEST['crc32'])) {
		$source = $ajax->tapCache($_REQUEST['crc32']);
	} else {
		$debug = $ajax->get('cjax_debug')? 1:0;
		$preload = $ajax->get('cjax_preload');
		$_cache = $ajax->get('cjax_x_cache');
		
		if(!$_cache) {
			$_cache = tryAgain();
			if(!$_cache) {
				$_cache = tryAgain();
				if(!$_cache) {
					$_cache = tryAgain();
					if(!$_cache) {
						exit();
					}
				}
			}
		}
			
		$source = 'CJAX.process_all("'.$_cache.'","'.$preload.'", '.$debug.', true);';
	}
	
	
	if(!$source) {
		echo "//no source available";
	} else {
		print $source;
	}
}
$ajax->flushCache();