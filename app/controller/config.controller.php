<?php

namespace app\controller;

use app\module\DB;
use \PDO;
class config{

    public static function index(){
        $stmt = "SELECT * FROM `config`";
        $data = DB::connection()->query($stmt);
        // $result = $data->fetchAll();
        return $data->fetchAll();
    }
    public static function find($id){
        $stmt = "SELECT * FROM `config` where id = '". $id ."' LIMIT 1";
        $data = DB::connection()->query($stmt);
        // $result = $data->fetch();
        return $data->fetchObject();
    }
    public static function get($setting){
        $stmt = "SELECT `value`, `time_value` FROM `config` where `setting` = '". $setting ."'";
        $data = DB::connection()->query($stmt);
        return $data->fetchObject();
    }
                
    public static function update($setting){
        if($setting['setting_id'] == '2'){
            $stmt = "UPDATE `config` SET `value` = '". $setting['setting_value'] ."', `time_value` = '". $setting['time_value'] ."' where `id` = '". $setting['setting_id'] ."'";
        }else{
            $stmt = "UPDATE `config` SET `value` = '". $setting['setting_value'] ."' where `id` = '". $setting['setting_id'] ."'";
        }
        $exec = DB::connection()->prepare($stmt);
        $exec->execute();
        return true;
    }
}