<?php

namespace app\controller;
use \PDO;
require './app/module/db.module.php';

use app\module\DB as DB;

class employee{
    
    public static function index(){

        $stmt = "SELECT * FROM `employee`";

        $data = DB::connection()->query($stmt);
        $result = $data->fetchAll();

        return $result;
    }
}
