<?php

namespace database\migrate;

use \PDO;
use database\connect;

class teams_migrate
{

    public function __construct($com)
    {
        $pdo = connect::admin();
        switch($com){
            case 'empty':
                teams_migrate::empty_table($pdo);
                break;
            case 'recreate':
                teams_migrate::delete_table($pdo);
                teams_migrate::create_table($pdo);
                teams_migrate::create_view($pdo);
            default:
                teams_migrate::create_table($pdo);
                teams_migrate::create_view($pdo);
        }
        $pdo = connect::admin();
    }
    public static function create_table($pdo)
    {
        try {
            $pdo->query(
                "CREATE TABLE IF NOT EXISTS `teams` (
                `id` int NOT NULL,
                `name` varchar(255) NOT NULL,
                `alias` varchar(10) NOT NULL,
                `color` varchar(7) NOT NULL,
                `created_at` datetime DEFAULT NULL,
                `updated_at` datetime DEFAULT NULL,
                `deleted_at` datetime DEFAULT NULL
            );"
            );

            $pdo->query(
                "ALTER TABLE `teams`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `alias` (`alias`),
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
                "CREATE VIEW IF NOT EXISTS `v_teams`  AS  select
                `teams`.`id` AS `id`,
                `teams`.`name` AS `name`,
                `teams`.`alias` AS `alias`,
                `teams`.`color` AS `color`,
                `teams`.`created_at` AS `created_at`,
                `teams`.`updated_at` AS `updated_at`,
                `teams`.`deleted_at` AS `deleted_at`
            from `teams` 
                order by `teams`.`name` 
            ;"
            );

            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }

    public static function empty_table($pdo)
    {
        $pdo = connect::admin();
        try {
            $pdo->query(
                "TRUNCATE `events`.`teams`"
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
                "DROP VIEW `events`.`v_teams`"
            );
            $pdo->query(
                "DROP TABLE `events`.`teams`"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
}
