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
                '" . strftime('%Y-%m-%dT%H:%M') . "'
            ),(
                2,
                'Termin Preview Zeitraum',
                'future_day',
                '30',
                'day',
                '" . strftime('%Y-%m-%dT%H:%M') . "'
            ), (
                3,
                'Überschrift',
                'name',
                '',
                '',
                '" . strftime('%Y-%m-%dT%H:%M') . "'
            ), (
                4,
                'Sprache',
                'language',
                'Deutsch',
                'de_DE',
                '" . strftime('%Y-%m-%dT%H:%M') . "'
            );"
            );
            return;
        } catch (\PDOException $e) {
            echo "PDOException: " . $e->getMessage();
        }
    }
}
