<?php

namespace database\connection;

use \PDO;
use database\seed\user;
use database\seed\config;
use database\seed\events;
use database\seed\teams;

class connect
{

    public static function connection()
    {

        $server = db['host'];
        $user = db['user'];
        $password = db['password'];
        $database = db['database'];

        try {

            $pdo = new PDO("mysql:host=" . $server . ";dbname=" . $database . ";charset=utf8", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $e) {
            //connect::createDB();
            new User;
            new config;
            new events;
            new teams;
            header("Refresh:0");
        }
    }
}
