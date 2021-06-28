<?php
use app\controller\events;
use app\controller\group;
use app\module\notification;
require './app/controller/events.controller.php';
require './app/controller/group.controller.php';
require './app/lang/lang_de.php';
require './app/module/notification.module.php';

error_reporting(E_ALL);
ini_set("display_errors", 1); 
ini_set('error_reporting', E_ALL);

require __DIR__.'/app/conf/config.php';
require __DIR__.'/app/init.php';

if(isset($_GET['b'])){
  define('blade',$_GET['b']);
}else{
  define('blade','main');
}

if(isset($_POST['submit_event'])){
  events::store($_POST);
}
if(isset($_POST['submit_group'])){
  $add_group = group::store($_POST);
  if($add_group['0'] == false){
    notification::error('Der Gruppen Alias '. $add_group['1'] .' Existiert schon!');
  }else{

    notification::success('Der Gruppen Alias '. $add_group['1'] .' wurde Erstellt!');
  }
}

if(isset($_POST['submit_edit_group'])){
  $update_group = group::update($_POST);
  if($update_group['0'] == true){
    notification::success('Die Gruppe '. $update_group['1'] .' wurde Erfolgreich geändert!');
  }
}
if(isset($_POST['submit_edit_event'])){
  $update_event = events::update($_POST);
  if($update_event['0'] == true){
    notification::success('Der Termin "'. $update_event['1']['event'] .'" vom '. date('d.m.Y', strtotime($update_event['1']['start_date'])) .' bis zum '. date('d.m.Y', strtotime($update_event['1']['end_date'])) .' der Gruppe '. $update_event['1']['group'] .' wurde Erfolgreich geändert!');
  }
}
require __DIR__.'/resources/layout/template.php';
