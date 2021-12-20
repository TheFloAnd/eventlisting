<?php

namespace database\migrate;

use \PDO;
use database\connect;

class user_migrate
{
    
    private const USER = "events";
    private const PASSWORD = "";
    private const SERVER = db['host'];
    private const DATABASE = db['database'];

    
    private const ADMIN_USER = "root";
    private const ADMIN_PASSWORD = "admin";

    public function __construct()
    {
        try {

            $pdo = new PDO("mysql:host=" . self::SERVER . ";charset=utf8", self::ADMIN_USER, self::ADMIN_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
        user_migrate::create($pdo);
    }
    public static function create($pdo)
    {
        try {
            $pdo->query("CREATE DATABASE IF NOT EXISTS `" . self::DATABASE . "`;");

            $pdo->query("CREATE USER IF NOT EXISTS `" . self::USER . "`@`" . self::SERVER . "` IDENTIFIED BY '" . self::PASSWORD . "';");
            $pdo->query("REVOKE ALL PRIVILEGES ON *.* FROM `" . self::USER . "`@`" . self::SERVER . "` ;");
            $pdo->query("GRANT ALL PRIVILEGES ON `" . self::DATABASE . "`.* TO `" . self::USER . "`@`" . self::SERVER . "` ;");
            $pdo->query("GRANT SELECT, INSERT, UPDATE, DELETE ON `" . self::DATABASE . "`.* TO `" . self::USER . "`@`" . self::SERVER . "` ; FLUSH PRIVILEGES;");

            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
}
