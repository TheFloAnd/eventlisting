<?php
namespace app\module;
class system{

    static function get_updates(){
        exec("sudo apt update && sudo apt upgrade -y");
        return;
    }
}