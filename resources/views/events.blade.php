<?php
use app\controller\events;
use app\controller\group;

$events = events::index();
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
        <a href="?b=groups">
          <span class="navbar-text">
            <?php echo$lang['groups'] ?>
          </span>
        </a>
      </div>
      <div class="col">
        <a href="?b=settings">
          <span class="navbar-text">
            <?php echo$lang['settings'] ?>
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
            <button class="nav-link col active" id="nav-event_add-tab" data-bs-toggle="tab"
              data-bs-target="#nav-event_add" type="button" role="tab" aria-controls="nav-event_add"
              aria-selected="false">
              <?php echo$lang['event'] .' '. $lang['add'] ?>
            </button>
            <button class="nav-link col" id="nav-event_edit-tab" data-bs-toggle="tab" data-bs-target="#nav-event_edit"
              type="button" role="tab" aria-controls="nav-event_edit" aria-selected="true">
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
                      <input type="text" class="form-control" name="event" id="event"
                        placeholder="<?php echo$lang['event'] ?>" list="event_list" required />
                      <label for="event">
                        <?php echo$lang['event'] ?>
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
                            <?php echo$lang['group'] ?>
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
                            placeholder="<?php echo$lang['room'] ?>">
                          <label for="room">
                            <?php echo$lang['room'] ?>
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
                        value="<?php echo strftime('%Y-%m-%d 00:00') ?>" required>
                      <label for="start_date">
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
                      <input type="datetime-local" class="form-control" name="end_date" id="end_date"
                        value="<?php echo strftime("%Y-%m-%d 00:00") ?>" required>
                      <label for="end_date">
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
                        <input class="form-check-input" type="checkbox" id="set_repeat" name="set_repeat"
                          data-toggle="toggle" autocomplete="off">
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
                      <input class="form-control" type="number" placeholder="<?php echo$lang['days'] ?>" min="0"
                        name="repeat_days" id="repeat_days" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="In wievielen Tagen sich der Termin wiederholen soll">
                    </fieldset>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <fieldset id="set_repeat_input_2" disabled>
                      <label class="form-label" for="repeats">
                        <?php echo$lang['repeat'] ?> :
                      </label>
                      <input class="form-control" type="number" placeholder="<?php echo$lang['repeat'] ?>" min="0"
                        name="repeats" id="repeats" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Wie oft sich der Termin wiederholen soll">
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
                    <th scope="col">
                      <?php echo$lang['project'] ?>
                    </th>
                    <th scope="col">
                      <?php echo$lang['group'] ?>
                    </th>
                    <th scope="col">
                      <?php echo$lang['room'] ?>
                    </th>
                    <th scope="col">
                      <?php echo$lang['from'] ?>
                    </th>
                    <th scope="col">
                      <?php echo$lang['till'] ?>
                    </th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                        foreach($events['result'] as $row){
                          $start = strftime('%Y-%m-%d', strtotime($row['start']));
                  $end = strftime('%Y-%m-%d', strtotime($row['end']));
                          if($start >= strftime('%Y-%m-%d') OR $end >= strftime('%Y-%m-%d')){
                        if($row['not_applicable'] == 1){
                          $disabled = 'class="table-danger strikeout"';
                        }else{
                          $disabled = '';
                        }
                        echo'
                            <tr '.$disabled.'>
                              <td>
                                '. $row['event'] .'
                              </td>
                              <td>';

                  $teams = explode(';', $row['team']);
                      array_pop($teams);
                      foreach($teams as $team){
                        $color = GROUP::find($team)->color;
                        echo'<span class="badge text-dark" style="background-color:'. $color.';">'. $team .'</span> ';
                      }
                  
                  
                  echo'</td>
                  <td>
                              '. $row['room'] .'
                            </td>';
                          if(strftime('%d.%m.%Y', strtotime($row['start'])) != strftime('%d.%m.%Y', strtotime($row['end']))){

                            if(strftime('%H:%M', strtotime($row['start'])) == '00:00'){
                              echo'<td>'. strftime('%d.%m.%Y %H:%M', strtotime($row['start'])) .'</td>';
                            }else{
                              echo'<td>'. strftime('%d.%m.%Y %H:%M', strtotime($row['start'])) .'</td>';
                            }
                            if(strftime('%H:%M', strtotime($row['end'])) == '00:00'){
                              echo'<td>'. strftime('%d.%m.%Y', strtotime($row['end'])) .'</td>';
                            }else{
                              echo'<td>'. strftime('%d.%m.%Y %H:%M', strtotime($row['end'])) .'</td>';
                            }
                          }
                          if(strftime('%d.%m.%Y', strtotime($row['start'])) == strftime('%d.%m.%Y', strtotime($row['end']))){
                            if(strftime('%H:%M', strtotime($row['start'])) == '00:00'){
                              echo'<td colspan="2">'. strftime('%d.%m.%Y ', strtotime($row['start'])) .'</td>';
                            }else{
                              echo'<td colspan="2">'. strftime('%d.%m.%Y %H:%M', strtotime($row['start'])) .'</td>';
                            }
                          }
                          echo'<td>
                            <a href="?b=events_edit&id='. $row['id'] .'" type="button" class="btn btn-sm btn-secondary position-relative">
                              <i class="bi bi-gear-wide"></i>
                            </a>
                          </td>';
                        }
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