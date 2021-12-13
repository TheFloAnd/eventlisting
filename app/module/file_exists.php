<?php

namespace app\module;

class file_exists
{
    public static function index($path)
    {
        if (file_exists(__DIR__ . $path)) {

            require __DIR__ .''. $path . '.php';
            return true;
        }
        return false;
    }
}