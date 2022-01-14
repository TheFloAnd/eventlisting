<?php

namespace app\controller;

use database\connect;
use app\controller\group;
use \DateTime;
use \DatePeriod;
use \DateInterval;

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
        $stmt_future_events = "SELECT * FROM `v_events` WHERE `repeat_parent` = '" . $result->repeat_parent . "' OR `id` = '" . $result->id . "' ORDER BY start ASC";
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

    public static function delete($input)
    {
        $stmt = "UPDATE `events` SET `deleted_at`= '" . strftime('%Y-%m-%d %H:%M:%S') . "', `updated_at`='" . strftime('%Y-%m-%dT%H:%M') . "' WHERE id = '" . $input['event_id'] . "'";

        $exec = connect::connection()->prepare($stmt);
        $exec->execute();

        return array(true, $input);
    }
}
