<?php

namespace app\controller;

use app\module\DB;
use \PDO;
class group{
    
    public static function index(){

        $stmt = "SELECT * FROM `teams` where active = 1 ORDER BY name ASC";

        $data = DB::connection()->query($stmt);
        $result = $data->fetchAll();

        return $result;
    }

    public static function store($input){
        $stmt_exists = "SELECT alias FROM `teams` where alias = '". $input['group_alias'] ."' LIMIT 1";
        $exists = DB::connection()->prepare($stmt_exists);
        $exists->execute();
        $alias = $exists->fetchColumn();
        if(!$alias){

            $stmt = "INSERT INTO `teams`(`name`, `alias`, `color`) VALUES ('". $input['group_name'] ."', '". $input['group_alias'] ."', '". $input['group_color'] ."')";
        
            $exec = DB::connection()->prepare($stmt);
            $exec->execute();
            return array(true, $input['group_alias']);
        }else{
            return array(false, $alias);
        }

    }
    public static function show(){

        $stmt = "SELECT * FROM `teams` ORDER BY name ASC";

        $data = DB::connection()->query($stmt);
        $result = $data->fetchAll();

        return $result;
    }

    public static function find($group){

        $stmt = "SELECT * FROM `teams` where alias = '". $group ."' LIMIT 1";

        $data = DB::connection()->query($stmt);
        $result = $data->fetch();

        return $result;
    }
    public static function update($group){
        if(!empty($group['deactivate_group'])){
            $active = 1;
        }else{
            $active = 0;
        }
        $stmt = "UPDATE `teams` SET `name`='". $group['group_name'] ."',`color`='". $group['group_color'] ."',`active`='". $active ."' WHERE alias = '". $group['group_alias'] ."'";

        $exec = DB::connection()->prepare($stmt);
        $exec->execute();

        return array(true, $group['group_alias']);
    }
}