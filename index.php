<?php
error_reporting(E_ALL);
ini_set("display_errors", 1); 
ini_set('error_reporting', E_ALL);

require __DIR__.'/app/conf/config.php';
// require __DIR__.'/app/init.php';

if(isset($_GET['blade'])){
  define('blade',$_GET['blade']);
}else{
  define('blade','main');
}

require __DIR__.'/resources/layout/template.php';
