<?php

namespace app\module;

use database\connect;

class sql
{
/*
*   Gets Proposals
*
*   :return $result
*   :return $group
*   :return $proposals
*   :return $proposals_room
*/
    public static function proposals($col, $table)
    {
        // SQL Statment to select the Proposals for Events
        $stmt = "SELECT `". $col ."`, COUNT(`". $col ."`) as counted FROM `". $table ."` GROUP BY `". $col ."` ORDER BY counted DESC";
        $data = connect::connection()->query($stmt);
        $result = $data->fetchAll();

        return $result;
    }
}
