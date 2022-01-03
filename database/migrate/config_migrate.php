<?php

namespace database\migrate;

use \PDO;
use database\connect;
use database\seed\config_seed;

class config_migrate extends connect
{

    public function __construct()
    {
        $pdo = connect::admin();
        config_migrate::create_table($pdo);
        config_seed::index();
    }
    public static function create_table($pdo)
    {
        try {

            $pdo->query(
                "CREATE TABLE  IF NOT EXISTS `config` (
                `id` int NOT NULL,
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
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;"
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
                "INSERT INTO `config` (
                `id`,
                `setting`,
                `value`,
                `time_unit`,
                `created_at`
            ) VALUES (
                1,
                'refresh',
                '15',
                'seconds',
                '" . strftime('%Y-%m-%dT%H:%M') . "'
            ),(
                2,
                'future_day',
                '30',
                'day',
                '" . strftime('%Y-%m-%dT%H:%M') . "'
            ), (
                3,
                'name',
                '',
                '',
                '" . strftime('%Y-%m-%dT%H:%M') . "'
            ), (
                4,
                'language',
                'Deutsch',
                'de_DE',
                '" . strftime('%Y-%m-%dT%H:%M') . "'
            );"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
}