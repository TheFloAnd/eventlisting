<?php

namespace app\controller;

use app\module\DB;

class group{
    
    public static function index(){

        $stmt = "SELECT * FROM `teams`";

        $data = DB::connection()->query($stmt);
        $result = $data->fetchAll();

        return $result;
    }

    public static function store($input){
        $stmt = "INSERT INTO `teams`(`name`, `alias`) VALUES ('". $input['group_name'] ."', '". $input['group_alias'] ."')";
        
        $exec = DB::connection()->prepare($stmt);
        $exec->execute();

    }
}