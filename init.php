<?php

spl_autoload_register(function ($class) {
        $file = explode( '/', str_replace('\\', '/',strtolower($class)) );
        require  ''. str_replace('\\', '/',strtolower($class)) .'.' . $file[1] .'.php';

});
