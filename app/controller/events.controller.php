<?php

namespace app\controller;

use database\connection\connect;
use app\controller\config;
use app\controller\group;

class events{
    
    public static function index(){

        // $stmt = "SELECT * FROM `v_events` where start <= '". date("Y-m-d") ."' AND end >= '".date("Y-m-d")."' ORDER BY start ASC";
        $stmt = "SELECT * FROM `v_events` where `start` >= '". strftime('%Y-%m-%d') ."' OR `end` >= '". strftime('%Y-%m-%d') ."' ORDER BY start ASC";

        $data = connect::connection()->query($stmt);
        $result = $data->fetchAll();

        $stmt_proposals = "SELECT `event`, COUNT(`event`) as counted FROM `v_events` GROUP BY `event` ORDER BY counted DESC";
        $data_proposals = connect::connection()->query($stmt_proposals);
        $proposals = $data_proposals->fetchAll();

        $group = GROUP::index();
        $group = $group['active'];

        return compact('proposals', 'result', 'group');
    }
    public static function edit($id){

        $result = events::find($id);
        
        $stmt_proposals = "SELECT `event`, COUNT(`event`) as counted FROM `v_events` GROUP BY `event` ORDER BY counted DESC";
        $data_proposals = connect::connection()->query($stmt_proposals);
        $proposals = $data_proposals->fetchAll();

        $group = GROUP::index();
        $group = $group['active'];

        return compact('proposals', 'result', 'group');
    }

    public static function store($input){
                $group = '';
                $i = 0;
                foreach($input['group'] as $row){
                    $group .= $input['group'][$i] . ';';
                    $i++;
                }

            $stmt = "INSERT INTO `v_events`(`event`, `team`, `start`, `end`, `room`) VALUES ('". $input['event'] ."', '". $group."', '". $input['start_date'] ."', '". $input['end_date'] ."', '". $input['room'] ."')";
        
            $exec = connect::connection()->prepare($stmt);
            $exec->execute();

            
            return;

    }
    public static function store_repeat($input){

                $group = '';
                $i = 0;
                foreach($input['group'] as $row){
                    $group .= $input['group'][$i] . ';';
                    $i++;
                }
            

            $stmt = "INSERT INTO `v_events`(`event`, `team`, `start`, `end`,`repeat`, `room`) VALUES ('". $input['event'] ."', '". $group ."', '". $input['start_date'] ."', '". $input['end_date'] ."', '". $input['repeats'] ."', '". $input['room'] ."')";
            $exec = connect::connection()->prepare($stmt);
            $exec->execute();

            $stmt_find = "SELECT * FROM `v_events` where `event` = '". $input['event'] ."' AND `team` = '". $group ."' AND `start` = '". $input['start_date'] ."' AND `end` = '". $input['end_date'] ."' LIMIT 1";
            $data_find = connect::connection()->query($stmt_find);
            $result_found = $data_find->fetch();


            $start_date = $input['start_date'];
            $end_date = $input['end_date'];

            for($i= 1; $i <= $input['repeats']; $i++){
                $start_date = date('Y-m-d', strtotime($start_date . ' +'. $input['repeat_days'] .' Days'));
                $end_date = date('Y-m-d', strtotime($end_date . ' +'. $input['repeat_days'] .' Days'));

                $stmt_repeat = "INSERT INTO `v_events`(`event`, `team`, `start`, `end`,`repeat_parent`, `room`) VALUES ('". $input['event'] ."', '". $group ."', '". $start_date ."', '". $end_date ."', '". $result_found['id'] ."', '". $input['room'] ."')";
        
                $exec_repeat = connect::connection()->prepare($stmt_repeat);
                $exec_repeat->execute();
            }
            return;
    }

    public static function find($id){

        $stmt = "SELECT * FROM `v_events` where id = '". $id ."' LIMIT 1";

        $data = connect::connection()->query($stmt);
        // $result = $data->fetchAll();

        return $data->fetchObject();
    }

    
    public static function update($input){
        $group = '';
        $i = 0;
        foreach($input['group'] as $row){
            $group .= $input['group'][$i] . ';';
            $i++;
        }
        if(!isset($input['removed'])){
            $stmt = "UPDATE `v_events` SET `not_applicable`= NULL, `event`='". $input['event'] ."',`team`='". $group ."' ,`start`='". $input['start_date'] ."' ,`end`='". $input['end_date'] ."' ,`room`='". $input['room'] ."' WHERE id = '". $input['event_id'] ."'";

            $exec = connect::connection()->prepare($stmt);
            $exec->execute();
        }
        if(isset($input['removed'])){
            $stmt = "UPDATE `v_events` SET `not_applicable`= 1 WHERE id = '". $input['event_id'] ."'";

            $exec = connect::connection()->prepare($stmt);
            $exec->execute();
        }

        return array(true, $input);
    }

    public static function delete($input){
        $stmt = "UPDATE `events` SET `deleted_at`= '". date('Y-m-d H:i:s') ."' WHERE id = '". $input['event_id'] ."'";

        $exec = connect::connection()->prepare($stmt);
        $exec->execute();

        return array(true, $input);
    }
    public static function delete_repeat($input){
        $event = events::find($input['event_id']);
        $id = $event->id ? $event->id : $event->repeat_parent;
        $stmt = "UPDATE `events` SET 
            `deleted_at` = '". date('Y-m-d H:i:s') ."' 
        WHERE id = '". $event->id ."'
            OR `repeat_parent` = ". $id ."
            AND `start` > '". $event->start ."'";
        var_dump($stmt);
        $exec = connect::connection()->prepare($stmt);
        $exec->execute();
        
        return array(true, $input);
    }
}