<?php

namespace database;

use \PDO;
use database\migrate\user_migrate;
use database\migrate\config_migrate;
use database\migrate\events_migrate;
use database\migrate\teams_migrate;
use database\migrate\language_migrate;

class connect
{
    
    private const SERVER = "localhost";
    private const USER = "events";
    private const PASSWORD = "";
    private const DATABASE = "events";

    
    private const ADMIN_USER = "root";
    private const ADMIN_PASSWORD = "admin";

    public static function connection()
    {

        try {

            $pdo = new PDO("mysql:host=" . self::SERVER . ";dbname=" . self::DATABASE . ";charset=utf8", self::USER, self::PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $e) {
            //connect::createDB();
            new user_migrate;
            new config_migrate;
            new language_migrate;
            new events_migrate('create');
            new teams_migrate('create');
            header("Refresh:0");
        }
    }
    public static function admin()
    {

        try {

            $pdo = new PDO("mysql:host=" . self::SERVER . ";dbname=" . self::DATABASE . ";charset=utf8", self::ADMIN_USER, self::ADMIN_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
}
