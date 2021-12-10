<?php

namespace database\seed;

use \PDO;
use database\connection\admin_connect;

class eventsseed extends admin_connect
{

    public function __construct($com)
    {
        $pdo = admin_connect::connection();
        switch($com){
            case 'empty':
                eventsseed::empty_table($pdo);
                break;
            default:
                eventsseed::delete_table($pdo);
                eventsseed::create_table($pdo);
                eventsseed::create_view($pdo);
        }
    }
    public static function create_table($pdo)
    {
        try {
            $pdo->query(
                "CREATE TABLE   IF NOT EXISTS `events` (
                `id` int NOT NULL,
                `not_applicable` int DEFAULT NULL,
                `event` varchar(50),
                `team` varchar(255) DEFAULT NULL,
                `start` datetime NOT NULL,
                `end` datetime NOT NULL,
                `repeat` int DEFAULT NULL,
                `repeat_parent` int DEFAULT NULL,
                `repeat_dif` int DEFAULT NULL,
                `room` varchar(25) DEFAULT NULL,
                `created_at` datetime DEFAULT NULL,
                `updated_at` datetime DEFAULT NULL,
                `deleted_at` datetime DEFAULT NULL
                ) ;"
            );
            $pdo->query(
                "ALTER TABLE `events`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `id` (`id`),
                ADD KEY `team` (`team`),
                MODIFY `id` int NOT NULL AUTO_INCREMENT
                ;"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }

    public static function create_view($pdo)
    {
        try {
            $pdo->query(
                "CREATE VIEW IF NOT EXISTS `v_events`  AS  select 
                `events`.`id` AS `id`,
                `events`.`not_applicable` AS `not_applicable`,
                `events`.`event` AS `event`,
                `events`.`team` AS `team`,
                `events`.`start` AS `start`,
                `events`.`end` AS `end`,
                `events`.`repeat` AS `repeat`,
                `events`.`repeat_parent` AS `repeat_parent`,
                `events`.`repeat_dif` AS `repeat_dif`,
                `events`.`room` AS `room`,
                `events`.`created_at` AS `created_at`,
                `events`.`updated_at` AS `updated_at`
            from `events`
                where (`events`.`deleted_at` is null)
            ;"
            );

            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
    public static function empty_table($pdo)
    {
        try {
            $pdo->query(
                "TRUNCATE `events`.`events`"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }

    public static function delete_table($pdo)
    {
        try {
            $pdo->query(
                "DROP VIEW `events`.`v_events`"
            );
            $pdo->query(
                "DROP TABLE `events`.`events`"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
}
