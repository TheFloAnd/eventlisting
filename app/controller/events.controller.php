<?php

namespace app\controller;

use database\connect;
use app\controller\group;
use app\module\sql;
use \DateTime;
use \DatePeriod;
use \DateInterval;

/*
*   Class for Events
*/
class events
{
/*
*   Lists and returns All Events that arn't Deleted
*
*   :return $result
*   :return $group
*   :return $proposals
*   :return $proposals_room
*/
    public static function index()
    {
        // SQL statment to select future events
        $stmt = "SELECT * FROM `v_events` where `start` >= '" . date('Y-m-d') . "' OR `end` >= '" . date('Y-m-d') . "' ORDER BY start ASC";

        $data = connect::connection()->query($stmt);
        $result = $data->fetchAll();

        // SQL Statment to select the Proposals for Events
        $proposals = sql::proposals('event', 'v_events');

        // SQL Statment to select the Proposals for Rooms
        $proposals_room = sql::proposals('room', 'v_events');

        // Get Active Groups
        $group = GROUP::index();
        $group = $group['active'];

        return compact('proposals', 'proposals_room', 'result', 'group');
    }

/*
*   Lists and returns Events, Groups and Proposals for editing the event
*
*   :return $result
*   :return $group
*   :return $proposals
*   :return $proposals_room
*   :return $future_events
*/
    public static function edit($id)
    {

        $result = events::find($id);
        
        // SQL Statment to select the Proposals for Events
        $proposals = sql::proposals('event', 'v_events');

        // SQL Statment to select the Proposals for Rooms
        $proposals_room = sql::proposals('room', 'v_events');


        $stmt_future_events = "SELECT * FROM `v_events` WHERE `repeat_parent` = '" . $result->repeat_parent . "' OR `id` = '" . $result->id . "' ORDER BY start ASC";
        $future_events = connect::connection()->query($stmt_future_events);
        $future_events = $future_events->fetchAll();

        // Get Active Groups
        $group = GROUP::index();
        $group = $group['active'];

        return compact('proposals', 'proposals_room', 'result', 'group', 'future_events');
    }

/*
*   Stores Events in the Database
*/
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

        $stmt = "INSERT INTO `events`(`event`, `team`, `start`, `end`, `room`, `created_at`) VALUES ('" . $input['event'] . "', '" . $group . "', '" . $input['start_date'] . "', '" . $input['end_date'] . "', '" . $input['room'] . "', '" . date('Y-m-d\TH:i') . "')";

        $exec = connect::connection()->prepare($stmt);
        $exec->execute();


        return;
    }

/*
*   Searchs for a singe row
*/
    public static function find($id)
    {

        $stmt = "SELECT * FROM `v_events` where id = '" . $id . "' LIMIT 1";

        $data = connect::connection()->query($stmt);
        // $result = $data->fetchAll();

        return $data->fetchObject();
    }


/*
*   Updates existing Event entries
*/
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
            $stmt = "UPDATE `events` SET `not_applicable`= NULL, `event`='" . $input['event'] . "',`team`='" . $group . "' ,`start`='" . $input['start_date'] . "' ,`end`='" . $input['end_date'] . "' ,`room`='" . $input['room'] . "', `updated_at`='" . date('Y-m-d\TH:i') . "' WHERE id = '" . $input['event_id'] . "'";

            $exec = connect::connection()->prepare($stmt);
            $exec->execute();
        }
        if (isset($input['removed'])) {
            $stmt = "UPDATE `events` SET `not_applicable`= 1, `updated_at`='" . date('Y-m-d\TH:i') . "' WHERE id = '" . $input['event_id'] . "'";

            $exec = connect::connection()->prepare($stmt);
            $exec->execute();
        }

        return array(true, $input);
    }

/*
*   Deletes Events in the Database
*/
    public static function delete($input)
    {
        $stmt = "UPDATE `events` SET `deleted_at`= '" . date('Y-m-d H:i:S') . "', `updated_at`='" . date('Y-m-d\TH:i') . "' WHERE id = '" . $input['event_id'] . "'";

        $exec = connect::connection()->prepare($stmt);
        $exec->execute();

        return array(true, $input);
    }
}
