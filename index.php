<?php
use app\controller\events;
use app\controller\group;
use app\controller\config;
use app\module\notification;
use app\module\updates;
use app\module\system;

require __DIR__.'/app/conf/config.php';
require __DIR__.'/init.php';

require './app/lang/lang_de.php';

error_reporting(E_ALL);
ini_set("display_errors", 1); 
ini_set('error_reporting', E_ALL);

date_default_timezone_set(date_default_timezone_get());

setlocale(LC_ALL, 'de_DE.utf8') or die('Locale not installed');

if(strftime('%a - %H') == 'Mo - 08'){
  system::get_updates();
  updates::get_updates();
}


if(isset($_GET['b'])){
  define('blade',$_GET['b']);
}else{
  define('blade','main');
}

if(isset($_POST['submit_event'])){
  if(!isset($_POST['set_repeat'])){
    events::store($_POST);
  }else{
    events::store_repeat($_POST);
  }
}

if(isset($_POST['submit_edit_event'])){
  $update_event = events::update($_POST);
  if($update_event['0']){
    //notification::success('Der Termin "'. $update_event['1']['event'] .'" vom '. date('d.m.Y', strtotime($update_event['1']['start_date'])) .' bis zum '. date('d.m.Y', strtotime($update_event['1']['end_date'])) .' der Gruppe '. $update_event['1']['group'] .' wurde Erfolgreich geändert!');
  }
}

if(isset($_POST['submit_delete_event'])){
  if(isset($_POST['delete_repeat'])){
    events::delete_repeat($_POST);
  }else{
    events::delete($_POST);
  }
    header('location:?b=events');
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

if(isset($_POST['submit_edit_setting'])){
  $set_setting = config::update($_POST);
  if($set_setting == true){
    notification::success('Einstellung wurde Erfolgreich geändert!');
  }
}
require __DIR__.'/resources/layout/template.php';
