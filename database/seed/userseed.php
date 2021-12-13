<?php

namespace database\seed;

use \PDO;
use database\connection\admin_connect;

class userseed extends admin_connect
{
    private $admin_user = db_admin['user'];
    private $admin_pass = db_admin['pass'];

    private $server = db['host'];

    public function __construct()
    {
        try {

            $pdo = new PDO("mysql:host=" . $this->server . ";charset=utf8", $this->admin_user, $this->admin_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
        userseed::create($pdo);
    }
    public static function create($pdo)
    {
        try {
            $pdo->query("CREATE DATABASE IF NOT EXISTS `" . db['database'] . "`;");

            $pdo->query("CREATE USER IF NOT EXISTS `" . db['user'] . "`@`" . db['host'] . "` IDENTIFIED BY '" . db['password'] . "';");
            $pdo->query("REVOKE ALL PRIVILEGES ON *.* FROM `" . db['user'] . "`@`" . db['host'] . "` ;");
            $pdo->query("GRANT ALL PRIVILEGES ON `" . db['database'] . "`.* TO `" . db['user'] . "`@`" . db['host'] . "` ;");
            $pdo->query("GRANT SELECT, INSERT, UPDATE, DELETE ON `" . db['database'] . "`.* TO `" . db['user'] . "`@`" . db['host'] . "` ; FLUSH PRIVILEGES;");

            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
}
