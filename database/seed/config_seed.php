<?php

namespace database\seed;

use \PDO;
use database\connect;

class config_seed extends connect
{
    public static function index()
    {
        $pdo = connect::admin();
        try {

            $pdo->query(
                "INSERT INTO `config` (
                `id`,
                `view`,
                `setting`,
                `value`,
                `time_unit`,
                `created_at`
            ) VALUES (
                1,
                'Automatisches Neuladen',
                'refresh',
                '15',
                'seconds',
                '" . date('Y-m-d\TH:i') . "'
            ),(
                2,
                'Termin Preview Zeitraum',
                'future_day',
                '30',
                'day',
                '" . date('Y-m-d\TH:i') . "'
            ), (
                3,
                'Überschrift',
                'name',
                '',
                '',
                '" . date('Y-m-d\TH:i') . "'
            ), (
                4,
                'Sprache',
                'language',
                'Deutsch',
                'de_DE',
                '" . date('Y-m-d\TH:i') . "'
            );"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
}
