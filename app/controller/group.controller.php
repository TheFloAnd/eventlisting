<?php

namespace app\controller;

use app\module\DB;
use \PDO;
class group{
    
    public static function index(){

        $stmt = "SELECT * FROM `teams` ORDER BY name ASC";

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

            $stmt = "INSERT INTO `teams`(`name`, `alias`) VALUES ('". $input['group_name'] ."', '". $input['group_alias'] ."')";
        
            $exec = DB::connection()->prepare($stmt);
            $exec->execute();
            return array(true, $input['group_alias']);
        }else{
            return array(false, $alias);
        }

    }
}