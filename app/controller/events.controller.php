<?php

namespace app\controller;

use app\module\DB;
use app\controller\config;

class events{
    
    public static function index($table){

        // $stmt = "SELECT * FROM `v_events` where start <= '". date("Y-m-d") ."' AND end >= '".date("Y-m-d")."' ORDER BY start ASC";
        $stmt = "SELECT * FROM `". $table ."` ORDER BY `start` ASC";

        $data = DB::connection()->query($stmt);
        // $result = $data->fetchAll();

        return $data->fetchAll();
    }

    public static function future(){
        $conf = CONFIG::get('future_day');

        // $stmt = "SELECT * FROM `v_events` where start <= '". date("Y-m-d") ."' AND end >= '".date("Y-m-d")."' ORDER BY start ASC";
        $stmt = "SELECT * FROM `v_events` WHERE `start` <= curdate() + interval (". $conf->return .") day and `start` >= curdate() + interval 1 day ORDER BY `start` ASC";

        $data = DB::connection()->query($stmt);
        // $result = $data->fetchAll();

        return $data->fetchAll();
    }

    public static function today(){

        // $stmt = "SELECT * FROM `v_events` where start <= '". date("Y-m-d") ."' AND end >= '".date("Y-m-d")."' ORDER BY start ASC";
        $stmt = "SELECT * FROM `v_events` WHERE `start` <= curdate() and `end` >= curdate() ORDER BY `start` ASC";

        $data = DB::connection()->query($stmt);
        // $result = $data->fetchAll();

        return $data->fetchAll();
    }

    public static function proposals(){

        $stmt = "SELECT `event`, COUNT(`event`) as counted FROM `v_events` GROUP BY `event` ORDER BY counted DESC";


        $data = DB::connection()->query($stmt);
        $result = $data->fetchAll();

        return $result;
    }

    public static function store($input){

            $stmt = "INSERT INTO `v_events`(`event`, `team`, `start`, `end`, `room`) VALUES ('". $input['event'] ."', '". $input['group'] ."', '". $input['start_date'] ."', '". $input['end_date'] ."', '". $input['room'] ."')";
        
            $exec = DB::connection()->prepare($stmt);
            $exec->execute();

            
            return;

    }
    public static function store_repeat($input){

            $stmt = "INSERT INTO `v_events`(`event`, `team`, `start`, `end`,`repeat`, `room`) VALUES ('". $input['event'] ."', '". $input['group'] ."', '". $input['start_date'] ."', '". $input['end_date'] ."', '". $input['repeats'] ."', '". $input['room'] ."')";
            $exec = DB::connection()->prepare($stmt);
            $exec->execute();

            $stmt_find = "SELECT * FROM `v_events` where `event` = '". $input['event'] ."' AND `team` = '". $input['group'] ."' AND `start` = '". $input['start_date'] ."' AND `end` = '". $input['end_date'] ."' LIMIT 1";
            $data_find = DB::connection()->query($stmt_find);
            $result_found = $data_find->fetch();


            $start_date = $input['start_date'];
            $end_date = $input['end_date'];

            for($i= 1; $i <= $input['repeats']; $i++){
                $start_date = date('Y-m-d', strtotime($start_date . ' +'. $input['repeat_days'] .' Days'));
                $end_date = date('Y-m-d', strtotime($end_date . ' +'. $input['repeat_days'] .' Days'));

                $stmt_repeat = "INSERT INTO `v_events`(`event`, `team`, `start`, `end`,`repeat_parent`, `room`) VALUES ('". $input['event'] ."', '". $input['group'] ."', '". $start_date ."', '". $end_date ."', '". $result_found['id'] ."', '". $input['room'] ."')";
        
                $exec_repeat = DB::connection()->prepare($stmt_repeat);
                $exec_repeat->execute();
            }
            return;
    }

    public static function show(){

        $stmt = "SELECT * FROM `v_events` where start >= '". date('Y-m-d') ."' OR end >= '". date('Y-m-d') ."' ORDER BY start ASC";
        $data = DB::connection()->query($stmt);
        // $result = $data->fetchAll();

        return $data->fetchAll();
    }

    public static function find($id){

        $stmt = "SELECT * FROM `v_events` where id = '". $id ."' LIMIT 1";

        $data = DB::connection()->query($stmt);
        // $result = $data->fetchAll();

        return $data->fetchObject();
    }

    
    public static function update($input){
        if(!isset($input['removed'])){
            $stmt = "UPDATE `v_events` SET `not_applicable`= NULL, `event`='". $input['event'] ."',`team`='". $input['group'] ."' ,`start`='". $input['start_date'] ."' ,`end`='". $input['end_date'] ."' ,`room`='". $input['room'] ."' WHERE id = '". $input['event_id'] ."'";

            $exec = DB::connection()->prepare($stmt);
            $exec->execute();
        }
        if(isset($input['removed'])){
            $stmt = "UPDATE `v_events` SET `not_applicable`= 1 WHERE id = '". $input['event_id'] ."'";

            $exec = DB::connection()->prepare($stmt);
            $exec->execute();
        }

        return array(true, $input);
    }

    public static function delete($input){
        $stmt = "UPDATE `events` SET `deleted_at`= '". date('Y-m-d H:i:s') ."' WHERE id = '". $input['event_id'] ."'";

        $exec = DB::connection()->prepare($stmt);
        $exec->execute();

        return array(true, $input);
    }
    public static function delete_repeat($input){
        $event = events::find($input['event_id']);
        $stmt = "UPDATE `events` SET `deleted_at`= '". date('Y-m-d H:i:s') ."' WHERE id = '". $event->id ."' OR `repeat_parent` = '". $event->id ."' OR `repeat_parent` = '". $event->repeat_parent ."' AND `start` > '". $event->start ."'";

        $exec = DB::connection()->prepare($stmt);
        $exec->execute();
        
        return array(true, $input);
    }
}