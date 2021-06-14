<?php

spl_autoload_register(function ($class) {
   require __DIR__.'../../module/' . strtolower($class) . '.module.php';
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