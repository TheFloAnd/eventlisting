<?php
use app\controller\events;
use app\controller\group;
use app\controller\config;
use app\module\notification;
use app\module\updates;
use app\module\system;

use app\module\route;
include __DIR__ ."/resources/lib/BladeOne.php";
use eftec\bladeone;

require __DIR__.'/app/conf/config.php';
require __DIR__.'/init.php';
require __DIR__ . '/app/lang/lang_de.php';
define('lang', $lang['de']);

if(isset($_GET['b'])){
  define('blade',$_GET['b']);
$blade = $_GET['b'];
}else{
  define('blade','main');
$blade = 'main';
}

$views = __DIR__ . '/resources/views'; // it uses the folder /views to read the templates
$cache = __DIR__ . '/resources/cache'; // it uses the folder /cache to compile the result. 
$blade = new bladeone\BladeOne($views,$cache,bladeone\BladeOne::MODE_AUTO);

  echo $blade->run("layout.template", array("blade"=>$blade));

// route::add('/', function() {
//   define('blade','main');
//   $blade = 'main';
// });

if(strftime('%H:%M') == '08:00'){
  system::get_updates();
  updates::get_updates();
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
    //notification::success('Der Termin "'. $update_event['1']['event'] .'" vom '. strftime('%d.%m.%Y', strtotime($update_event['1']['start_date'])) .' bis zum '. strftime('%d.%m.%Y', strtotime($update_event['1']['end_date'])) .' der Gruppe '. $update_event['1']['group'] .' wurde Erfolgreich geändert!');
  }
}

if(isset($_POST['submit_delete_event'])){
  if(isset($_POST['delete_repeat'])){
    events::delete_repeat($_POST);
  }else{
    events::delete($_POST);
  }
    header('Location: ?b=events');
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

// include __DIR__.'/resources/views/layout/template.blade.php';