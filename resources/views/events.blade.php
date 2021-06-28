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
                  <div class="col-auto">
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
                  <div class="col-10">
                    <div class="row g-2 justify-content-around" id="repeat_time">
                      <div class="col-3">
                        <div class="form-group">
                          <fieldset>
                            <label class="form-label" for="weeks">
                              <?php echo$lang['weeks'] ?> :
                            </label>
                            <input class="form-control" type="number" value="1" min="1" name="repeat_weeks" id="repeat_weeks">
                          </fieldset>
                        </div>
                      </div>
                      <div class="col-auto">
                        <div class="form-check">
                          <fieldset>
                            <input class="form-check-input" type="checkbox" value="" name="repeat_monday" id="repeat_monday">
                            <label class="form-check-label" for="repeat_monday">
                              <?php echo$lang['monday'] ?>
                            </label>
                          </fieldset>
                        </div>
                      </div>
                      <div class="col-auto">
                        <div class="form-check">
                          <fieldset>
                            <input class="form-check-input" type="checkbox" value="" name="repeat_tuesday" id="repeat_tuesday">
                            <label class="form-check-label" for="repeat_tuesday">
                              <?php echo$lang['tuesday'] ?>
                            </label>
                          </fieldset>
                        </div>
                      </div>
                      <div class="col-auto">
                        <div class="form-check">
                          <fieldset>
                            <input class="form-check-input" type="checkbox" value="" name="repeat_wednesday" id="repeat_wednesday">
                            <label class="form-check-label" for="repeat_wednesday">
                              <?php echo$lang['wednesday'] ?>
                            </label>
                          </fieldset>
                        </div>
                      </div>
                      <div class="col-auto">
                        <div class="form-check">
                          <fieldset>
                            <input class="form-check-input" type="checkbox" value="" name="repeat_thursday" id="repeat_thursday">
                            <label class="form-check-label" for="repeat_thursday">
                              <?php echo$lang['thursday'] ?>
                            </label>
                          </fieldset>
                        </div>
                      </div>
                      <div class="col-auto">
                        <div class="form-check">
                          <fieldset>
                            <input class="form-check-input" type="checkbox" value="" name="repeat_friday" id="repeat_friday">
                            <label class="form-check-label" for="repeat_friday">
                              <?php echo$lang['friday'] ?>
                            </label>
                          </fieldset>
                        </div>
                      </div>
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
                          foreach(group::index() as $group){
                            if($row['team'] == $group['alias']){
                              $group_badge = $group['color'];
                            }
                          }

                          echo'<tr>
                              <td>
                                <a href="?b=events_edit&id='. $row['id'] .'">
                                  '. $row['event'] .'
                                </a>
                              </td>';
                          echo'<td>
                              <span class="badge text-dark" style="background-color:'. $group_badge .';">
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
                              <i class="bi bi-wrench"></i>
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
        var set_repeat_time = document.getElementById("repeat_time");

        set_repeat_time.style.display = "block";
        set_repeat.onchange = function () {
          if (set_repeat_time.style.display === "none") {
            set_repeat_time.style.display = "block";
          } else {
            set_repeat_time.style.display = "none";
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