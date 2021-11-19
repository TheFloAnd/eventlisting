<?php

namespace database\seed;

use \PDO;
use database\connection\admin_connect;

class config extends admin_connect
{

    public function __construct()
    {
        $pdo = admin_connect::connection();
        config::create_table($pdo);
        config::insert($pdo);
    }
    public static function create_table($pdo)
    {
        try {
            $pdo->query("use `" . db['database'] . "`;");

            $pdo->query(
                "CREATE TABLE  IF NOT EXISTS `config` (
                `id` int NOT NULL,
                `view` varchar(50) NOT NULL,
                `setting` varchar(50) NOT NULL,
                `value` varchar(50) NOT NULL,
                `time_unit` varchar(50) NOT NULL,
                `created_at` datetime DEFAULT NULL,
                `updated_at` datetime DEFAULT NULL
            );"
            );
            $pdo->query(
                "ALTER TABLE `config`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `setting` (`setting`),
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }

    public static function insert($pdo)
    {
        try {
            $pdo->query("use `" . db['database'] . "`;");

            $pdo->query(
                "INSERT INTO `config` (
                `id`,
                `view`,
                `setting`,
                `value`,
                `time_unit`,
                `created_at`
            ) VALUES (
                1,
                'Automatisches Neuladen',
                'refresh',
                '15',
                'seconds',
                '". strftime('%Y-%m-%dT%H:%M') ."'
            ),(
                2,
                'Termin Preview Zeitraum',
                'future_day',
                '30',
                'day',
                '". strftime('%Y-%m-%dT%H:%M') ."'
            ), (
                3,
                'Überschrift',
                'name',
                '',
                '',
                '". strftime('%Y-%m-%dT%H:%M') ."'
            );"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
}
