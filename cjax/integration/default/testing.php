<?php

$ajax = ajax();

?>
<!doctype html>
<head>
    <title>Test</title>
    <?php echo $ajax->init(false);?>
</head>
<body>

<?php if(isset($step1)):?>

    <div style='margin: 50px 0 0 200px; position: relative; width: 400px;'>
        <div style='text-align: right; width:100%; position: relative'>
            <img src="examples/resources/images/cool_sunglasses.jpg" />
        </div>
        <div>
        <h3>Put your shades on, and get ready to run this test:</h3>
        <a href='?test/test2'>Run Test</a>
        </div>
    </div>

<?php endif;?>


<?php if(isset($step2)):?>
<div id="response"></div>
<div id="response2"></div>
<?php endif;?>
</body>
</html>