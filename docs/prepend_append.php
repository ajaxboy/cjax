<?php
require 'ajax.php';
?>
<head>
<?php echo $ajax->init();?>
<title>Prepend /Append /Before / After</title>
</head>
<body>
<h2>Prepend /Append /Before / After</h2>
(5.0-RC2+)
<br />
<br />
You can append or prepend HTML into any div/span or other elements on the page.
<br />
<h4>Example</h4>
<?php echo $ajax->code(
"
\$ajax->prepend('#div1','Some HTML here');

\$ajax->append('#div1','Some more HTML here');
"
);?>
You can  also use before, and after, and it will have the same effect.
<h4>Example</h4>
<?php echo $ajax->code(
"
\$ajax->before('#div1','Some HTML here');

//insert html inside HTML's body before the body's content.
\$ajax->before('body','Some HTML here');

\$ajax->after('#div1','Some more HTML here');
"
);?>

You may also  append/prepend other elements on the page.
While HTML/text appends to the inner HTML/text, appending elements
will append it to upper in the hierarchy or  and prepend to the lower.
<h4>Example</h4>
<?php echo $ajax->code(
"
//insert div2 before div1
\$ajax->before('#div1','#div2');

//insert div2 after div1
\$ajax->after('#div1','#div2');
"
);?>

</body>