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

            }catch(PDOException $e){

                echo"Connection failed: ".$e->getMassage();

            }
        }
        public static function select($table){
            "SELECT * FROM `". $table ."`";
            return;
        }
        public static function select_raw($select, $table){

            
        }
    }
