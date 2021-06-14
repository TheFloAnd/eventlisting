<?php
namespace Database {

    class Database
    {
        private$server;
        private$user;
        private$password;
        private$database;

        public function connection(){

            $this->server = db['host'];
            $this->user = db['user'];
            $this->password = db['password'];
            $this->database = db['database'];

            try{

                $pdo = new PDO("mysql:host=".$this->server.";dbname=".$this->database.";charset=utf8", $this->user, $this->password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return$pdo;

            }catch(PDOException $e){

                echo"Connection failed: ".$e->getMassage();

            }
        }
    }
}