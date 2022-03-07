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
                '" . date('Y-m-d\TH:i') . "'
            ),(
                2,
                'future_day',
                '30',
                'day',
                '" . date('Y-m-d\TH:i') . "'
            ), (
                3,
                'name',
                '',
                '',
                '" . date('Y-m-d\TH:i') . "'
            ), (
                4,
                'language',
                'de_DE',
                '',
                '" . date('Y-m-d\TH:i') . "'
            ), (
                5,
                'design',
                'light',
                '',
                '" . date('Y-m-d\TH:i') . "'
            ), (
                6,
                'protection',
                'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec',
                '',
                '" . date('Y-m-d\TH:i') . "'
            );"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
}
