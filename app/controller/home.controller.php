<?php

namespace app\controller;

use database\connect;
use app\controller\config;

class home
{
/*
*   Lists and returns All Settings
*
*   :return $result
*/
    public static function index()
    {
        $stmt = "SELECT * FROM `v_events` ORDER BY `start` ASC";

        $data = connect::connection()->query($stmt);
        $result = $data->fetchALL();

        return $result;
    }
}
