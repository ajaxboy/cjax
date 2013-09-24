<?php
require_once 'ajax.php';

?>
<html>
<head>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Includes</h2>
Some times you may need to include files or dependencies while making ajax request. The includes sections
provides you with a section where you may include any files or load extra dependecies without modifying core files.
<br />
To start including files use file: cjax/includes.default.php. For changes to take effect you must rename file includes.default.php
to includes.php.
<br />
Includes are loaded right before the request is triggered and before authentication, and routing.
<br />
</body>
</html>