<?php

$ajax = ajax();

if($ajax->controller && $ajax->function) {

    //calling file, response/test.php:test()
    $ajax->call(array('test', 'test2handler'));
}

?>
<!doctype html>
<head>
    <title>Test</title>
    <?php echo $ajax->init();?>
</head>
<body>
<div id="response"></div>
<div id="response2"></div>
</body>
</html>