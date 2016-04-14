<?php

require 'ajax.php';

use CJAX\Core\CJAX;
$ajax = CJAX::getInstance();
?>
<head>
<?php echo $ajax->init();?>
<title>Ajax Framework - Creating Controllers</title>
</head>
<body>
<h3>Creating Controllers</h3>
To be able to handle request, you need a controller. Controllers in the Ajax Framework work similar way as 
how they work in other known PHP Frameworks.
<br /><br />

Create a file test.php inside controllers directory, and add method/function <b>test</b>. This would work for url:
ajax.php?test/test. You may also start the class name with an undercore "_", if you experience conflicts with class names.
<?php echo $ajax->code("
class test{


    public function test(){

    }

}  
");?>
If you return an array, or an object, the response will automatically be converted into json format object.
<?php echo $ajax->code("
class test{


    public function test(){
    
    	\$test_array = [
    		'test1' => 'test1',
    		'test2' => 'test2',
    		'test3 => 'test3'
    	];
    	
		return \$test_array;
    }

}  
");?>
Response: {"test1":"test1","test2":"test2","test3":"test3"}
</body>
