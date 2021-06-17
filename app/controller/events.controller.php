<?php

namespace app\controller;
require './app/module/db.module.php';

use app\module\DB;

class events{
    
    public static function index(){

        $stmt = "SELECT * FROM `events` where start <= '". date("Y-m-d") ."' AND end >= '".date("Y-m-d")."' ORDER BY start ASC";

        $data = DB::connection()->query($stmt);
        $result = $data->fetchAll();

        return $result;
    }

    public static function future(){

        $stmt = "SELECT * FROM `events` where start <= '". date('Y-m-d', strtotime(date("Y-m-d") . ' + 7 Day')) ."' AND start >= '". date('Y-m-d', strtotime(date("Y-m-d") . ' +1 Days')) ."' ORDER BY start ASC";


        $data = DB::connection()->query($stmt);
        $result = $data->fetchAll();

        return $result;
    }

    public static function proposals(){

        $stmt = "SELECT `event`, COUNT(`event`) as counted FROM `events` GROUP BY `event` ORDER BY counted DESC";


        $data = DB::connection()->query($stmt);
        $result = $data->fetchAll();

        return $result;
    }

    public static function store($input){
        $stmt = "INSERT INTO `events`(`event`, `team`, `start`, `end`, `room`) VALUES ('". $input['event'] ."', '". $input['group'] ."', '". $input['start_date'] ."', '". $input['end_date'] ."', '". $input['room'] ."')";
        
        $exec = DB::connection()->prepare($stmt);
        $exec->execute();

    }
}