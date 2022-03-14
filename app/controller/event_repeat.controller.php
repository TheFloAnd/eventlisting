<?php

namespace app\controller;

use database\connect;
use app\controller\group;
use \DateTime;
use \DatePeriod;
use \DateInterval;

class event_repeat
{
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

        switch ($input['set_repeat']) {
            case 'weeks':
                $repeat_dif = $input['repeat_days'] * 7;
                break;
            default:
                $repeat_dif = $input['repeat_days'];
                break;
        }

        $start_date = $input['start_date'];
        $end_date = $input['end_date'];

        $uuid = uniqid();
        if ($input['set_repeat_time'] == 'repeats') {

            $stmt = "INSERT INTO `events`(`event`, `team`, `start`, `end`,`repeat`,`repeat_parent`,`repeat_dif`, `room`, `created_at`) VALUES ('" . $input['event'] . "', '" . $group . "', '" . $start_date . "', '" . $end_date . "', '" . $input['repeats_repeats'] . "','" . $uuid . "','" . $repeat_dif . "', '" . $input['room'] . "', '" . date('Y-m-d\TH:i') . "')";
            $exec = connect::connection()->prepare($stmt);
            $exec->execute();

            $stmt_find = "SELECT * FROM `v_events` where `event` = '" . $input['event'] . "' AND `team` = '" . $group . "' AND `start` = '" . $input['start_date'] . "' AND `end` = '" . $input['end_date'] . "' LIMIT 1";
            $data_find = connect::connection()->query($stmt_find);
            $result_found = $data_find->fetch();

            for ($i = 1; $i < $input['repeats_repeats']; $i++) {
                $start_date = date('Y-m-d H:i', strtotime($start_date . ' +' . $input['repeat_days'] . ' ' . $input['set_repeat'] . ''));
                $end_date = date('Y-m-d H:i', strtotime($end_date . ' +' . $input['repeat_days'] . ' ' . $input['set_repeat'] . ''));

                $stmt_repeat = "INSERT INTO `events`(`event`, `team`, `start`, `end`,`repeat_parent`,`repeat_dif`, `room`, `created_at`) VALUES ('" . $input['event'] . "', '" . $group . "', '" . $start_date . "', '" . $end_date . "', '" . $uuid . "','" . $repeat_dif . "', '" . $input['room'] . "', '" . date('Y-m-d\TH:i') . "')";

                $exec_repeat = connect::connection()->prepare($stmt_repeat);
                $exec_repeat->execute();
            }
        } else {

            $begin_start = new DateTime($start_date);
            $end = new DateTime($input['repeats_date']);
            $interval = DateInterval::createFromDateString($input['repeat_days'] . ' ' . $input['set_repeat']);
            $period_start = new DatePeriod($begin_start, $interval, $end);


            $diff_start_date = new DateTime($start_date);
            $diff_end_date = new DateTime($end_date);
            $interval = date_diff($diff_start_date, $diff_end_date);
            foreach ($period_start as $row) {

                $start = $row->format("Y-m-d H:i");
                $end_date = $row->modify($interval->format($interval->d . ' days ' . $interval->h . ' hours ' . $interval->i . ' minutes'));
                $end = $end_date->format("Y-m-d H:i");

                $stmt_repeat = "INSERT INTO `events`(`event`, `team`, `start`, `end`,`repeat_parent`,`repeat_dif`, `room`, `created_at`) VALUES ('" . $input['event'] . "', '" . $group . "', '" . $start . "', '" . $end . "', '" . $uuid . "','" . $repeat_dif . "', '" . $input['room'] . "', '" . date('Y-m-d\TH:i') . "')";

                $exec_repeat = connect::connection()->prepare($stmt_repeat);
                $exec_repeat->execute();
            }
        }
        return;
    }

    public static function update($input)
    {

        $event = events::find($input['event_id']);
        $id = $event->repeat_parent ? $event->repeat_parent : $event->id;


        if (!isset($input['removed'])) {

            $add_start_1 = new DateTime($input['start_date']);
            $add_start_2 = new DateTime($event->start);
            $interval = date_diff($add_start_2, $add_start_1);
            $start_diff = $interval->format('Ra days Rh hours Ri minutes');


            $add_end_1 = new DateTime($input['end_date']);
            $add_end_2 = new DateTime($event->end);
            $interval = date_diff($add_end_2, $add_end_1);
            $end_diff = $interval->format('Ra days Rh hours Ri minutes');


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
            $start_date = $input['start_date'];
            $end_date = $input['end_date'];

            $stmt = "UPDATE `events` SET 
                            `not_applicable`= NULL,
                            `event`='" . $input['event'] . "',
                            `team`='" . $group . "' ,
                            `start`='" . $start_date . "' ,
                            `end`='" . $end_date . "' ,
                            `room`='" . $input['room'] . "',
                            `updated_at`='" . date('Y-m-d\TH:i') . "' 
                        WHERE id = '" . $event->id . "'";
            $exec = connect::connection()->prepare($stmt)->execute();

            if (!empty($input['repeat_list'])) {
                foreach ($input['repeat_list'] as $row) {

                    $stmt_col = "SELECT * FROM `events` WHERE `id` = '" . $row . "'";
                    $col = connect::connection()->query($stmt_col)->fetchObject();

                    $start_date = date('Y-m-d H:i', strtotime($col->start . ' ' . $start_diff . ''));
                    $end_date = date('Y-m-d H:i', strtotime($col->end . ' ' . $end_diff . ''));

                    $stmt = "UPDATE `events` SET 
                            `not_applicable`= NULL,
                            `event`='" . $input['event'] . "',
                            `team`='" . $group . "' ,
                            `start`='" . $start_date . "' ,
                            `end`='" . $end_date . "' ,
                            `room`='" . $input['room'] . "',
                            `updated_at`='" . date('Y-m-d\TH:i') . "' 
                        WHERE id = '" . $col->id . "'";
                    $exec = connect::connection()->prepare($stmt)->execute();
                }
            }
        }
        if (isset($input['removed'])) {

            $stmt = "UPDATE `events` SET 
                            `not_applicable`= 1,
                            `updated_at`='" . date('Y-m-d\TH:i') . "' 
                        WHERE id = '" . $event->id . "'";

            $exec = connect::connection()->prepare($stmt)->execute();

            if (!empty($input['repeat_list'])) {
                foreach ($input['repeat_list'] as $row) {
                    $stmt = "UPDATE `events` SET 
                            `not_applicable`= 1,
                            `updated_at`='" . date('Y-m-d\TH:i') . "' 
                        WHERE id = '" . $row . "'";
                    $exec = connect::connection()->prepare($stmt)->execute();
                }
            }

            if (!empty($input['repeat_list'])) {
                foreach ($input['repeat_list'] as $row) {
                    $stmt_col = "SELECT * FROM `events` WHERE id = '" . $row . "'";
                    $col = connect::connection()->query($stmt_col)->fetchColumn();

                    if (isset($input['removed'])) {
                        $stmt = "UPDATE `events` SET 
                                            `not_applicable`= 1,
                                            `updated_at`='" . date('Y-m-d\TH:i') . "' 
                                        WHERE id = '" . $row . "'";
                    }
                    if (!isset($input['removed'])) {
                        $stmt = "UPDATE `events` SET 
                                            `not_applicable`= NULL,
                                            `updated_at`='" . date('Y-m-d\TH:i') . "' 
                                        WHERE id = '" . $row . "'";
                    }
                    $exec = connect::connection()->prepare($stmt)->execute();
                }
            }
        }
        return array(true, $input);
    }

    public static function delete($input)
    {
        $event = events::find($input['event_id']);
        $id = $event->repeat_parent ? $event->repeat_parent : $event->id;
        $stmt = "UPDATE `events` SET 
            `deleted_at` = '" .  date('Y-m-d H:i:S') . "',
            `updated_at`='" . date('Y-m-d\TH:i') . "' 
        WHERE id = '" . $id . "'";
        $exec = connect::connection()->prepare($stmt)->execute();

        foreach ($input['repeat_list'] as $row) {

            $stmt = "UPDATE `events` SET 
            `deleted_at` = '" .  date('Y-m-d H:i:S') . "',
            `updated_at`='" . date('Y-m-d\TH:i') . "' 
        WHERE id = '" . $row . "'";

            $exec = connect::connection()->prepare($stmt)->execute();
        }
        return array(true, $input);
    }
}
