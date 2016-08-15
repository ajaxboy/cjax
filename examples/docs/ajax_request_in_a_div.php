<?php

require 'ajax.php';
?>
<head>
<?php echo $ajax->init();?>
<title>Ajax Framework | Ajax Request in a DIV </title>
</head>
<body>
<h2>Ajax Request in a DIV in 5.0-RC1+</h2>

As simple as: <br />
<br />
<?php 

echo $ajax->code("
\$ajax->your_div_id_here = \$ajax->call(\"url/goes/here\");
");
?>
</body>