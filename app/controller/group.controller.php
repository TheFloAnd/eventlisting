<?php

namespace app\controller;

use database\connect;
use \PDO;

class group
{

    public static function index()
    {

        $stmt_active = "SELECT * FROM `v_teams` WHERE `deleted_at` IS NULL ORDER BY `name` ASC";
        $data_active = connect::connection()->query($stmt_active);
        $active = $data_active->fetchAll();

        $stmt_inactive = "SELECT * FROM `v_teams` WHERE `deleted_at` IS NOT NULL ORDER BY `name` ASC";
        $data_inactive = connect::connection()->query($stmt_inactive);
        $inactive = $data_inactive->fetchAll();

        return compact('active', 'inactive');
    }

    public static function store($input)
    {
        $alias = GROUP::find($input['group_alias']);
        if (!$alias) {

            $stmt = "INSERT INTO `teams`(`name`, `alias`, `color`, `created_at`) VALUES ('" . $input['group_name'] . "', '" . $input['group_alias'] . "', '" . $input['group_color'] . "', '" . date('Y-m-d H:i') . "')";

            $exec = connect::connection()->prepare($stmt);
            $exec->execute();
            return array(true, $input['group_alias']);
        } else {
            return array(false, $alias->alias);
        }
    }

    public static function find($group)
    {

        $stmt = "SELECT * FROM `v_teams` where alias = '" . $group . "' LIMIT 1";

        $data = connect::connection()->query($stmt);
        // $result = $data->fetch();

        return $data->fetchObject();
    }
    public static function update($group)
    {
        if (isset($group['deactivate_group'])) {
            $stmt = "UPDATE `teams` SET `name`='" . $group['group_name'] . "',`color`='" . $group['group_color'] . "',`deleted_at`= NULL, `updated_at`='" . date('Y-m-d H:i') . "' WHERE alias = '" . $group['alias'] . "' AND id = '" . $group['id'] . "'";
        } else {
            $stmt = "UPDATE `teams` SET `deleted_at`='" . date('Y-m-d H:i') . "', `updated_at`='" . date('Y-m-d H:i') . "' WHERE alias = '" . $group['alias'] . "' AND id = '" . $group['id'] . "'";
        }

        $exec = connect::connection()->prepare($stmt);
        $exec->execute();

        return array(true, $group['alias']);
    }
}
