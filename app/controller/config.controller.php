<?php

namespace app\controller;

use app\module\DB;
use \PDO;
class config{

                    public static function index(){
                                        $stmt = "SELECT * FROM `config`";

                                        $data = DB::connection()->query($stmt);
                                        // $result = $data->fetchAll();

                                        return $data->fetchAll();
                    }
                    public static function find($id){
                                        $stmt = "SELECT * FROM `config` where id = '". $id ."' LIMIT 1";

                                        $data = DB::connection()->query($stmt);
                                        // $result = $data->fetch();

                                        return $data->fetchObject();
                    }

                    public static function get($setting){

                                        $result = new config;
                                        $stmt = "SELECT `value` FROM `config` where `setting` = '". $setting ."'";

                                        $data = DB::connection()->query($stmt);
                                        $result->return = $data->fetchColumn();

                                        return $result;
                    }
                    
                    public static function update($setting){

                                        $stmt = "UPDATE `config` SET `value` = '". $setting['setting_value'] ."' where `id` = '". $setting['setting_id'] ."'";

                                        $exec = DB::connection()->prepare($stmt);
                                        $exec->execute();

                                        return true;
                    }
}