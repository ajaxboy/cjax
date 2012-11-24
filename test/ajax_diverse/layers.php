<?php

//tell ajax where to find this sample's controller
define('AJAX_CD', 'test/ajax_diverse/controllers');

require_once '../../ajax.php';

$ajax = ajax();
	
$overlay = $ajax->overlay('form.html');

$overlay->keyup('#username', $ajax->call('../../ajax.php?form/username/|username|'));

$overlay->change('#dropdown', $ajax->call('../../ajax.php?form/dropdown/|dropdown|'));

$overlay->change('#country', $ajax->call('../../ajax.php?form/country/|country|'));

$overlay->click('#btnSubmit', $ajax->form('../../ajax.php?form/submit'));

$ajax->click('#open', $overlay);
?>
<html>
<head>
<meta charset="utf-8">
<?php echo $ajax->init();?>
</head>
<body>
<a id='open' href="#">Open Overlay</a>
</body>
</html>