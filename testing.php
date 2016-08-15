<?php

#Controllers directory
define('AJAX_CD','response');

require 'ajax.php';

if($ajax->controller && $ajax->function) {

    //calling file, response/test.php:test()
    $ajax->call(array('test', 'test'));
}

?>
<!doctype html>
<head>
    <title>Test</title>
    <?php echo $ajax->init();?>
</head>
<body>

<?php if(!$_SERVER['QUERY_STRING']):?>

    <div style='margin: 50px 0 0 200px; position: relative; width: 400px;'>
        <div style='text-align: right; width:100%; position: relative'>
            <img src="examples/resources/images/cool_sunglasses.jpg" />
        </div>
        <div>
        <h3>Put your shades on, and get ready to run this test:</h3>
        <a href='?test/test'>Run Test</a>
        </div>
    </div>

<?php endif;?>


<?php if($_SERVER['QUERY_STRING']):?>
<div id="response"></div>
<?php endif;?>
</body>
</html>