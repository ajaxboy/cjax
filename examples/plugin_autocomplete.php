<?php 

require_once 'ajax.php';


$ajax->keyup('#text1', $ajax->autocomplete('ajax.php?autocomplete/update'));
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $ajax->init();?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Plugin Autocomplete - Cjax Plugin</title>
</head>
<body>
<h3>Ajax Autocomplete</h3>
Very simple, slick, and usable autocomplete. This plugin  return an array from the controller and the values will propagate.
Some caching is enabled, so if you have already typed a word and undo then retype it won't make more ajax calls.
<br /><br />
This plugin requires you to retrive the data that you want display (like from database), the data provided is 
for demonstration purposes only.
<br />
Please note that this is a stand alone plugin for Cjax, so you have to download the plugin to be able to use it.
<br />
<br /><br />
	Type Something <input type="text" id="text1" value="" /> (like a country name).
	<br /><br />
<br /><br />

Code Used:
<?php 

echo $ajax->code("
\$ajax->keyup('#text1', \$ajax->autocomplete('ajax.php?autocomplete/update'));
");
?>
</body>
</html>