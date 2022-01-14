<?php

namespace app\controller\auth;

use database\connect;
use app\controller\config;
use app\module\notification;

class protection
{
    static function password($input)
    {
        $hash = hash('sha512', $input);

        if($hash == config::get('protection')->value){
            return true;
        }else{
            notification::error(lang['password_wrong']);
            return false;
        }
    }
    static function change($input_new, $input_repeat)
    {
        $hash_new = hash('sha512', $input_new);
        $hash_old = hash('sha512', $input_repeat);

        if($hash_new == $hash_old){
            return true;
        }else{
            notification::error(lang['password_differnet']);
            return false;
        }
    }
}
