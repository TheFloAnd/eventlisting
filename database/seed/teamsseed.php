<?php

namespace database\seed;

use \PDO;
use database\connection\admin_connect;

class teamsseed extends admin_connect
{

    public function __construct($com)
    {
        $pdo = admin_connect::connection();
        switch($com){
            case 'empty':
                teamsseed::empty_table($pdo);
                break;
            case 'create':
                teamsseed::delete_table($pdo);
                teamsseed::create_table($pdo);
                teamsseed::create_view($pdo);
        }
        $pdo = admin_connect::connection();
    }
    public static function create_table($pdo)
    {
        try {
            $pdo->query("use `" . db['database'] . "`;");
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
            $pdo->query("use `" . db['database'] . "`;");
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

            // $pdo->query(
            //     "CREATE VIEW IF NOT EXISTS `v_teams_active`  AS  select 
            //     `teams`.`id` AS `id`,
            //     `teams`.`name` AS `name`,
            //     `teams`.`alias` AS `alias`,
            //     `teams`.`color` AS `color` ,
            //     `events`.`created_at` AS `created_at`,
            //     `events`.`updated_at` AS `updated_at`
            // from `teams` 
            //     where `teams`.`deleted_at` = NULL 
            //     order by `teams`.`name`
            // ;"
            // );

            // $pdo->query(
            //     "CREATE VIEW IF NOT EXISTS `v_teams_inactive`  AS  select 
            //     `teams`.`id` AS `id`,
            //     `teams`.`name` AS `name`,
            //     `teams`.`alias` AS `alias`,
            //     `teams`.`color` AS `color` ,
            //     `events`.`created_at` AS `created_at`,
            //     `events`.`updated_at` AS `updated_at`
            // from `teams` 
            //     where `teams`.`deleted_at` != 0 
            //     order by `teams`.`name`
            // ;"
            // );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }

    public static function empty_table()
    {
        $pdo = admin_connect::connection();
        try {

            $pdo->query("use `" . db['database'] . "`;");
            $pdo->query(
                "TRUNCATE `events`.`teams`"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }

    public static function delete_table()
    {
        $pdo = admin_connect::connection();
        try {

            $pdo->query("use `" . db['database'] . "`;");

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
