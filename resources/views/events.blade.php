<?php

use app\controller\events;
use app\controller\group;

$events = events::index();
require __DIR__ . '/../layout/navigation.php';
?>
<article class="row">
  <section class="col">
    <div class="card events-card">
      <div class="card-body events-card-body">
        <nav class="events-card-tab">
          <div class="nav nav-tabs justify-content-evenly events-card-tab-items" id="nav-tab" role="tablist">
            <button class="nav-link events-card-tab-item-link col active" id="nav-event_add-tab" data-bs-toggle="tab" data-bs-target="#nav-event_add" type="button" role="tab" aria-controls="nav-event_add" aria-selected="false">
              <?php echo lang['event'] . ' ' .  lang['add'] ?>
            </button>
            <button class="nav-link events-card-tab-item-link col" id="nav-event_edit-tab" data-bs-toggle="tab" data-bs-target="#nav-event_edit" type="button" role="tab" aria-controls="nav-event_edit" aria-selected="true">
              <?php echo lang['events'] . ' ' .  lang['edit'] ?>
            </button>
          </div>
        </nav>
        <div class="tab-content events-card-tab-content" id="myTabContent">
          <div class="tab-pane events-card-tab-content-pane  events-card-tab-content-add fade show active" id="nav-event_add" role="tabpanel" aria-labelledby="nav-event_add-tab">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="needs-validation" novalidate>
              <div class="row mt-3 g-3 justify-content-center">
                <div class="col-md-10">
                  <fieldset>
                    <div class="form-floating has-validation">
                      <input type="text" class="form-control show_length" name="event" id="event" placeholder="<?php echo lang['event'] ?>" list="event_list" maxlength="50" required data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-name'] ?>" />
                      <label for="event">
                        <?php echo lang['event'] ?>
                        <span style="color: red;">
                          *
                        </span>
                        <span id="event_label" class="label"></span>
                      </label>
                      <div class="invalid-feedback">
                        <?php echo lang['invalide-event-input']; ?>
                      </div>
                      <datalist id="event_list">
                        <?php
                        foreach ($events['proposals'] as $row) {
                          echo '<option value="' . $row['event'] . '">';
                        }
                        ?>
                      </datalist>
                    </div>
                  </fieldset>
                </div>
                <div class="col-md-10">
                  <div class="row g-3" id="groups">
                    <div class="col-12">
                      <fieldset>
                        <div class="input-group has-validation">
                          <label for="group">
                            <?php echo lang['group'] ?>
                            <span style="color: red;">
                              *
                            </span>
                          </label>
                          <select class="form-select multiple-select" name="group[]" multiple="multiple" required data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-group'] ?>">
                            <?php

                            foreach ($events['group'] as $row) {
                              echo '<option value="' . $row['alias'] . '">' . $row['name'] . ' (' . $row['alias'] . ')</option>';
                            }
                            ?>
                          </select>
                          <div class="invalid-feedback">
                            <?php echo lang['invalide-group-input']; ?>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                </div>
                <div class="col-md-10">
                  <div class="row">
                    <div class="col-md-4">
                      <fieldset>
                        <div class="form-floating">
                          <input type="text" class="form-control show_length" name="room" id="room" placeholder="<?php echo lang['room'] ?>" list="room_list" maxlength="25" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-room'] ?>">
                          <label for="room">
                            <?php echo lang['room'] ?>

                            <span id="room_label" class="label"></span>
                          </label>
                          <div class="invalid-feedback">
                            <?php echo lang['invalide-room-input']; ?>
                          </div>

                          <datalist id="room_list">
                            <?php
                            foreach ($events['proposals_room'] as $row) {
                              echo '<option value="' . $row['room'] . '">';
                            }
                            ?>
                          </datalist>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <fieldset>
                    <div class="form-floating">
                      <input type="datetime-local" class="form-control" name="start_date" id="start_date" value="<?php echo strftime('%Y-%m-%dT00:00') ?>" required data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-start'] ?>">
                      <label for="start_date">
                        <?php echo lang['start'] . ' ' .  lang['date'] ?>
                        <span style="color: red;">
                          *
                        </span>
                      </label>
                    </div>
                  </fieldset>
                </div>
                <div class="col-md-5">
                  <fieldset>
                    <div class="form-floating">
                      <input type="datetime-local" class="form-control" name="end_date" id="end_date" value="<?php echo strftime('%Y-%m-%dT00:00') ?>" required data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-end'] ?>">
                      <label for="end_date">
                        <?php echo lang['end'] . ' ' .  lang['date'] ?>
                        <span style="color: red;">
                          *
                        </span>
                      </label>
                    </div>
                  </fieldset>
                </div>
                <div class="col-md-10">
                  <fieldset>
                    <div class="form-group was-validated">
                      <div class="form-check form-check-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-repeat-set-none'] ?>">
                        <input class="form-check-input set_repeat" type="radio" name="set_repeat" id="set_repeat_none" value="none" checked>
                        <label class="form-check-label" for="set_repeat_none"><?php echo lang['no-repeat']; ?></label>
                      </div>
                      <div class="form-check form-check-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-repeat-set-days'] ?>">
                        <input class="form-check-input set_repeat" type="radio" name="set_repeat" id="set_repeat_days" value="days">
                        <label class="form-check-label" for="set_repeat_days"><?php echo lang['days']; ?></label>
                      </div>
                      <div class="form-check form-check-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-repeat-set-weeks'] ?>">
                        <input class="form-check-input set_repeat" type="radio" name="set_repeat" id="set_repeat_weeks" value="weeks">
                        <label class="form-check-label" for="set_repeat_weeks"><?php echo lang['weeks']; ?></label>
                      </div>
                    </div>
                  </fieldset>
                </div>
                <div class="col-md-10">
                  <div class="form-group" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-repeat-days'] ?>">
                    <fieldset>
                      <label class="form-label" for="days">
                        <?php echo lang['days'] . '/' . lang['weeks'] ?> :
                      </label>
                      <input class="form-control disable" type="number" placeholder="<?php echo lang['days'] ?>" min="1" name="repeat_days" id="repeat_days" value="1" disabled>
                    </fieldset>
                  </div>
                </div>
                <div class="col-md-10">
                  <div class="row">
                    <div class="col-12">

                  <fieldset>
                    <div class="form-group was-validated">
                      <div class="form-check form-check-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-repeat-set-days'] ?>">
                        <input class="form-check-input set_repeat_time disable" type="radio" name="set_repeat_time" id="set_repeat_time_date" value="date" checked disabled>
                        <label class="form-check-label" for="set_repeat_time_date"><?php echo lang['till']; ?></label>
                      </div>
                      <div class="form-check form-check-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-repeat-set-weeks'] ?>">
                        <input class="form-check-input set_repeat_time disable" type="radio" name="set_repeat_time" id="set_repeat_time_repeats" value="repeats" disabled>
                        <label class="form-check-label" for="set_repeat_time_repeats"><?php echo lang['repeat']; ?></label>
                      </div>
                    </div>
                  </fieldset>
                    </div>
                    <div class="col-md-6">

                      <div class="form-group" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-repeat'] ?>">
                        <fieldset>
                          <label class="form-label" for="repeats">
                            <?php echo lang['till'] ?> :
                          </label>
                          <input class="form-control disable" type="date" placeholder="<?php echo strftime('%Y-%m-%d', strtotime(strftime('%Y-%m-%d') . ' +1 month')) ?>" name="repeats_date" id="repeats_date" value="<?php echo strftime('%Y-%m-%d', strtotime(strftime('%Y-%m-%d') . ' +1 month')) ?>" disabled>
                        </fieldset>
                      </div>
                    </div>
                    <div class="col-md-6">

                      <div class="form-group" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-repeat'] ?>">
                        <fieldset>
                          <label class="form-label" for="repeats">
                            <?php echo lang['repeat'] ?> :
                          </label>
                          <input class="form-control disable" type="number" placeholder="<?php echo lang['repeat'] ?>" min="1" name="repeats_repeats" id="repeats_repeats" value="1" disabled>
                        </fieldset>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="col-8">
                  <div class="form-group">
                    <button type="submit" class="btn btn-outline-success w-100" name="submit_event" value="submit">
                      <?php echo lang['add'] ?>
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane fade" id="nav-event_edit" role="tabpanel" aria-labelledby="nav-event_edit-tab">
            <div class="table-responsive mt-2">
              <div class="my-2">
                <?php echo lang['toggle-column']; ?>:
                <a class="toggle-vis" data-column="2">
                  <?php echo lang['room'] ?>
                </a> -
                <a class="toggle-vis" data-column="5">
                  In
                </a> -
                <a class="toggle-vis" data-column="6">
                  <?php echo lang['settings'] ?>
                </a>
              </div>
              <table class="table dataTable dataTable_default table-striped table-hover" id="refresh_edit">
                <thead>
                  <tr>
                    <th scope="col">
                      <?php echo lang['project'] ?>
                    </th>
                    <th scope="col">
                      <?php echo lang['group'] ?>
                    </th>
                    <th scope="col">
                      <?php echo lang['room'] ?>
                    </th>
                    <th scope="col">
                      <?php echo lang['from'] ?>
                    </th>
                    <th scope="col">
                      <?php echo lang['till'] ?>
                    </th>
                    <th class="no-sort">
                      <?php echo lang['remaining_days'] ?></th>
                    <th class="no-sort"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0;
                  foreach ($events['result'] as $row) {
                    $start = strftime('%Y-%m-%d', strtotime($row['start']));
                    $end = strftime('%Y-%m-%d', strtotime($row['end']));
                    if ($start >= strftime('%Y-%m-%d') or $end >= strftime('%Y-%m-%d')) {
                      if ($row['not_applicable'] == 1) {
                        $disabled = 'class="table-danger strikethrough"';
                      } else {
                        $disabled = '';
                      }
                      echo '<tr ' . $disabled . '>
                        <td class="table_search">
                          ' . $row['event'] . '
                        </td>
                        <td>';
                      $teams = explode(';', $row['team']);

                      foreach ($teams as $team) {
                        $color = GROUP::find($team)->color;
                        echo '<span class="badge text-dark table_search" style="background-color:' . $color . ';">' . $team . '</span> ';
                      }
                      echo '</td>
                        <td class="table_search">
                          ' . $row['room'] . '
                        </td>';
                      if (strftime('%d.%m.%Y', strtotime($row['start'])) != strftime('%d.%m.%Y', strtotime($row['end']))) {
                        if (strftime('%H:%M', strtotime($row['start'])) == '00:00') {
                          echo '<td class="table_search">' . strftime('%d.%m.%Y', strtotime($row['start'])) . '</td>';
                        } else {
                          echo '<td class="table_search">' . strftime('%d.%m.%Y - %H:%M', strtotime($row['start'])) . '</td>';
                        }
                        if (strftime('%H:%M', strtotime($row['end'])) == '00:00') {
                          echo '<td class="table_search">' . strftime('%d.%m.%Y ', strtotime($row['end'])) . '</td>';
                        } else {
                          echo '<td class="table_search">' . strftime('%d.%m.%Y - %H:%M', strtotime($row['end'])) . '</td>';
                        }
                      }
                      if (strftime('%d.%m.%Y', strtotime($row['start'])) == strftime('%d.%m.%Y', strtotime($row['end']))) {
                        if (strftime('%H:%M', strtotime($row['start'])) == strftime('%H:%M', strtotime($row['end']))) {
                          if (strftime('%H:%M', strtotime($row['start'])) == '00:00') {
                            echo '<td colspan="2" class="table_search">' . strftime('%d.%m.%Y ', strtotime($row['start'])) . '</td><td style="display:none;">';
                          } else {
                            echo '<td colspan="2" class="table_search">' . strftime('%d.%m.%Y - %H:%M', strtotime($row['start'])) . '</td><td style="display:none;">';
                          }
                        }
                        if (strftime('%H:%M', strtotime($row['start'])) != strftime('%H:%M', strtotime($row['end']))) {
                          if (strftime('%H:%M', strtotime($row['start'])) == '00:00') {
                            echo '<td class="table_search">' . strftime('%d.%m.%Y', strtotime($row['start'])) . '</td>';
                          } else {
                            echo '<td class="table_search">' . strftime('%d.%m.%Y - %H:%M', strtotime($row['start'])) . '</td>';
                          }
                          if (strftime('%H:%M', strtotime($row['end'])) == '00:00') {
                            echo '<td class="table_search">' . strftime('%d.%m.%Y', strtotime($row['end'])) . '</td>';
                          } else {
                            echo '<td class="table_search">' . strftime('%H:%M', strtotime($row['end'])) . '</td>';
                          }
                        }
                      }
                      echo '<td class="table_search">' . abs(strtotime(strftime('%Y-%m-%d', strtotime($row['start']))) - strtotime(strftime('%Y-%m-%d'))) / 60 / 60 / 24 . ' ' . lang['meet'] . '</td>';
                      echo '<td data-bs-toggle="tooltip" data-bs-placement="top" title="' . lang['edit'] . '"><a href="?b=events_edit&id=' . $row['id'] . '" type="button" class="btn btn-sm btn-secondary position-relative"><i class="bi bi-gear-wide"></i></a></td>';
                    }
                  }
                  echo '</tr>';
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</article>

