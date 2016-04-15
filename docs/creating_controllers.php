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
ajax.php?test/test. You can declare a namespace for your controller class, and in this manual we will assume it is <b>Controllers</b><br />.
<?php echo $ajax->code("
namespace Controllers;
class Test{

    public function test(){

    }

}  
");?>
If you return an array, or an object, the response will automatically be converted into json format object.
<?php echo $ajax->code("
namespace Controllers;
class Test{


    public function test(){
    
    	\$testArray = [
    		'test1' => 'test1',
    		'test2' => 'test2',
    		'test3' => 'test3'
    	];
    	
		return \$testArray;
    }

}  ");?>
Response: {"test1":"test1","test2":"test2","test3":"test3"}
</body>