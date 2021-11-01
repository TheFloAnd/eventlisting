<?php

namespace app\controller;

use app\module\DB;
use app\controller\config;

class MAIN{
    
    public static function index(){


        $stmt_today = "SELECT * FROM `v_events` WHERE `start` <= curdate() and `end` >= curdate() ORDER BY `start` ASC";

        $data_today = DB::connection()->query($stmt_today);

        $stmt_future= "SELECT * FROM `v_events` WHERE `start` <= curdate() + interval (". CONFIG::get('future_day')->return .") day and `start` >= curdate() + interval 1 day ORDER BY `start` ASC";

        $data_future = DB::connection()->query($stmt_future);
        // $result = $data->fetchAll();
        $today = $data_today->fetchALL();
        $future = $data_future->fetchALL();

        return compact('future', 'today');
    }
}