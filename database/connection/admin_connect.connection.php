<?php

namespace database\connection;

use \PDO;

class admin_connect
{
    private $admin_user = db_admin['user'];
    private $admin_pass = db_admin['pass'];

    private $server = db['host'];
    private $database = db['database'];

    public function connection()
    {

        try {

            $pdo = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->database . ";charset=utf8", $this->admin_user, $this->admin_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
}
