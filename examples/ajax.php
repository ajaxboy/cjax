<?php

if(!file_exists($f = '../ajax.php')):
	include 'resources/html/not_found.html';
	exit(0);
endif;

define('AJAX_CD','examples/controllers');

chdir(dirname(__FILE__));

require_once $f;