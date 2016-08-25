<?php
header('Content-type: application/x-javascript');
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
header("Pragma: no-cache");

define('AJAX_VIEW', true);
require '../preemptive.php';

$ajax = ajax();

function tryAgain()
{
	usleep(1000);
	$ajax = ajax();
	$_cache = $ajax->get('cjax_x_cache');
	echo "//trying\n";
	if(!$_cache) {
		return;
	}
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
		$cache = $ajax->get('cjax_x_cache');

		if(!$cache) {
			$cache = tryAgain();
			if(!$cache) {
				$cache = tryAgain();
				if(!$cache) {
					$cache = tryAgain();
					if(!$cache) {
						exit();
					}
				}
			}
		}

		if($preload) {
			$preload = CoreEvents::processScache($preload);
			$preload = CoreEvents::mkArray($preload);
		}

		if($cache) {
			$cache = CoreEvents::processScache($cache);
			$cache = CoreEvents::mkArray($cache);
		}
			
		$source = 'CJAX.process_all("'.$cache.'","'.$preload.'", '.$debug.', true);';
	}
	
	
	if(!$source) {
		echo "//no source available";
	} else {
		$ajax->flushCache(true);
		print $source;
	}
}
