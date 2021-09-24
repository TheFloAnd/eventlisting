<?php

namespace app\controller;

use app\module\DB;
use \PDO;
class group{
    
    public static function index($table){

        $stmt = "SELECT * FROM `". $table ."` ORDER BY `name` ASC";

        $data = DB::connection()->query($stmt);
        $result = $data->fetchAll();

        return $result;
    }

    public static function store($input){
        $stmt_exists = "SELECT alias FROM `v_teams` where alias = '". $input['group_alias'] ."' LIMIT 1";
        $exists = DB::connection()->prepare($stmt_exists);
        $exists->execute();
        $alias = $exists->fetchColumn();
        if(!$alias){

            $stmt = "INSERT INTO `v_teams`(`name`, `alias`, `color`) VALUES ('". $input['group_name'] ."', '". $input['group_alias'] ."', '". $input['group_color'] ."')";
        
            $exec = DB::connection()->prepare($stmt);
            $exec->execute();
            return array(true, $input['group_alias']);
        }else{
            return array(false, $alias);
        }

    }

    public static function find($group){

        $stmt = "SELECT * FROM `v_teams` where alias = '". $group ."' LIMIT 1";

        $data = DB::connection()->query($stmt);
        // $result = $data->fetch();

        return $data->fetchObject();
    }
    public static function update($group){
        if(isset($group['deactivate_group'])){
            $stmt = "UPDATE `v_teams` SET `name`='". $group['group_name'] ."',`color`='". $group['group_color'] ."',`active`= 1 WHERE alias = '". $group['group_alias'] ."'";
        }else{
            $stmt = "UPDATE `v_teams` SET `active`= 0 WHERE alias = '". $group['group_alias'] ."'";
        }

        $exec = DB::connection()->prepare($stmt);
        $exec->execute();

        return array(true, $group['group_alias']);
    }
}