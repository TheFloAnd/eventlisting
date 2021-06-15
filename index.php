<?php
use app\controller\events;
use app\controller\group;
require './app/controller/events.controller.php';
require './app/controller/group.controller.php';

error_reporting(E_ALL);
ini_set("display_errors", 1); 
ini_set('error_reporting', E_ALL);

require __DIR__.'/app/conf/config.php';
require_once __DIR__.'/app/init.php';

if(isset($_GET['b'])){
  define('blade',$_GET['b']);
}else{
  define('blade','main');
}

if(isset($_POST['submit_event'])){
  events::store($_POST);
}
if(isset($_POST['submit_group'])){
  group::store($_POST);
}
require __DIR__.'/resources/layout/template.php';
