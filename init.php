<?php

spl_autoload_register(function ($class) {
        $file = explode( '/', str_replace('\\', '/',strtolower($class)) );
        $dir = str_replace('\\', '/',strtolower($class)) .'.' . $file[1] .'.php';
        if(file_exists($dir)){
                require  $dir;
        }
        $dir = __DIR__ . '/'. str_replace('\\', '/',strtolower($class)) .'.php';
        if(file_exists($dir)){
                require  $dir;
        }

});
