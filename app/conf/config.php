<?php
/*
 * Datenbank
 */

define("db", array(
    "host" => "localhost",
    "user" => "event_listing.loc",
    "password" => "admin",
    "database" => "event_listing.loc",
));

/*
* Settings
*/
// setlocale(LC_ALL, 'de_DE');
/*
 * Server path
 */

$path = $_SERVER['REQUEST_URI'];
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

define("path", array(
    "URI" => $path,
    "root" => $root
));