<script>
  var set_repeat = document.getElementsByName('set_repeat');
  var set_repeat_time = document.getElementsByName('set_repeat_time');
  var set_disable = document.getElementById('set_repeat_none');
  var disable = document.getElementsByClassName('disable');
  set_disable.checked = true;
  for (i = 0; i < set_repeat.length; i++) {
    set_repeat[i].onclick = function() {
      switch (this.value) {
        case 'weeks':
          for (j = 0; j < disable.length; j++) {
            disable[j].disabled = false;
          }
          break;
        case 'days':
          for (j = 0; j < disable.length; j++) {
            disable[j].disabled = false;
          }
          break;
        case 'none':
          for (j = 0; j < disable.length; j++) {
            disable[j].disabled = true;
          }
          break;
      }

    }
  }
</script>
<script>
  var start_date = document.getElementById("start_date");
  var end_date = document.getElementById("end_date");

  start_date.onchange = function() {
    if (start_date.value > end_date.value) {
      end_date.value = start_date.value
    }
    if (!end_date.value) {
      end_date.value = start_date.value
    }
  };
  end_date.onchange = function() {
    if (end_date.value < start_date.value) {
      start_date.value = end_date.value
    }
    if (!start_date.value) {
      start_date.value = end_date.value
    }
  };
</script>