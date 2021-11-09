<?php

namespace database\seed;

use \PDO;
use database\connection\admin_connect;

class teams extends admin_connect
{

    public function __construct()
    {
        $pdo = admin_connect::connection();
        teams::create_table($pdo);
        teams::create_view($pdo);
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
                `active` int NOT NULL DEFAULT '1'
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
                `teams`.`active` AS `active`
            from `teams` 
                order by `teams`.`name` 
            ;"
            );

            $pdo->query(
                "CREATE VIEW IF NOT EXISTS `v_teams_active`  AS  select 
                `teams`.`id` AS `id`,
                `teams`.`name` AS `name`,
                `teams`.`alias` AS `alias`,
                `teams`.`color` AS `color` 
            from `teams` 
                where `teams`.`active` = 1 
                order by `teams`.`name`
            ;"
            );

            $pdo->query(
                "CREATE VIEW IF NOT EXISTS `v_teams_inactive`  AS  select 
                `teams`.`id` AS `id`,
                `teams`.`name` AS `name`,
                `teams`.`alias` AS `alias`,
                `teams`.`color` AS `color` 
            from `teams` 
                where `teams`.`active` = 0 
                order by `teams`.`name`
            ;"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
}
