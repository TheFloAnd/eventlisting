<?php

use app\controller\events;
use app\controller\event_repeat;
use app\controller\group;
use app\controller\config;
use app\module\notification;
use database\migrate\events_migrate;
use database\migrate\teams_migrate;

require __DIR__ . '/init.php';

require __DIR__ . '/app/conf/config.php';

if (file_exists(__DIR__ .'/app/locale/'. config::get('language')->value .'.php')) {
  require __DIR__ . '/app/locale/'. config::get('language')->value .'.php';
}else{
  require __DIR__ . '/app/locale/de_DE.php';
}

define('lang', $lang);

// define('lang', $lang[str_split(config::get('language')->value, 2)[0]]);

if (isset($_GET['b'])) {
  define('blade', $_GET['b']);
  $blade = $_GET['b'];
} else {
  define('blade', 'home');
}

if (isset($_POST['submit_event'])) {
  if ($_POST['set_repeat'] == 'none') {
    events::store($_POST);
    header('Refresh:0');
  } else {
    event_repeat::store($_POST);
    // header('Refresh:0');
  }
}

if (isset($_POST['submit_edit_event'])) {
  if (isset($_POST['edit_repeat'])) {
    $update_event = event_repeat::update($_POST);
  }
  if (!isset($_POST['edit_repeat'])) {
    $update_event = events::update($_POST);
  }
  if ($update_event['0']) {
    //notification::success('Der Termin "'. $update_event['1']['event'] .'" vom '. strftime('%d.%m.%Y', strtotime($update_event['1']['start_date'])) .' bis zum '. strftime('%d.%m.%Y', strtotime($update_event['1']['end_date'])) .' der Gruppe '. $update_event['1']['group'] .' wurde Erfolgreich geändert!');

    header('Refresh:0');
  }
}

if (isset($_POST['submit_delete_event'])) {
  if (isset($_POST['delete_repeat'])) {
    event_repeat::delete($_POST);
  } else {
    events::delete($_POST);
  }
  header('location:?b=events');
}

if (isset($_POST['submit_group'])) {
  $add_group = group::store($_POST);
  if ($add_group['0'] == false) {
    notification::error('Der Gruppen Alias ' . $add_group['1'] . ' Existiert schon!');
  } else {
    notification::success('Der Gruppen Alias ' . $add_group['1'] . ' wurde Erstellt!');
    header('Refresh:0');
  }
}

if (isset($_POST['submit_edit_group'])) {
  $update_group = group::update($_POST);
  if ($update_group['0'] == true) {
    // header('Location:?b=group_edit&g='. $update_group['1']);
    notification::success('Die Gruppe ' . $update_group['1'] . ' wurde Erfolgreich geändert!');
    header('Refresh:0');
  }
}

if (isset($_POST['submit_edit_setting'])) {
  $set_setting = config::update($_POST);
  if ($set_setting == true) {
    notification::success('Einstellung wurde Erfolgreich geändert!');
    header('Refresh:0');
  }
}

if (isset($_POST['tabel_renew'])) {

  if (isset($_POST['table_empty'])) {
  switch ($_POST['modal_table_input']) {
    case lang['events']:
      new events_migrate('empty');
      break;
    case lang['groups']:
      new events_migrate('empty');
      new teams_migrate('empty');
      break;
  }
}
if (!isset($_POST['table_empty'])) {
  switch ($_POST['modal_table_input']) {
    case lang['events']:
      new events_migrate('recreate');
      break;
    case lang['groups']:
      new events_migrate('recreate');
      new teams_migrate('recreate');
      break;
  }
}

  header('location:?b=settings');
}

include __DIR__ . '/resources/layout/template.php';
