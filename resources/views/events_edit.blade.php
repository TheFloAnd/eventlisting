<?php

use app\controller\events;
use app\controller\group;

$data = events::edit($_GET['id']);

$current_group = group::find($data['result']->team);
require __DIR__ . '/../layout/navigation.php';


if ($data['result']->not_applicable == 1) {
    $checked = 'checked';
    $disabled = 'disabled readonly';
} else {
    $checked = '';
    $disabled = '';
}

?>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="needs-validation" novalidate>
    <article class="row g-3">
        <section class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3 justify-content-center">
                        <fieldset class="" hidden>
                            <div class="form-group">
                                <input type="text" class="form-control" name="event_id" id="event_id" value="<?php echo $data['result']->id ?>">
                            </div>
                        </fieldset>
                        <div class="col-md-10">
                            <fieldset id="fieldset_remove">
                                <div class="form-check form-switch">
                                    <input class="form-check-input set_disable" type="checkbox" value="1" name="removed" id="removed" <?php echo $checked ?> data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-disable'] ?>" set_disable>
                                    <label class="form-check-label" for="removed">
                                        <?php echo lang['not_applicable'] ?>
                                    </label>
                                </div>
                            </fieldset>

                        </div>
                        <div class="col-md-10">
                            <fieldset>
                                <div class="form-floating has-validation">
                                    <input type="text" class="form-control disable show_length" name="event" id="event" placeholder="<?php echo $data['result']->event ?:  lang['event'] ?>" value="<?php echo $data['result']->event ?>" list="event_list" required data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-name'] ?>" maxlength="100" <?php echo$disabled; ?>>
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

                                        foreach ($data['proposals'] as $row) {
                                            echo '<option value="' . $row['event'] . '">';
                                        }
                                        ?>
                                    </datalist>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-7">

                            <fieldset>
                                <div class="input-group">
                                    <label for="group">
                                        <?php echo lang['group'] ?>
                                        <span style="color: red;">
                                            *
                                        </span>
                                    </label>
                                    <select class="form-select multiple-select disable" name="group[]" multiple="multiple" required data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-group'] ?>"<?php echo$disabled; ?>>
                                        <?php
                                        $teams = explode(';', $data['result']->team);
                                        foreach ($data['group'] as $row) {
                                            if (in_array($row['alias'], $teams)) {
                                                echo '<option value="' . $row['alias'] . '" selected>' . $row['name'] . ' (' . $row['alias'] . ')</option>';
                                            } else {
                                                echo '<option value="' . $row['alias'] . '">' . $row['name'] . ' (' . $row['alias'] . ')</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo lang['invalide-group-input']; ?>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-3">
                            <fieldset>
                                <div class="form-floating">
                                    <input type="text" class="form-control disable show_length" name="room" id="room" placeholder="<?php echo $data['result']->room ?:  lang['room'] ?>" value="<?php echo $data['result']->room ?>" maxlength="25" list="room_list" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-room'] ?>"<?php echo$disabled; ?>>
                                    <label for="room">
                                        <?php echo lang['room'] ?>
                                        <span id="room_label" class="label"></span>
                                    </label>
                                    <div class="invalid-feedback">
                                        <?php echo lang['invalide-room-input']; ?>
                                    </div>
                                    <datalist id="room_list">
                                        <?php
                                        foreach ($data['proposals_room'] as $row) {
                                            echo '<option value="' . $row['room'] . '">';
                                        }
                                        ?>
                                    </datalist>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-5">
                            <fieldset>
                                <div class="form-floating">
                                    <input type="datetime-local" class="form-control disable" name="start_date" id="start_date" value="<?php echo strftime('%Y-%m-%dT%H:%M', strtotime($data['result']->start)) ?>" required data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-start'] ?>"<?php echo$disabled; ?>>
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
                                    <input type="datetime-local" class="form-control disable" name="end_date" id="end_date" value="<?php echo strftime('%Y-%m-%dT%H:%M', strtotime($data['result']->end)) ?>" required data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-end'] ?>"<?php echo$disabled; ?>>
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
                            <div class="row g-2 justify-content-evenly">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-outline-success w-100" name="submit_edit_event" data-bs-toggle="modal" data-bs-target="#editModal">
                                            <?php echo lang['update'] ?>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <?php echo lang['delete'] ?>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <a type="button" class="btn btn-outline-secondary w-100" href="?b=events">
                                            <?php echo lang['back'] ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
        if (!empty($data['result']->repeat) || !empty($data['result']->repeat_parent)) {
        ?>
            <section class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row g-3 justify-content-center">
                            <?php
                            echo '<div class="col-12">
                            <fieldset>
                                <div class="form-group">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="edit_repeat" id="edit_repeat" data-toggle="toggle" autocomplete="off" data-bs-toggle="tooltip" data-bs-placement="top" title="' . lang['tooltip-event-repeat-update'] . '">
                                        <label class="form-check-label" for="edit_repeat">
                                            ' . lang['updat'] . ' ' . lang['repeats'] . '?
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-8 d-none">
                            <div class="form-floating">
                                <fieldset>
                                    <div class="form-floating has-validation">
                                        <input class="form-control" type="number" placeholder="' . lang['days'] . '" min="1" name="repeat_days" id="repeat_days" value="' . $data['result']->repeat_dif . '" disabled data-bs-toggle="tooltip" data-bs-placement="top" title="' . lang['tooltip-event-repeat-days'] . '">
                                            <label class="form-label" for="days">
                                                ' . lang['days'] . ' :
                                            </label>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-12 d-none" id="selectAll-col">
                            <fieldset>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input events-edit-card-future-table-body-check-selectAll " type="checkbox" name="edit_repeat-selectAll" id="edit_repeat-selectAll" data-toggle="toggle" autocomplete="off" data-bs-toggle="tooltip" data-bs-placement="top" title="' . lang['tooltip-event-repeat-update'] . '">
                                        <label class="form-check-label" for="edit_repeat">
                                            ' . lang['select_all'] . '
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>';
                            ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped future_events">
                                <thead>
                                    <tr>
                                        <th scope="col" id="select_switch" class="d-none">-</th>
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
                                        <th scope="col">
                                            <?php echo lang['remaining_days'] ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($data['future_events'] as $row) {
                                        $start = strftime('%Y-%m-%d', strtotime($row['start']));
                                        $end = strftime('%Y-%m-%d', strtotime($row['end']));
                                        if ($start >= strftime($data['result']->start, strtotime('+ 1 day'))) {
                                            if ($row['not_applicable'] == 1) {
                                                $disabled = 'class="table-danger strikethrough"';
                                            } else {
                                                $disabled = '';
                                            }

                                            echo '
              <tr ' . $disabled . '>
                <td class="events-edit-card-future-table-body-check d-none">
                    
                            <fieldset>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input events-edit-card-future-table-body-check-switch" type="checkbox" name="repeat_list[]" id="repeat_list" value="' . $row['id'] . '" data-toggle="toggle" autocomplete="off">
                                    </div>
                                </div>
                            </fieldset>
                </td>
                <td>' . $row['event'] . '</td>
                <td>';

                                            $teams = explode(';', $row['team']);

                                            foreach ($teams as $team) {
                                                $group_color = GROUP::find($team)->color;
                                                echo '<span class="badge text-dark" style="background-color:' . $group_color . ';">' . $team . '</span> ';
                                            }

                                            echo '</td>
                <td>' . $row['room'] . '</td>';

                                            if (strftime('%d.%m.%Y', strtotime($row['start'])) != strftime('%d.%m.%Y', strtotime($row['end']))) {

                                                if (strftime('%H:%M', strtotime($row['start'])) == '00:00') {
                                                    echo '<td>' . strftime('%a - %d.%m.%Y', strtotime($row['start'])) . '</td>';
                                                } else {
                                                    echo '<td>' . strftime('%a - %d.%m.%Y - %H:%M', strtotime($row['start'])) . '</td>';
                                                }
                                                if (strftime('%H:%M', strtotime($row['end'])) == '00:00') {
                                                    echo '<td>' . strftime('%a - %d.%m.%Y ', strtotime($row['end'])) . '</td>';
                                                } else {
                                                    echo '<td>' . strftime('%a - %d.%m.%Y - %H:%M', strtotime($row['end'])) . '</td>';
                                                }
                                            }
                                            if (strftime('%d.%m.%Y', strtotime($row['start'])) == strftime('%d.%m.%Y', strtotime($row['end']))) {
                                                if (strftime('%H:%M', strtotime($row['start'])) == strftime('%H:%M', strtotime($row['end']))) {

                                                    if (strftime('%H:%M', strtotime($row['start'])) == '00:00') {
                                                        echo '<td colspan="2">' . strftime('%a - %d.%m.%Y ', strtotime($row['start'])) . '</td>
                          <td style="display:none;">';
                                                    } else {
                                                        echo '
                          <td colspan="2">' . strftime('%a - %d.%m.%Y - %H:%M', strtotime($row['start'])) . '</td>
                          <td style="display:none;">';
                                                    }
                                                }
                                                if (strftime('%H:%M', strtotime($row['start'])) != strftime('%H:%M', strtotime($row['end']))) {
                                                    if (strftime('%H:%M', strtotime($row['start'])) == '00:00') {
                                                        echo '
                          <td>' . strftime('%a - %d.%m.%Y', strtotime($row['start'])) . '</td>';
                                                    } else {
                                                        echo '<td>' . strftime('%a - %d.%m.%Y - %H:%M', strtotime($row['start'])) . '</td>';
                                                    }
                                                    if (strftime('%H:%M', strtotime($row['end'])) == '00:00') {
                                                        echo '<td>' . strftime('%a - %d.%m.%Y', strtotime($row['end'])) . '</td>';
                                                    } else {
                                                        echo '<td>' . strftime('%a - %H:%M', strtotime($row['end'])) . '</td>';
                                                    }
                                                }
                                            }

                                            echo '<td data-bs-toggle="tooltip" data-bs-placement="top" title="' . lang['edit'] . '"><a href="?b=events_edit&id=' . $row['id'] . '" type="button" class="btn btn-sm btn-secondary position-relative"><i class="bi bi-gear-wide"></i></a></td>
              </tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        <?php } ?>
    </article>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <?php echo lang['delete'] ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <fieldset class="" hidden>
                        <div class="form-group">
                            <input type="text" class="form-control" name="event_id" id="event_id" value="<?php echo $data['result']->id ?>">
                        </div>
                    </fieldset>
                    <p>Wollen die den Termin wirklich Löschen?</p>
                    <?php
                    if (!empty($data['result']->repeat) || !empty($data['result']->repeat_parent)) {
                        echo '<fieldset>
                        <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="delete_repeat" id="delete_repeat">
                                    <label class="form-check-label" for="delete_repeat">
                                    ' . lang['repeats'] . ' ' . lang['delete'] . '?
                                    </label>
                                </div>
    </fieldset>';
                    }

                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <?php echo lang['close'] ?>
                    </button>
                    <button type="submit" class="btn btn-danger" name="submit_delete_event">
                        <?php echo lang['delete'] ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <?php echo lang['delete'] ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="modal-body">

                    <fieldset class="" hidden>
                        <div class="form-group">
                            <input type="text" class="form-control" name="event_id" id="event_id" value="<?php echo $data['result']->id ?>">
                        </div>
                    </fieldset>
                    <p>Wollen die den Termin wirklich Löschen?</p>
                    <?php
                    if (!empty($data['result']->repeat) || !empty($data['result']->repeat_parent)) {
                        echo '<fieldset>
                        <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" value="1" name="delete_repeat" id="delete_repeat">
                                    <label class="form-check-label" for="delete_repeat">
                                    ' . lang['repeats'] . ' ' . lang['delete'] . '?
                                    </label>
                                </div>
    </fieldset>';
                    }

                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <?php echo lang['close'] ?>
                    </button>
                    <button type="submit" class="btn btn-danger" name="submit_delete_event">
                        <?php echo lang['delete'] ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var removed = document.getElementById('removed');
    var edit_repeat = document.getElementById('edit_repeat');
    var set_repeat = document.getElementById('repeat_days');
    var check_switch_row = document.getElementsByClassName('events-edit-card-future-table-body-check');
    var check_switch = document.getElementsByClassName('events-edit-card-future-table-body-check-switch');
    var select_switch = document.getElementById('select_switch');
    var selectAll_switch_col = document.getElementById('selectAll-col');
    var selectAll_switch = document.getElementById('edit_repeat-selectAll');

    function enable_select() {

        set_repeat.disabled = false;
        select_switch.classList.add('d-table-cell');
        select_switch.classList.remove('d-none');
        selectAll_switch_col.classList.add('d-block');
        selectAll_switch_col.classList.remove('d-none');
        for (var i = 0; i < check_switch_row.length; i++) {
            check_switch_row[i].classList.add('d-table-cell');
            check_switch_row[i].classList.remove('d-none');
        };
    };

    function disable_select() {

        set_repeat.disabled = true;
        select_switch.classList.add('d-none');
        select_switch.classList.remove('d-table-cell');
        selectAll_switch_col.classList.add('d-none');
        selectAll_switch_col.classList.remove('d-block');
        for (var i = 0; i < check_switch_row.length; i++) {
            check_switch_row[i].classList.add('d-none');
            check_switch_row[i].classList.remove('d-table-cell');
        };
    };

    edit_repeat.checked = false;
    set_repeat.disabled = true;

    edit_repeat.addEventListener("change", function(event) {
        if (edit_repeat.checked) {
            enable_select();
        };
        if (!edit_repeat.checked) {
            disable_select();
        };
    });

    selectAll_switch.addEventListener("change", function(event) {
        if (selectAll_switch.checked) {
            for (var i = 0; i < check_switch.length; i++) {
                check_switch[i].checked = true;
            }
        }
        if (!selectAll_switch.checked) {
            for (var i = 0; i < check_switch.length; i++) {
                check_switch[i].checked = false;
            }
        }
    });
</script>