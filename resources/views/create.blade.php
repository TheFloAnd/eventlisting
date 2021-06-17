<nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <a href="?b=main">
          <span class="navbar-text">
            Hauptseite
          </span>
        </a>
      </div>
      <div class="col">
        <a href="?b=groups">
          <span class="navbar-text">
            Gruppen
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
                <div class="row mt-3 g-3 justify-content-center">
                  <div class="col-md-10">
                    <fieldset>
                      <div class="form-floating">
                        <input type="text" class="form-control" name="event" id="event" placeholder="" list="event_list" required>
                        <label for="floatingInput">
                          Event
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
                          Gruppe
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
                        <input type="text" class="form-control" name="room" id="room" placeholder="Werkstadt">
                        <label for="room">
                          Raum
                        </label>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-md-5">
                    <fieldset>
                      <div class="form-floating">
                        <input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo date("Y-m-d") ?>" required>
                        <label for="floatingInput">
                          Start Datum
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
                          End Datum
                          <span style="color: red;">
                            *
                          </span>
                        </label>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-8">
                    <div class="form-group">
                      <button type="submit" class="btn btn-outline-success w-100" name="submit_event" value="submit">
                        Hinzufügen
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
        </div>
      </div>
    </section>
</article>
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