<?php

namespace database\seed;

use \PDO;
use database\connection\admin_connect;

class languageseed extends admin_connect
{

    public function __construct()
    {
        $pdo = admin_connect::connection();

        languageseed::create_table($pdo);
        languageseed::insert($pdo);
    }
    public static function create_table($pdo)
    {
        try {
            $pdo->query(
                "CREATE TABLE  IF NOT EXISTS `language` (
                `id` int NOT NULL,
                `view` varchar(50) NOT NULL,
                `code` varchar(10) NOT NULL,
            );"
            );
            $pdo->query(
                "ALTER TABLE `language`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `code` (`code`),
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }

    public static function insert($pdo)
    {
        try {
            $pdo->query(
                "INSERT INTO `language` (
                `id`,
                `view`,
                `code`
            ) VALUES (
                1,
                'Deutsch',
                'de_DE'
            ),(
                2,
                'English',
                'en_EN'
            );"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
}
