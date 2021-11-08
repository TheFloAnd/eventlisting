<?php

namespace database\seed;

use \PDO;
use database\connection\admin_connect;

class events extends admin_connect
{

    public function __construct()
    {
        $pdo = admin_connect::connection();
        events::create_table($pdo);
        events::create_view($pdo);
    }
    public static function create_table($pdo)
    {
        try {

            $pdo->query("use `" . db['database'] . "`;");
            $pdo->query(
                "CREATE TABLE   IF NOT EXISTS `events` (
                `id` int NOT NULL,
                `not_applicable` int DEFAULT NULL,
                `event` varchar(255),
                `team` varchar(255) DEFAULT NULL,
                `start` datetime NOT NULL,
                `end` datetime NOT NULL,
                `repeat` int DEFAULT NULL,
                `repeat_parent` int DEFAULT NULL,
                `room` varchar(50) DEFAULT NULL,
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

            $pdo->query("use `" . db['database'] . "`;");
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
                `events`.`room` AS `room`
            from `events`
                where (`events`.`deleted_at` is null)
            ;"
            );

            $pdo->query(
                "CREATE VIEW IF NOT EXISTS  `v_events_future`  AS  select 
                `events`.`id` AS `id`,
                `events`.`not_applicable` AS `not_applicable`,
                `events`.`event` AS `event`,
                `events`.`team` AS `team`,
                `events`.`start` AS `start`,
                `events`.`end` AS `end`,
                `events`.`repeat` AS `repeat`,
                `events`.`repeat_parent` AS `repeat_parent`,
                `events`.`room` AS `room`
            from `events` 
                where `start` <= curdate() + interval (
                    select `config`.`value` from `config` 
                        where `config`.`setting` = 'future_day'
                    ) day 
                and 
                    `start` >= curdate() + interval 1 day 
                and `deleted_at` is null 
            order by `start`
        ;"
            );

            $pdo->query(
                "CREATE VIEW IF NOT EXISTS  `v_events_current`  AS  select 
                `events`.`id` AS `id`,
                `events`.`not_applicable` AS `not_applicable`,
                `events`.`event` AS `event`,
                `events`.`team` AS `team`,
                `events`.`start` AS `start`,
                `events`.`end` AS `end`,
                `events`.`repeat` AS `repeat`,
                `events`.`repeat_parent` AS `repeat_parent`,
                `events`.`room` AS `room`
            from `events` 
                where `deleted_at` is null 
                and `start` <= curdate() 
                and `end` >= curdate() 
            order by `start`
        ;"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
}
