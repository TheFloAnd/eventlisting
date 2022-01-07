<?php

namespace app\controller;

use database\connect;
use app\controller\group;

class events
{

    public static function index()
    {

        $stmt = "SELECT * FROM `v_events` where `start` >= '" . strftime('%Y-%m-%d') . "' OR `end` >= '" . strftime('%Y-%m-%d') . "' ORDER BY start ASC";

        $data = connect::connection()->query($stmt);
        $result = $data->fetchAll();

        $stmt_proposals = "SELECT `event`, COUNT(`event`) as counted FROM `v_events` GROUP BY `event` ORDER BY counted DESC";
        $data_proposals = connect::connection()->query($stmt_proposals);
        $proposals = $data_proposals->fetchAll();

        $stmt_proposals_room = "SELECT `room`, COUNT(`room`) as counted FROM `v_events` GROUP BY `event` ORDER BY counted DESC";
        $stmt_proposals_room = connect::connection()->query($stmt_proposals_room);
        $proposals_room = $stmt_proposals_room->fetchAll();

        $group = GROUP::index();
        $group = $group['active'];

        return compact('proposals', 'proposals_room', 'result', 'group');
    }
    public static function edit($id)
    {

        $result = events::find($id);

        $stmt_proposals = "SELECT `event`, COUNT(`event`) as counted FROM `v_events` GROUP BY `event` ORDER BY counted DESC";
        $data_proposals = connect::connection()->query($stmt_proposals);
        $proposals = $data_proposals->fetchAll();


        $stmt_proposals_room = "SELECT `room`, COUNT(`room`) as counted FROM `v_events` GROUP BY `event` ORDER BY counted DESC";
        $stmt_proposals_room = connect::connection()->query($stmt_proposals_room);
        $proposals_room = $stmt_proposals_room->fetchAll();


        // $stmt_future_events = "SELECT * FROM `v_events` where `start` >= '" . strftime('%Y-%m-%d', strtotime('+ 1 day')) . "' OR `end` >= '" . strftime('%Y-%m-%d', strtotime('+ 1 day')) . "' AND `repeat_parent` = '". $result->repeat_parent ."' OR `id` = '". $result->repeat_parent ."' ORDER BY start ASC";
        $stmt_future_events = "SELECT * FROM `v_events` WHERE `repeat_parent` = '". $result->repeat_parent ."' OR `id` = '". $result->id ."' ORDER BY start ASC";
        $future_events = connect::connection()->query($stmt_future_events);
        $future_events = $future_events->fetchAll();


        $group = GROUP::index();
        $group = $group['active'];

        return compact('proposals', 'proposals_room', 'result', 'group', 'future_events');
    }

    public static function store($input)
    {
        if (is_array($input['group'])) {
            $group = '';
            $i = 0;
            $j = 1;
            $count_groups = count($input['group']);
            foreach ($input['group'] as $row) {
                if ($count_groups == $j) {
                    $group .= $row;
                } else {
                    $group .= $row . ';';
                }
                $i++;
                $j++;
            }
        } else {
            $group = $input['group'];
        }

        $stmt = "INSERT INTO `events`(`event`, `team`, `start`, `end`, `room`, `created_at`) VALUES ('" . $input['event'] . "', '" . $group . "', '" . $input['start_date'] . "', '" . $input['end_date'] . "', '" . $input['room'] . "', '" . strftime('%Y-%m-%dT%H:%M') . "')";

        $exec = connect::connection()->prepare($stmt);
        $exec->execute();


        return;
    }
    public static function store_repeat($input)
    {
        if (is_array($input['group'])) {
            $group = '';
            $i = 0;
            $j = 1;
            $count_groups = count($input['group']);
            foreach ($input['group'] as $row) {
                if ($count_groups == $j) {
                    $group .= $row;
                } else {
                    $group .= $row . ';';
                }
                $i++;
                $j++;
            }
        } else {
            $group = $input['group'];
        }

        switch ($input['set_repeat']) {
            case 'weeks':
                $repeat_dif = $input['repeat_days'] * 7;
                break;
            default:
                $repeat_dif = $input['repeat_days'];
                break;
        }

        $stmt = "INSERT INTO `events`(`event`, `team`, `start`, `end`,`repeat`,`repeat_dif`, `room`, `created_at`) VALUES ('" . $input['event'] . "', '" . $group . "', '" . $input['start_date'] . "', '" . $input['end_date'] . "', '" . $input['repeats'] . "','" . $repeat_dif . "', '" . $input['room'] . "', '" . strftime('%Y-%m-%dT%H:%M') . "')";
        $exec = connect::connection()->prepare($stmt);
        $exec->execute();

        $stmt_find = "SELECT * FROM `v_events` where `event` = '" . $input['event'] . "' AND `team` = '" . $group . "' AND `start` = '" . $input['start_date'] . "' AND `end` = '" . $input['end_date'] . "' LIMIT 1";
        $data_find = connect::connection()->query($stmt_find);
        $result_found = $data_find->fetch();

        $start_date = $input['start_date'];
        $end_date = $input['end_date'];
        for ($i = 1; $i < $input['repeats']; $i++) {
            $start_date = strftime('%Y-%m-%d %H:%M', strtotime($start_date . ' +' . $input['repeat_days'] . ' ' . $input['set_repeat'] . ''));
            $end_date = strftime('%Y-%m-%d %H:%M', strtotime($end_date . ' +' . $input['repeat_days'] . ' ' . $input['set_repeat'] . ''));

            $stmt_repeat = "INSERT INTO `events`(`event`, `team`, `start`, `end`,`repeat_parent`,`repeat_dif`, `room`, `created_at`) VALUES ('" . $input['event'] . "', '" . $group . "', '" . $start_date . "', '" . $end_date . "', '" . $result_found['id'] . "','" . $repeat_dif . "', '" . $input['room'] . "', '" . strftime('%Y-%m-%dT%H:%M') . "')";

            $exec_repeat = connect::connection()->prepare($stmt_repeat);
            $exec_repeat->execute();
        }
        return;
    }

