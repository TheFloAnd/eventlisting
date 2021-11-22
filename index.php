<?php
use app\controller\events;
use app\controller\group;
use app\controller\config;
use app\module\notification;
use app\module\updates;
use app\module\system;

require __DIR__.'/app/conf/config.php';
require __DIR__.'/init.php';
require __DIR__ . '/app/lang/lang_de.php';
define('lang', $lang['de']);

if(isset($_GET['b'])){
  define('blade',$_GET['b']);
$blade = $_GET['b'];
}else{
  define('blade','main');
}

if(strftime('%H:%M') == '08:00'){
  system::get_updates();
  updates::get_updates();
}

if(isset($_POST['submit_event'])){
  if(!isset($_POST['set_repeat'])){
    events::store($_POST);
    header('Refresh:0');
  }else{
    events::store_repeat($_POST);
    header('Refresh:0');
  }
}

if(isset($_POST['submit_edit_event'])){
  if(isset($_POST['edit_repeat'])){
    $update_event = events::update_repeat($_POST);
  }
  if(!isset($_POST['edit_repeat'])){
    $update_event = events::update($_POST);
  }
  if($update_event['0']){
    //notification::success('Der Termin "'. $update_event['1']['event'] .'" vom '. strftime('%d.%m.%Y', strtotime($update_event['1']['start_date'])) .' bis zum '. strftime('%d.%m.%Y', strtotime($update_event['1']['end_date'])) .' der Gruppe '. $update_event['1']['group'] .' wurde Erfolgreich geändert!');

    // header('Refresh:0');
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
    header('Refresh:0');
  }
}

if(isset($_POST['submit_edit_group'])){
  $update_group = group::update($_POST);
  if($update_group['0'] == true){
    // header('Location:?b=group_edit&g='. $update_group['1']);
    notification::success('Die Gruppe '. $update_group['1'] .' wurde Erfolgreich geändert!');
    header('Refresh:0');
  }
}

if(isset($_POST['submit_edit_setting'])){
  $set_setting = config::update($_POST);
  if($set_setting == true){
    notification::success('Einstellung wurde Erfolgreich geändert!');
  }
}

include __DIR__.'/resources/layout/template.php';
