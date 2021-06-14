<?php

spl_autoload_register(function ($class) {
    $module = __DIR__.'module/' . strtolower($class) . '.module.php';
    if(file_exists($module)){
        require $module;
    }

    $controller = __DIR__.'controller/' . strtolower($class) . '.controller.php';
    if(file_exists($controller)){
        require $conroller;
    }
});

/*
$filepath = dirname(__FILE__).'/app/module/';
$files = scandir($filepath);
foreach ($files as $file) {
    // match the file extension to .php
    if (substr($file,-4,4) == '.php'){
        include($filepath.$file);
    }
}
*/