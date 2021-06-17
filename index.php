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
  $add_group = group::store($_POST);
  if($add_group['0'] == false){
    echo'<div class="alert alert-warning text-center alert-dismissible fade show" role="alert">
            Der Gruppen Alias '. $add_group['1'] .' Existiert schon!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  }else{

    echo'<div class="alert alert-success text-center alert-dismissible fade show" role="alert">
            Der Gruppen Alias '. $add_group['1'] .' wurde Erstellt!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  }
}
require __DIR__.'/resources/layout/template.php';
