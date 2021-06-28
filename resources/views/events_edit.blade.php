<?php 
use app\controller\events;
$event = events::show_event($_GET['id']);
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
                        <div class="col-8">
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-success w-100" name="submit_edit_event" value="submit">
                                    <?php echo$lang['update'] ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>          
            </div>
        </div>
    </section>
</article>