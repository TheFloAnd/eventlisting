<?php
namespace app\module;
class updates{
    private static function is_connected(){
        $connected = @fsockopen("www.github.com", 80); 
                                            //website, port  (try 80 or 443)
        if ($connected){
            $is_conn = true; //action when connected
            fclose($connected);
        }else{
            $is_conn = false; //action in connection failure
        }
        return $is_conn;

    }

    static function get_updates(){
        if(updates::is_connected()){
            $path = __DIR__ . '/../../';
            exec("cd ". $path);
            exec("git pull https://github.com/TheFloAnd/eventlisting.git production");
        }
        return;
    }
}