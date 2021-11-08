<?php

namespace app\controller;

use database\connection\connect;
use \PDO;
class group{
    
    public static function index(){

        $stmt_active = "SELECT * FROM `v_teams_active` ORDER BY `name` ASC";
        $data_active = connect::connection()->query($stmt_active);
        $active = $data_active->fetchAll();

        $stmt_inactive = "SELECT * FROM `v_teams_inactive` ORDER BY `name` ASC";
        $data_inactive = connect::connection()->query($stmt_inactive);
        $inactive = $data_inactive->fetchAll();

        return compact('active', 'inactive');
    }

    public static function store($input){
        $alias = GROUP::find($input['group_alias']);
        if(!$alias){

            $stmt = "INSERT INTO `v_teams`(`name`, `alias`, `color`) VALUES ('". $input['group_name'] ."', '". $input['group_alias'] ."', '". $input['group_color'] ."')";
        
            $exec = connect::connection()->prepare($stmt);
            $exec->execute();
            return array(true, $input['group_alias']);
        }else{
            return array(false, $alias);
        }

    }

    public static function find($group){

        $stmt = "SELECT * FROM `v_teams` where alias = '". $group ."' LIMIT 1";

        $data = connect::connection()->query($stmt);
        // $result = $data->fetch();

        return $data->fetchObject();
    }
    public static function update($group){
        if(isset($group['deactivate_group'])){
            $stmt = "UPDATE `v_teams` SET `name`='". $group['group_name'] ."',`color`='". $group['group_color'] ."',`active`= 1 WHERE alias = '". $group['group_alias'] ."'";
        }else{
            $stmt = "UPDATE `v_teams` SET `active`= 0 WHERE alias = '". $group['group_alias'] ."'";
        }

        $exec = connect::connection()->prepare($stmt);
        $exec->execute();

        return array(true, $group['group_alias']);
    }
}