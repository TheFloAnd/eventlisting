<?php

require __DIR__.'../../app/conf/config.php';
require __DIR__.'../../app/controller/init.php';

define('database', Database::class);

if(isset($_GET['blade'])){
  define('blade',$_GET['blade']);
}else{
  define('blade','main');
}

require __DIR__.'../../resources/layout/template.php';
