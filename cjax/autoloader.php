<?php

spl_autoload_register(function($class){
    if(strpos($class, "CJAX") === FALSE) return;
    $class = str_replace("\\", "/", $class);
    $class = str_replace("CJAX/", "", $class);
    require strtolower(__DIR__."/{$class}.php");
});      