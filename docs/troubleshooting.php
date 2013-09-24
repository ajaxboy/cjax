<?php

require_once 'ajax.php';
?>
<html>
<head>
<?php echo $ajax->init(); ?>
<title>Ajax Framework | Troubleshooting</title>
</head>
<body>
<h2>Troubleshooting</h2>(5.0-RC2)
<br /><br />
There is an options that allows you to switch how the data is tranfered across over to JavaScript. If you are  experiencing
issues with commands not taking effect (while on page load) or with PHP SESSIONS, then you might want to use this :

<?php echo $ajax->code("\$ajax->fallback = true;");?>
This will print a script tag on the page instead of using  PHP SESSIONS to pass data.
<br /><br />
This is only available as of 5.0 RC2+. You may also find file cjax/config.default.php, rename this file to config.php.
<br /> then find the option $config->fallback, and change it to true, this will apply the change globally.
</body>
</html>