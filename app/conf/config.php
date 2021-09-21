<?php
/*
 * Datenbank
 */

define("db", array(
    "host" => "localhost",
    "user" => "events",
    "password" => "admin",
    "database" => "listing.loc",
));

/*
 * Server path
 */

$path = $_SERVER['REQUEST_URI'];
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

define("path", array(
    "URI" => $path,
    "root" => $root
));