    public static function find($id)
    {

        $stmt = "SELECT * FROM `v_events` where id = '" . $id . "' LIMIT 1";

        $data = connect::connection()->query($stmt);
        // $result = $data->fetchAll();

        return $data->fetchObject();
    }


    public static function update($input)
    {
        if (!isset($input['removed'])) {

            if (is_array($input['group'])) {
                $group = '';
                $i = 0;
                $j = 1;
                $count_groups = count($input['group']);
                foreach ($input['group'] as $row) {
                    if ($count_groups == $j) {
                        $group .= $row;
                    } else {
                        $group .= $row . ';';
                    }
                    $i++;
                    $j++;
                }
            } else {
                $group = $input['group'];
            }
            $stmt = "UPDATE `events` SET `not_applicable`= NULL, `event`='" . $input['event'] . "',`team`='" . $group . "' ,`start`='" . $input['start_date'] . "' ,`end`='" . $input['end_date'] . "' ,`room`='" . $input['room'] . "', `updated_at`='" . strftime('%Y-%m-%dT%H:%M') . "' WHERE id = '" . $input['event_id'] . "'";

            $exec = connect::connection()->prepare($stmt);
            $exec->execute();
        }
        if (isset($input['removed'])) {
            $stmt = "UPDATE `events` SET `not_applicable`= 1, `updated_at`='" . strftime('%Y-%m-%dT%H:%M') . "' WHERE id = '" . $input['event_id'] . "'";

            $exec = connect::connection()->prepare($stmt);
            $exec->execute();
        }

        return array(true, $input);
    }
    public static function update_repeat($input)
    {
        $event = events::find($input['event_id']);
        $id = $event->repeat_parent ? $event->repeat_parent : $event->id;
        if (!isset($input['removed'])) {

            if (is_array($input['group'])) {
                $group = '';
                $i = 0;
                $j = 1;
                $count_groups = count($input['group']);
                foreach ($input['group'] as $row) {
                    if ($count_groups == $j) {
                        $group .= $row;
                    } else {
                        $group .= $row . ';';
                    }
                    $i++;
                    $j++;
                }
            } else {
                $group = $input['group'];
            }

            $stmt_all = "SELECT * FROM `events` 
                                        WHERE id = '" . $id . "'
                                            OR `repeat_parent` = " . $id . "
                                        ORDER BY `id` ASC";
            $exec_all = connect::connection()->query($stmt_all);
            $all = $exec_all->fetchAll();

            $start_date = $input['start_date'];
            $end_date = $input['end_date'];
            foreach ($all as $row) {

                $stmt = "UPDATE `events` SET 
            `not_applicable`= NULL,
            `event`='" . $input['event'] . "',
            `team`='" . $group . "' ,
            `start`='" . $start_date . "' ,
            `end`='" . $end_date . "' ,
            `room`='" . $input['room'] . "',
            `updated_at`='" . strftime('%Y-%m-%dT%H:%M') . "' 
        WHERE id = '" . $row['id'] . "'";

                $exec = connect::connection()->prepare($stmt);
                $exec->execute();
                $start_date = strftime('%Y-%m-%d %H:%M', strtotime($start_date . ' +' . $input['repeat_days'] . ' days'));
                $end_date = strftime('%Y-%m-%d %H:%M', strtotime($end_date . ' +' . $input['repeat_days'] . ' days'));
            }
        }
        if (isset($input['removed'])) {

            $stmt = "UPDATE `events` SET 
            `not_applicable`= 1,
            `updated_at`='" . strftime('%Y-%m-%dT%H:%M') . "' 
        WHERE id = '" . $id . "'
            OR `repeat_parent` = " . $id . "
            OR `id` = " . $event->id . "
            AND `start` > '" . $event->start . "'";

            $exec = connect::connection()->prepare($stmt);
            $exec->execute();
        }

        return array(true, $input);
    }

    public static function delete($input)
    {
        $stmt = "UPDATE `events` SET `deleted_at`= '" . strftime('%Y-%m-%d %H:%M:%S') . "', `updated_at`='" . strftime('%Y-%m-%dT%H:%M') . "' WHERE id = '" . $input['event_id'] . "'";

        $exec = connect::connection()->prepare($stmt);
        $exec->execute();

        return array(true, $input);
    }
    public static function delete_repeat($input)
    {
        $event = events::find($input['event_id']);
        $id = $event->repeat_parent ? $event->repeat_parent : $event->id;
        $stmt = "UPDATE `events` SET 
            `deleted_at` = '" .  strftime('%Y-%m-%d %H:%M:%S') . "',
            `updated_at`='" . strftime('%Y-%m-%dT%H:%M') . "' 
        WHERE id = '" . $id . "'
            OR `repeat_parent` = " . $id . "
            OR `id` = " . $event->id . "
            AND `start` > '" . $event->start . "'";
        $exec = connect::connection()->prepare($stmt);
        $exec->execute();

        return array(true, $input);
    }
}
