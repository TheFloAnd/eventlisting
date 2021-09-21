<?php
namespace app\module;
use \PDO;
    class DB
    {

        public static function connection(){

            $server = db['host'];
            $user = db['user'];
            $password = db['password'];
            $database = db['database'];

            try{

                $pdo = new PDO("mysql:host=".$server.";dbname=".$database.";charset=utf8", $user, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return$pdo;
            }
            catch(\PDOException $e) {
                DB::createConnection();
            }

        }
        private static function createConnection(){

            $server = db['host'];
            $user_login= 'root';
            $password_login = 'admin';


            $user = db['user'];
            $password = db['password'];
            $database = db['database'];
            try{

                $pdo = new PDO("mysql:host=".$server.";charset=utf8", $user_login, $password_login);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $pdo->query("CREATE DATABASE IF NOT EXISTS `". $database ."`;");

                $pdo->query("CREATE USER IF NOT EXISTS `" . $user . "`@`". $server ."` IDENTIFIED BY '" . $password . "';");
                $pdo->query("REVOKE ALL PRIVILEGES ON *.* FROM `" . $user . "`@`". $server ."` ;");
                $pdo->query("GRANT ALL PRIVILEGES ON `". $database ."`.* TO `" . $user . "`@`". $server ."` ;");
                $pdo->query("GRANT SELECT, INSERT, UPDATE, DELETE ON `" . $database . "`.* TO `" . $user . "`@`". $server ."` ; FLUSH PRIVILEGES;");

                $pdo->query("use `" . $database ."`;");

                $pdo->query("CREATE TABLE  IF NOT EXISTS `config` (
                                                `id` int(11) NOT NULL,
                                                `view` varchar(50) NOT NULL,
                                                `setting` varchar(50) NOT NULL,
                                                `value` varchar(50) NOT NULL
                                            );");
                $pdo->query("ALTER TABLE `config`
                                                ADD PRIMARY KEY (`id`),
                                                ADD UNIQUE KEY `setting` (`setting`),
                                                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;");

                $pdo->query("INSERT INTO `config` (`id`, `view`, `setting`, `value`) VALUES (1, 'Automatisches Neuladen (in Sekunden)', 'refresh', '15'), (2, 'Termin Preview Zeitraum (in Tagen)', 'future_day', '30'), (3, 'Überschrift', 'name', '');");

                $pdo->query("CREATE TABLE   IF NOT EXISTS `events` (
                                                `id` int NOT NULL,
                                                `not_applicable` int DEFAULT NULL,
                                                `event` varchar(255),
                                                `team` varchar(10) DEFAULT NULL,
                                                `start` date NOT NULL,
                                                `end` date NOT NULL,
                                                `repeat` int DEFAULT NULL,
                                                `repeat_parent` int DEFAULT NULL,
                                                `room` varchar(50) DEFAULT NULL,
                                                `deleted_at` datetime DEFAULT NULL
                                            ) ;");

                $pdo->query("CREATE TABLE IF NOT EXISTS `teams` (
                                                `id` int NOT NULL,
                                                `name` varchar(255) NOT NULL,
                                                `alias` varchar(10) NOT NULL,
                                                `color` varchar(7) NOT NULL,
                                                `active` int NOT NULL DEFAULT '1'
                                                );"
                                            );

                $pdo->query("ALTER TABLE `events`
                                                ADD PRIMARY KEY (`id`),
                                                ADD UNIQUE KEY `id` (`id`),
                                                ADD KEY `team` (`team`),
                                                MODIFY `id` int NOT NULL AUTO_INCREMENT
                                                ;");
                $pdo->query("ALTER TABLE `teams`
                                                ADD PRIMARY KEY (`id`),
                                                ADD UNIQUE KEY `alias` (`alias`),
                                                MODIFY `id` int NOT NULL AUTO_INCREMENT
                                                ;");

                $pdo->query("ALTER TABLE `events`
                                                ADD CONSTRAINT `team` FOREIGN KEY (`team`) REFERENCES `teams` (`alias`) ON DELETE RESTRICT ON UPDATE RESTRICT;");

                $pdo->query("CREATE VIEW IF NOT EXISTS `v_events`  AS  select 
                                                    `events`.`id` AS `id`,
                                                    `events`.`not_applicable` AS `not_applicable`,
                                                    `events`.`event` AS `event`,
                                                    `events`.`team` AS `team`,
                                                    `events`.`start` AS `start`,
                                                    `events`.`end` AS `end`,
                                                    `events`.`repeat` AS `repeat`,
                                                    `events`.`repeat_parent` AS `repeat_parent`,
                                                    `events`.`room` AS `room`,
                                                    `teams`.`name` AS `team_name`,
                                                    `teams`.`color` AS `team_color` 
                                                from (`events` join 
                                                    `teams` 
                                                    on((`events`.`team` = `teams`.`alias`))) 
                                                where (`events`.`deleted_at` is null);"
                                            );

                $pdo->query("CREATE VIEW IF NOT EXISTS `v_teams`  AS  select
                                                `teams`.`id` AS `id`,
                                                `teams`.`name` AS `name`,
                                                `teams`.`alias` AS `alias`,
                                                `teams`.`color` AS `color`,
                                                `teams`.`active` AS `active`
                                                from `teams` 
                                                order by `teams`.`name` ;"
                                            );

                $pdo->query("CREATE VIEW IF NOT EXISTS  `v_events_future`  AS  select 
                                                    `events`.`id` AS `id`,
                                                    `events`.`not_applicable` AS `not_applicable`,
                                                    `events`.`event` AS `event`,
                                                    `events`.`team` AS `team`,
                                                    `events`.`start` AS `start`,
                                                    `events`.`end` AS `end`,
                                                    `events`.`repeat` AS `repeat`,
                                                    `events`.`repeat_parent` AS `repeat_parent`,
                                                    `events`.`room` AS `room`,
                                                    `teams`.`name` AS `team_name`,
                                                    `teams`.`color` AS `team_color` 
                                                    from (`events` join `teams` on(`team` = `teams`.`alias`)) 
                                                    where `start` <= curdate() + interval (select `config`.`value` from `config` where `config`.`setting` = 'future_day') day 
                                                        and `start` >= curdate() + interval 1 day 
                                                        and `deleted_at` is null 
                                                    order by `start`;");

                $pdo->query("CREATE VIEW IF NOT EXISTS  `v_events_current`  AS  select 
                                                    `events`.`id` AS `id`,
                                                    `events`.`not_applicable` AS `not_applicable`,
                                                    `events`.`event` AS `event`,
                                                    `events`.`team` AS `team`,
                                                    `events`.`start` AS `start`,
                                                    `events`.`end` AS `end`,
                                                    `events`.`repeat` AS `repeat`,
                                                    `events`.`repeat_parent` AS `repeat_parent`,
                                                    `events`.`room` AS `room`,
                                                    `teams`.`name` AS `team_name`,
                                                    `teams`.`color` AS `team_color` 
                                                    from (`events` join `teams` on(`team` = `teams`.`alias`)) 
                                                    where `deleted_at` is null 
                                                        and `start` <= curdate() 
                                                        and `end` >= curdate() 
                                                    order by `start` ;");

                $pdo->query("CREATE VIEW IF NOT EXISTS `v_teams_active`  AS  select 
                                                    `teams`.`id` AS `id`,
                                                    `teams`.`name` AS `name`,
                                                    `teams`.`alias` AS `alias`,
                                                    `teams`.`color` AS `color` 
                                                from `teams` 
                                                where `teams`.`active` = 1 
                                                order by `teams`.`name` ;");

                $pdo->query("CREATE VIEW IF NOT EXISTS `v_teams_inactive`  AS  select 
                                                `teams`.`id` AS `id`,
                                                `teams`.`name` AS `name`,
                                                `teams`.`alias` AS `alias`,
                                                `teams`.`color` AS `color` 
                                            from `teams` 
                                            where `teams`.`active` = 0 
                                            order by `teams`.`name` ;");

            }catch(\PDOException $e){

                echo"Connection failed: ".$e;

            }
            header("Refresh:0");
            return;
        }
    }
