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
          <nav>
            <div class="nav nav-tabs justify-content-evenly" id="nav-tab" role="tablist">
              <button class="nav-link col active" id="nav-event_add-tab" data-bs-toggle="tab" data-bs-target="#nav-event_add" type="button" role="tab" aria-controls="nav-event_add" aria-selected="false">
                <?php echo$lang['event'] .' '. $lang['add'] ?>
              </button>
              <button class="nav-link col" id="nav-event_edit-tab" data-bs-toggle="tab" data-bs-target="#nav-event_edit" type="button" role="tab" aria-controls="nav-event_edit" aria-selected="true">
                <?php echo$lang['events'] .' '. $lang['edit'] ?>
              </button>
            </div>
          </nav>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="nav-event_add" role="tabpanel" aria-labelledby="nav-event_add-tab">
              <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="row mt-3 g-3 justify-content-center">
                  <div class="col-md-10">
                    <fieldset>
                      <div class="form-floating">
                        <input type="text" class="form-control" name="event" id="event" placeholder="" list="event_list" required>
                        <label for="floatingInput">
                            <?php echo$lang['event'] ?>
                          <span style="color: red;">
                            *
                          </span>
                        </label>
                        <datalist id="event_list">
                          <?php
                          use app\controller\events;

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

                            foreach(group::index() as $row){
                                echo'<option value="'. $row['alias'] .'">'. $row['name'] .' ('. $row['alias'] .')</option>';
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
                        <input type="text" class="form-control" name="room" id="room" placeholder="<?php echo$lang['room'] ?>">
                        <label for="room">
                          <?php echo$lang['room'] ?>
                        </label>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-md-5">
                    <fieldset>
                      <div class="form-floating">
                        <input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo date("Y-m-d") ?>" required>
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
                        <input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo date("Y-m-d") ?>" required>
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
                    <fieldset>
                      <div class="form-group">
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" id="set_repeat" data-toggle="toggle" autocomplete="off">
                          <label class="form-check-label" for="set_repeat">
                            <?php echo$lang['repeat'] ?>
                          </label>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <fieldset id="set_repeat_input_1" disabled>
                            <label class="form-label" for="days">
                              <?php echo$lang['days'] ?> :
                            </label>
                            <input class="form-control" type="number" value="0" min="0" name="repeat_days" id="repeat_days">
                          </fieldset>
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <fieldset id="set_repeat_input_2" disabled>
                            <label class="form-label" for="repeats">
                              <?php echo$lang['repeat'] ?> :
                            </label>
                            <input class="form-control" type="number" value="0" min="0" name="repeats" id="repeats">
                          </fieldset>
                        </div>
                      </div>
                      
                  <div class="col-8">
                    <div class="form-group">
                      <button type="submit" class="btn btn-outline-success w-100" name="submit_event" value="submit">
                        <?php echo$lang['add'] ?>
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>

            <div class="tab-pane fade" id="nav-event_edit" role="tabpanel" aria-labelledby="nav-event_edit-tab">
              <div class="table-responsive">
                  <table class="table table-striped table-hover" id="table-to-refresh">
                      <thead>
                        <tr>
                          <th scope="col"><?php echo$lang['project'] ?></th>
                          <th scope="col"><?php echo$lang['group'] ?></th>
                          <th scope="col"><?php echo$lang['room'] ?></th>
                          <th scope="col"><?php echo$lang['from'] ?></th>
                          <th scope="col"><?php echo$lang['till'] ?></th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach(events::show() as $row){
                        if($row['not_applicable'] == 1){
                          $disabled = 'class="table-danger strikeout"';
                        }else{
                          $disabled = '';
                        }

                        echo'
                            <tr '.$disabled.'>
                              <td>
                                '. $row['event'] .'
                              </td>';
                          echo'<td>
                              <span class="badge text-dark" style="background-color:'. $row['team_color'] .';">
                                '. $row['team'] .'
                              </span>
                            </td>';
                          echo'<td>
                              '. $row['room'] .'
                            </td>';
                          if($row['start'] != $row['end']){
                            echo'<td>'. date('d.m.Y', strtotime($row['start'])) .'</td>';
                            echo'<td>'. date('d.m.Y', strtotime($row['end'])) .'</td>';
                          }
                          if($row['start'] == $row['end']){
                            echo'<td colspan="2">'. date('d.m.Y', strtotime($row['start'])) .'</td>';
                          }
                          echo'<td>
                            <a href="?b=events_edit&id='. $row['id'] .'" type="button" class="btn btn-sm btn-secondary position-relative">
                              <i class="bi bi-gear-wide"></i>
                            </a>
                          </td>';
                        }
                        echo'</tr>';
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
        var set_repeat = document.getElementById("set_repeat");
        var repeat_input_1 = document.getElementById("set_repeat_input_1");
        var repeat_input_2 = document.getElementById("set_repeat_input_2");

        repeat_input_1.disabled = true;
        repeat_input_2.disabled = true;
        set_repeat.onchange = function () {
          if (repeat_input_1.hasAttribute('disabled')) {
            repeat_input_1.disabled = false;
          } else {
            repeat_input_1.disabled = true;
          }

          if (repeat_input_2.hasAttribute('disabled')) {
            repeat_input_2.disabled = false;
          } else {
            repeat_input_2.disabled = true;
          }
        };
    </script>
    <script>
        var start_date = document.getElementById("start_date");
        var end_date = document.getElementById("end_date");
        
        start_date.onchange = function () {
          if (start_date.value > end_date.value) {
            end_date.value = start_date.value
          }

          if (!end_date.value) {
            end_date.value = start_date.value
          }
        };
        end_date.onchange = function () {
          if (end_date.value < start_date.value) {
            start_date.value = end_date.value
          }

          if (!start_date.value) {
            start_date.value = end_date.value
          }
        };
    </script>