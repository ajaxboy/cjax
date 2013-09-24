<?php

require 'ajax.php';
?>
<head>
<?php echo $ajax->init();?>
<title>Click to Submit Ajax Form</title>
</head>
<body>
<h2>Click to Submit Ajax Form</h2>
(Cjax 5.0RC1+)
<br />
<br />
Where "form_button_id" is, enter the id of your submit button. Your button may be an anchor, an image, or a submit button.
Also for this to work properly, the button has  to be inside an HTML form which you desire to submit with ajax.
<?php 

echo $ajax->code("
\$ajax->form_button_id = \$ajax->form(\"url/goes/here\"));
");
?>
</body>