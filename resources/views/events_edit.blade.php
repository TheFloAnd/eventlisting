<?php 
use app\controller\events;
$event = events::find($_GET['id']);
?>
<nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <a href="?b=main">
          <span class="navbar-text">
            <?php echo$lang['index'] ?>
          </span>
        </a>
      </div>
      <div class="col">
        <a href="?b=events">
          <span class="navbar-text">
            <?php echo$lang['events'] ?>
          </span>
        </a>
      </div>
      <div class="col">
        <a href="?b=groups">
          <span class="navbar-text">
            <?php echo$lang['groups'] ?>
          </span>
        </a>
      </div>
    </div>
  </div>
</nav>
<article class="row">
    <section class="col">
        <div class="card">
            <div class="card-body">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="row mt-3 g-3 justify-content-center"><form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                        <div class="row mt-3 g-3 justify-content-center">
                            <fieldset class="" hidden>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="event_id" id="event_id" placeholder="<?php echo$event['id'] ?>" value="<?php echo$event['id'] ?>" >
                                </div>
                            </fieldset>
                            <div class="col-md-10">
                                <fieldset>
                                    <div class="form-check">
                                    <?php
                                    if($event['not_applicable'] == 1){
                                        $checked = 'checked';
                                    }else{
                                        $checked = '';
                                    }

                                    ?>
                                        <input class="form-check-input" type="checkbox" value="1" name="removed" id="removed" <?php echo$checked ?>>
                                        <label class="form-check-label" for="removed">
                                            <?php echo$lang['not_applicable'] ?>
                                        </label>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-10">
                                <fieldset>
                                    <div class="form-floating">
                                    <input type="text" class="form-control" name="event" id="event" placeholder="<?php echo$event['event'] ?>" value="<?php echo$event['event'] ?>" list="event_list" required>
                                    <label for="floatingInput">
                                        <?php echo$lang['event'] ?>
                                        <span style="color: red;">
                                            *
                                        </span>
                                    </label>
                                    <datalist id="event_list">
                                    <?php

                                    foreach(events::proposals() as $row){
                                        echo'<option value="'. $row['event'] .'">';
                                    }
                                    ?>
                                    </datalist>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-7">
                            <fieldset>
                                <div class="form-floating">
                                    <select class="form-select" name="group" id="group" aria-label="Floating label select example" required>
                                        <?php
                                        use app\controller\group;
                                        $current_group = group::find($event['team']);
                                        echo'<option value="'. $current_group['alias'] .'">'. $current_group['name'] .' ('. $current_group['alias'] .')</option>';
                                        
                                        foreach(group::index() as $row){
                                            if($row['alias'] != $event['team']){
                                                echo'<option value="'. $row['alias'] .'">'. $row['name'] .' ('. $row['alias'] .')</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <label for="floatingSelect">
                                        <?php echo$lang['group'] ?>
                                        <span style="color: red;">
                                            *
                                        </span>
                                    </label>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-3">
                            <fieldset>
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="room" id="room" placeholder="<?php echo$event['room'] ?>" value="<?php echo$event['room'] ?>" >
                                    <label for="room">
                                        <?php echo$lang['room'] ?>
                                    </label>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-5">
                            <fieldset>
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo$event['start'] ?>" required>
                                    <label for="floatingInput">
                                        <?php echo$lang['start'] .' '. $lang['date'] ?>
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
                                    <input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo$event['end'] ?>" required>
                                    <label for="floatingInput">
                                        <?php echo$lang['end'] .' '. $lang['date'] ?>
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
                                        <button type="submit" class="btn btn-outline-success w-100" name="submit_edit_event" value="submit">
                                            <?php echo$lang['update'] ?>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <?php echo$lang['delete'] ?>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <a type="button" class="btn btn-outline-secondary w-100" href="?b=events">
                                            <?php echo$lang['back'] ?>
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
                <h5 class="modal-title" id="exampleModalLabel"><?php echo$lang['delete'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="modal-body">

                    <fieldset class="" hidden>
                        <div class="form-group">
                            <input type="text" class="form-control" name="event_id" id="event_id" placeholder="<?php echo$event['id'] ?>" value="<?php echo$event['id'] ?>" >
                        </div>
                    </fieldset>
                    <p>Wollen die den Termin wirklich Löschen?</p>
<?php
if(!empty($event['repeat']) || !empty($event['repeat_parent'])){
    echo'<fieldset>
        <div class="form-group">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="delete_repeat" id="delete_repeat" data-toggle="toggle" autocomplete="off">
                <label class="form-check-label" for="delete_repeat">
                    '. $lang['repeat'] .' '.$lang['delete'] .'?
                </label>
            </div>
        </div>
    </fieldset>';
    }

?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <?php echo$lang['close'] ?>
                    </button>
                    <button type="submit" class="btn btn-danger" name="submit_delete_event">
                        <?php echo$lang['delete'] ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>