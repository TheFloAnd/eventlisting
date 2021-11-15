<?php
use app\controller\events;
use app\controller\group;

$events = events::index();
?>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
    <div class="row mt-3 g-3 justify-content-center">
        <div class="col-md-10">
            <fieldset>
                <div class="form-floating">
                    <input type="text" class="form-control" name="event" id="event"
                        placeholder="<?php echo lang['event'] ?>" list="event_list" required />
                    <label for="event">
                        <?php echo lang['event'] ?>
                        <span style="color: red;">
                            *
                        </span>
                    </label>
                    <datalist id="event_list">
                        <?php
                          foreach($events['proposals'] as $row){
                            echo'<option value="'. $row['event'] .'">';
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
                        <div class="input-group">
                            <label for="group">
                                <?php echo lang['group'] ?>
                                <span style="color: red;">
                                    *
                                </span>
                            </label>
                            <select class="form-select multiple-select" name="group[]" multiple="multiple" required>
                                <?php
                              
                                foreach($events['group'] as $row){
                                    echo'<option value="'. $row['alias'] .'">'. $row['name'] .' ('. $row['alias'] .')</option>';
                                }
                              ?>
                            </select>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-3">
                    <fieldset>
                        <div class="form-floating">
                            <input type="text" class="form-control" name="room" id="room"
                                placeholder="<?php echo lang['room'] ?>">
                            <label for="room">
                                <?php echo lang['room'] ?>
                            </label>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <fieldset>
                <div class="form-floating">
                    <input type="datetime-local" class="form-control" name="start_date" id="start_date"
                        value="<?php echo strftime('%Y-%m-%dT00:00') ?>" required>
                    <label for="start_date">
                        <?php echo lang['start'] .' '.  lang['date'] ?>
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
                    <input type="datetime-local" class="form-control" name="end_date" id="end_date"
                        value="<?php echo strftime('%Y-%m-%dT00:00') ?>" required>
                    <label for="end_date">
                        <?php echo lang['end'] .' '.  lang['date'] ?>
                        <span style="color: red;">
                            *
                        </span>
                    </label>
                </div>
            </fieldset>
        </div>
        <div class="col-md-10">
            <fieldset>
                <div class="form-group">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="set_repeat" name="set_repeat"
                            data-toggle="toggle" autocomplete="off">
                        <label class="form-check-label" for="set_repeat">
                            <?php echo lang['repeat'] ?>
                        </label>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <fieldset id="set_repeat_input_1" disabled>
                    <label class="form-label" for="days">
                        <?php echo lang['days'] ?> :
                    </label>
                    <input class="form-control" type="number" placeholder="<?php echo lang['days'] ?>" min="0"
                        name="repeat_days" id="repeat_days" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="In wievielen Tagen sich der Termin wiederholen soll">
                </fieldset>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <fieldset id="set_repeat_input_2" disabled>
                    <label class="form-label" for="repeats">
                        <?php echo lang['repeat'] ?> :
                    </label>
                    <input class="form-control" type="number" placeholder="<?php echo lang['repeat'] ?>" min="0"
                        name="repeats" id="repeats" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Wie oft sich der Termin wiederholen soll">
                </fieldset>
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