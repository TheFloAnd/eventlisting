<?php

use app\controller\events;
use app\controller\group;

$data = events::edit($_GET['id']);

$current_group = group::find($data['result']->team);
require __DIR__ . '/../layout/navigation.php';
?>
<article class="row">
    <section class="col">
        <div class="card">
            <div class="card-body">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="needs-validation" novalidate>
                    <div class="row mt-3 g-3 justify-content-center">
                        <fieldset class="" hidden>
                            <div class="form-group">
                                <input type="text" class="form-control" name="event_id" id="event_id" value="<?php echo $data['result']->id ?>">
                            </div>
                        </fieldset>
                        <div class="col-md-10">
                            <fieldset id="fieldset_remove">
                                <div class="form-check form-switch">
                                    <?php
                                    if ($data['result']->not_applicable == 1) {
                                        $checked = 'checked';
                                    } else {
                                        $checked = '';
                                    }

                                    ?>
                                    <input class="form-check-input" type="checkbox" value="1" name="removed" id="removed" <?php echo $checked ?> data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-disable'] ?>">
                                    <label class="form-check-label" for="removed">
                                        <?php echo lang['not_applicable'] ?>
                                    </label>
                                </div>
                            </fieldset>

                        </div>
                        <div class="col-md-10">
                            <fieldset>
                                <div class="form-floating has-validation">
                                    <input type="text" class="form-control disable" name="event" id="event" placeholder="<?php echo $data['result']->event ?:  lang['event'] ?>" value="<?php echo $data['result']->event ?>" list="event_list" required data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-name'] ?>">
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
                                    <select class="form-select multiple-select disable" name="group[]" multiple="multiple" required data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-group'] ?>">
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
                                    <input type="text" class="form-control disable" name="room" id="room" placeholder="<?php echo $data['result']->room ?:  lang['room'] ?>" value="<?php echo $data['result']->room ?>" maxlength="25" list="room_list" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-room'] ?>">
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
                                    <input type="datetime-local" class="form-control disable" name="start_date" id="start_date" value="<?php echo strftime('%Y-%m-%dT%H:%M', strtotime($data['result']->start)) ?>" required data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-start'] ?>">
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
                                    <input type="datetime-local" class="form-control disable" name="end_date" id="end_date" value="<?php echo strftime('%Y-%m-%dT%H:%M', strtotime($data['result']->end)) ?>" required data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang['tooltip-event-end'] ?>">
                                    <label for="end_date">
                                        <?php echo lang['end'] . ' ' .  lang['date'] ?>
                                        <span style="color: red;">
                                            *
                                        </span>
                                    </label>
                                </div>
                            </fieldset>
                        </div>


                        <?php
                        if (!empty($data['result']->repeat) || !empty($data['result']->repeat_parent)) {
                            echo '<div class="col-md-10"><fieldset>
    <div class="form-group">
        <div class="form-check form-switch">
            <input class="form-check-input disable" type="checkbox" name="edit_repeat" id="edit_repeat" data-toggle="toggle"
                autocomplete="off" data-bs-toggle="tooltip" data-bs-placement="top" title="'. lang['tooltip-event-repeat-update'] .'">
            <label class="form-check-label" for="edit_repeat">
                ' . lang['updat'] . ' ' . lang['repeat'] . '?
            </label>
        </div>
    </div>
</fieldset>
</div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <fieldset>
                                    <label class="form-label" for="days">
                                        ' . lang['days'] . ' :
                                    </label>
                                    <input class="form-control" type="number" placeholder="' . lang['days'] . '" min="1" name="repeat_days" id="repeat_days" value="' . $data['result']->repeat_dif . '" disabled data-bs-toggle="tooltip" data-bs-placement="top" title="'. lang['tooltip-event-repeat-days'] .'">
                                </fieldset>
                            </div>
                        </div>';
                        }
                        ?>


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
                </form>
            </div>
        </div>
    </section>
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
                                    ' . lang['repeat'] . ' ' . lang['delete'] . '?
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
    var toogle_disable = document.getElementById('removed');
    var disable = document.getElementsByClassName('disable');
    if (toogle_disable.checked == true) {
        for (var i = 0; i < disable.length; i++) {
            disable[i].disabled = true;
            disable[i].readOnly = true;
        }
    }
    toogle_disable.onchange = function() {
        if (toogle_disable.checked == true) {
            for (var i = 0; i < disable.length; i++) {
                disable[i].disabled = true;
                disable[i].readOnly = true;
            }
        } else {
            for (var i = 0; i < disable.length; i++) {
                disable[i].disabled = false;
                disable[i].readOnly = false;
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
<script>
    var edit_repeat = document.getElementById('edit_repeat');
    var set_repeat = document.getElementById('repeat_days');
    edit_repeat.checked = false;
    set_repeat.disabled = true;
    edit_repeat.onchange = function() {
        if (edit_repeat.checked == true) {
            set_repeat.disabled = false;
        } else {
            set_repeat.disabled = true;
        }
    };
</script>

<script>
    event_value = document.getElementById('event');
    event_value_label = document.getElementById('event_label');
    event_value_label.innerHTML = event_value.value.length + ' von 50';
    event_value.addEventListener('input', input_change_events);

    function input_change_events(e) {
        event_value_label.innerHTML = e.target.value.length + ' von 50';
        if (e.target.value.length >= 30) {
            event_value_label.style.color = 'orange';
        }
        if (e.target.value.length >= 45) {
            event_value_label.style.color = 'red';
        }
        if (e.target.value.length < 30) {
            event_value_label.style.color = 'green';
        }
    }

    room_value = document.getElementById('room');
    room_value_label = document.getElementById('room_label');
    room_value_label.innerHTML = room_value.value.length + ' von 25';
    room_value.addEventListener('input', input_change);

    function input_change_room(e) {
        room_value_label.innerHTML = e.target.value.length + ' von 25';
        if (e.target.value.length >= 10) {
            room_value_label.style.color = 'orange';
        }
        if (e.target.value.length >= 20) {
            room_value_label.style.color = 'red';
        }
        if (e.target.value.length < 10) {
            room_value_label.style.color = 'green';
        }
    }
</script>