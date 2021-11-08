<?php

namespace app\controller;

use database\connection\connect;
use app\controller\config;

class MAIN{
    
    public static function index(){


        $stmt_today = "SELECT * FROM `v_events` WHERE `start` <= curdate() and `end` >= curdate() ORDER BY `start` ASC";

        $data_today = connect::connection()->query($stmt_today);

        $stmt_future= "SELECT * FROM `v_events` WHERE `start` <= curdate() + interval (". CONFIG::get('future_day')->value .") ". CONFIG::get('future_day')->time_unit ." and `start` >= curdate() + interval 1 day ORDER BY `start` ASC";

        $data_future = connect::connection()->query($stmt_future);
        // $result = $data->fetchAll();
        $today = $data_today->fetchALL();
        $future = $data_future->fetchALL();

        return compact('future', 'today');
    }
}