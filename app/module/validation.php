<?php

namespace app\module;

class notification
{
    public static function length($msg, $length)
    {
        if (strlen($msg) >= $length) {
            return true;
        }
    }

    public static function datetime($msg)
    {
        if ($msg instanceof \DateTime) {
            return true;
        }
    }
}
