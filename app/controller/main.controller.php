<?php

namespace app\controller;

use database\connection\connect;
use app\controller\config;

class MAIN
{

    public static function index()
    {
        $stmt = "SELECT * FROM `v_events` ORDER BY `start` ASC";

        $data = connect::connection()->query($stmt);
        $result = $data->fetchALL();

        return $result;
    }
}
