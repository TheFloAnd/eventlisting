<?php

namespace app\controller;

use database\connect;
use app\controller\auth\protection;

class config
{

    public static function index()
    {
        $stmt = "SELECT * FROM `config`";
        $data = connect::connection()->query($stmt);
        // $result = $data->fetchAll();
        return $data->fetchAll();
    }
    public static function find($id)
    {
        $stmt = "SELECT * FROM `config` where id = '" . $id . "' LIMIT 1";
        $data = connect::connection()->query($stmt);
        // $result = $data->fetch();
        return $data->fetchObject();
    }
    public static function get($setting)
    {
        $stmt = "SELECT `value`, `time_unit` FROM `config` where `setting` = '" . $setting . "'";
        $data = connect::connection()->query($stmt);
        return $data->fetchObject();
    }

    public static function update($setting)
    {
        $setting_value = $setting['setting_value'];
        if ($setting['setting'] == 'protection') {
            if(!protection::password($setting['protection_pass'])){
                return false;
            }
            if(!protection::change($setting['setting_value'], $setting['setting_value_2'])){
                return false;
            }

            $setting_value = hash('sha512', $setting['setting_value']);
        }


        if ($setting['setting_id'] == '2') {
            $stmt = "UPDATE `config` SET `value` = '" . $setting_value . "', `time_unit` = '" . $setting['time_unit'] . "', `updated_at`='" . date('Y-m-d\TH:i') . "' where `id` = '" . $setting['setting_id'] . "'";
        } else {
            $stmt = "UPDATE `config` SET `value` = '" . $setting_value . "', `updated_at`='" . date('Y-m-d\TH:i') . "' where `id` = '" . $setting['setting_id'] . "'";
        }
        $exec = connect::connection()->prepare($stmt);
        $exec->execute();
        return true;
    }

    public static function language()
    {
        $stmt = "SELECT * FROM `language`";
        $data = connect::connection()->query($stmt);
        return $data->fetchAll();
    }
    public static function get_language($lang_code)
    {
        $stmt = "SELECT * FROM `language` where `code` = '" . $lang_code . "'";
        $data = connect::connection()->query($stmt);
        return $data->fetchObject();
    }
}
