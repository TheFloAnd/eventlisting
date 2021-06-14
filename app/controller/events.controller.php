<?php

namespace app\controller;
use \PDO;
require './app/module/db.module.php';

use app\module\DB as DB;

class events{
    
    public static function index(){

        $stmt = "SELECT * FROM `events` where start <= '". date("Y-m-d") ."' AND end >= '".date("Y-m-d")."'";

        $data = DB::connection()->query($stmt);
        $result = $data->fetchAll();

        return $result;
    }
}