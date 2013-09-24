<?php
require_once 'ajax.php';
?>
<html>
<head>
<?php echo $ajax->init(); ?>
<title>Ajax Framework | Passing Parameters</title>
</head>
<body>
<h2>Passing Parameters</h2>
<ul>
<li>
<h4>Followed order</h4>
Cjax uses URL query string to pass parameters into the controller by using function parameters. <br />
There is more than one way to pass parameters, depending on the way you are using the URL.<br />
You can pass "followed order" or "alphabetic letters order" onto your methods/functions inside the controllers. <br />
<?php echo $ajax->code("
//controller/function/arg1/arg2
ajax.php?test/test/123/someID
// this also applies to mod_rewrite urls such as: ajax/test/test/arg1/someID 
");?>

The above URL passes two parameters 123 and someID, test/test indicates the controller and the method.  
Anything after the method will translate into paratemeters. You may pass up to 26 parameteres respectively symbolizing the English Alphabeth.
<?php echo $ajax->code("
class test  {

    function test(\$arg1, \$arg2)
    {
        echo \$arg1;
        echo '<br />';
        echo \$arg2;
    }
    //prints  123
    //        someID
}
");?>
Parameters are passed into method/function arguments, and you may access them directly inside your controller.
</li>
<li>
<h4>Alphabetic letter order</h4>
<br />
A less Organized way to pass parameters that may accept any order within the URL: 
<?php echo $ajax->code("
ajax.php?controller=test&function=test&a=Hello&c=Hello World&b=World
");?>
The above URL uses alphabetic letters to pass parameters, and has the same effect as if you used "followed order",
but gives you the flexiblity to pass any order and additional parameters with different names that can be accessible
through $_GET or $_REQUEST.
<?php echo $ajax->code("
class test  {

    function test(\$a, \$b, \$c)
    {
        echo \$a;
        echo '<br />';
        echo \$b;
        echo '<br />';
        echo \$c;
    }
    //prints  Hello
    //        World
    //        Hello World
}  
");?>
</li>
</ul>
<h4>Passing Element Values in the URL</h4>
Sometimes you might need to pass element values such as these of inputs. To accomplish this, in the url pass the element_id
wrapped with vertical bars.
<br />
Example:
<?php echo $ajax->code("
ajax.php?controller/function/arg1/arg2/|text1|/|checkbox1|
",false);?>
The above URL will automatically seek for these elements on the HTML document and pass their value in the URL.
</body>
</html>