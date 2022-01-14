<?php

use app\controller\events;
use app\controller\event_repeat;
use app\controller\group;
use app\controller\config;
use app\controller\auth\protection;
use app\module\notification;
use database\migrate\events_migrate;
use database\migrate\teams_migrate;

// Loads classes and includes them
require __DIR__ . '/init.php';

// config file
require __DIR__ . '/app/conf/config.php';

// Checks if Language file exists and if not reuires a default
if (file_exists(__DIR__ . '/app/locale/' . config::get('language')->value . '.php')) {
  // requires language file
  require __DIR__ . '/app/locale/' . config::get('language')->value . '.php';
} else {
  // requires default language file
  require __DIR__ . '/app/locale/de_DE.php';
}

// Sets language as constante
define('lang', $lang);

// define('lang', $lang[str_split(config::get('language')->value, 2)[0]]);

// Checks if a page is set
if (isset($_GET['b'])) {
  define('view', $_GET['b']);
  $view = $_GET['b'];
} else {
  // sets dault view
  define('view', 'home');
}

// Checks if a new Event is stored
if (isset($_POST['submit_event'])) {
  if ($_POST['set_repeat'] == 'none') {
    events::store($_POST);
    header('Refresh:0');
  } else {
    // Stores folloing events
    event_repeat::store($_POST);
    header('Refresh:0');
  }
}
// checks if a event is edited
if (isset($_POST['submit_edit_event'])) {

  // updates a singe event
  if (!isset($_POST['edit_repeat'])) {
    $update_event = events::update($_POST);
  }

  // checks if the folloing events are edited too
  if (isset($_POST['edit_repeat'])) {
    $update_event = event_repeat::update($_POST);
  }

  // checks if the update was a succsess
  if ($update_event['0']) {
    //notification::success('Der Termin "'. $update_event['1']['event'] .'" vom '. strftime('%d.%m.%Y', strtotime($update_event['1']['start_date'])) .' bis zum '. strftime('%d.%m.%Y', strtotime($update_event['1']['end_date'])) .' der Gruppe '. $update_event['1']['group'] .' wurde Erfolgreich geändert!');

    header('Refresh:0');
  }
}

// checks if a event is being deleted
if (isset($_POST['submit_delete_event'])) {

  // Deletes a singe event
  if (!isset($_POST['delete_repeat'])) {
    events::delete($_POST);
  }

  // checks if the folloing events are deleted too
  if (isset($_POST['delete_repeat'])) {
    event_repeat::delete($_POST);
  }
  header('location:?b=events');
}

// checks if a group is being added
if (isset($_POST['submit_group'])) {
  $add_group = group::store($_POST);

  // checks if a group alias already exists
  if ($add_group['0'] == false) {
    notification::error('Der Gruppen Alias ' . $add_group['1'] . ' Existiert schon!');
  } else {
    notification::success('Der Gruppen Alias ' . $add_group['1'] . ' wurde Erstellt!');
    header('Refresh:0');
  }
}

// checks if a group is being edited
if (isset($_POST['submit_edit_group'])) {
  $update_group = group::update($_POST);

  // checks if the editing was successfull
  if ($update_group['0'] == true) {
    notification::success('Die Gruppe ' . $update_group['1'] . ' wurde Erfolgreich geändert!');
    header('Refresh:0');
  }
}

// checks if a setting is being edited
if (isset($_POST['submit_edit_setting'])) {
  $set_setting = config::update($_POST);

  // checks if the editing was successfull
  if ($set_setting == true) {
    notification::success('Einstellung wurde Erfolgreich geändert!');
    header('Refresh:0');
  }
}

if (isset($_POST['table_backup'])) {
  $m = shell_exec('./backup');
  header('Refresh:0');
}
// Checks if the DB should be renewed
if (isset($_POST['tabel_renew'])) {
  if (protection::password($_POST['protection_pass'])) {
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
    // Checks if the DB should be emptied
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
}

// includes the Template view
include __DIR__ . '/resources/layout/template.php';
