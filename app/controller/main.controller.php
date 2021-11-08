<?php

namespace app\controller;

use database\connection\connect;
use app\controller\config;

class MAIN{
    
    public static function index(){


        // $stmt = "SELECT * FROM `v_events` WHERE convert(datetime, `start`, 104) <= '". strftime('%d.%m.%Y') ."' and convert(datetime, `start`, 104) >= '". strftime('%d.%m.%Y') ."' ORDER BY `start` ASC";

        $stmt = "SELECT * FROM `v_events` WHERE `start` >= curdate() or `end` >= curdate() ORDER BY `start` ASC";

        $data = connect::connection()->query($stmt);

        $stmt_future= "SELECT * FROM `v_events` WHERE `start` <= curdate() + interval (". CONFIG::get('future_day')->value .") ". CONFIG::get('future_day')->time_unit ." and `start` >= curdate() + interval 1 day ORDER BY `start` ASC";

        $data_future = connect::connection()->query($stmt_future);
        // $result = $data->fetchAll();
        $today = $data->fetchALL();
        $future = $data_future->fetchALL();

        return compact('future', 'today');
    }
}