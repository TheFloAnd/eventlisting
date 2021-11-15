<?php

/*
 * Datenbank
 */

define("db", array(
    "host" => "localhost",
    "user" => "events",
    "password" => "",
    "database" => "events",
));

/*
* Settings
*/

error_reporting(E_ALL);
ini_set("display_errors", 1); 
ini_set('error_reporting', E_ALL);

/*
* Language
*/

setlocale(LC_ALL, 'de_DE.utf8');

// require __DIR__ . '/app/lang/lang_de.php';
// define('lang', $lang['de']);

/*
* Time
*/
date_default_timezone_set(date_default_timezone_get());

/*
 * Server path
 */

$path = $_SERVER['REQUEST_URI'];
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

define("path", array(
    "URI" => $path,
    "root" => $root
));
