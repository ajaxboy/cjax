<?php 

require_once  'ajax.php';

//$ajax->blur("url", $ajax->call("ajax.php?test/remote/|url:encodeURIComponent|"));

$ajax->keypress('url', $ajax->call("ajax.php?test/remote/|url:encodeURIComponent|"), 13);


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Test...</title>
	<?php echo $ajax->init();?>
</head>
<body>
<input type='text'  id="url" value="" />
</body>
</html>