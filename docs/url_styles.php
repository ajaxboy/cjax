<?php
require 'ajax.php';
?>
<head>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Ajax Framework URL Styles</h2>
<br />
You may access your controllers in any of the following ways:
<br /><br />
<?php 
echo $ajax->code("
	ajax.php?controller=\$controller&function=\$function
	ajax.php?\$controller/\$function
	ajax.php/\$controller/\$function
	
	With Mod-Rewrite:
	
	ajax/\$controller/\$function
	or:
	*Any-word*/\$controller/\$function
	*Any-word* - a word of your choosing by changing the  word 'ajax' in file .htaccess
",false);
?>
</body>