<?php

namespace database\connection;

use \PDO;
use database\seed\userseed;
use database\seed\configseed;
use database\seed\eventsseed;
use database\seed\teamsseed;
use database\seed\languageseed;

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
            new Userseed;
            new configseed;
            new languageseed;
            new eventsseed('create');
            new teamsseed('create');
            header("Refresh:0");
        }
    }
}
