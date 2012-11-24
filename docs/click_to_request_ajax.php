<?php

require 'ajax.php';
?>
<head>
<?php echo $ajax->init();?>
<title>Click to request ajax</title>
</head>
<body>
<h2>Click to request ajax</h2>

As simple as: <br />
<br />
Where "your_anchor_id_here" you may place the id of a button, an anchor, a span, or an image etc. When that elemen is clicked
it will trigger the request.
<?php 

echo $ajax->code("
\$ajax->Exec('your_anchor_id_here' , \$ajax->call(\"url/goes/here\"));
");
?>
</body>