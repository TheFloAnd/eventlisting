<?php

namespace app\model;

use database\connect;
use \PDO;
class config{

    public static function index(){
        $stmt = "SELECT * FROM `config`";
        $data = connect::connection()->query($stmt);
        // $result = $data->fetchAll();
        return $data->fetchAll();
    }
    public static function find($id){
        $stmt = "SELECT * FROM `config` where id = '". $id ."' LIMIT 1";
        $data = connect::connection()->query($stmt);
        // $result = $data->fetch();
        return $data->fetchObject();
    }
    public static function get($setting){
        $result = new config;
        $stmt = "SELECT `value` FROM `config` where `setting` = '". $setting ."'";
        $data = connect::connection()->query($stmt);
        $result->return = $data->fetchColumn();
        return $result;
    }
                
    public static function update($setting){

        $stmt = "UPDATE `config` SET `value` = '". $setting['setting_value'] ."' where `id` = '". $setting['setting_id'] ."'";
        $exec = connect::connection()->prepare($stmt);
        $exec->execute();
        return true;
    }
}