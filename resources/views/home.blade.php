<?php

use app\controller\config;
use app\controller\home;
use app\controller\group;

$result = home::index();
?>
<button class="btn btn-lg btn_hidden btn_menu" type="button" href="?b=events" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
  <span class="navbar-toggler-icon"></span>
</button>
<div class="offcanvas offcanvas-start myOffcanvas" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
  <div class="offcanvas-header">
    <h4 id="offcanvasTopLabel"><?php echo lang['nav'] ?></h4>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="btn-group-vertical w-100">
      <a href="?b=events" type="button" class="btn btn-outline-secondary">
        <?php echo lang['events'] ?>
      </a>
      <a href="?b=groups" type="button" class="btn btn-outline-secondary">
        <?php echo lang['groups'] ?>
      </a>
      <a href="?b=settings" type="button" class="btn btn-outline-secondary">
        <?php echo lang['settings'] ?>
      </a>
    </div>
  </div>
</div>

<article class="row g-3 home article-home">
  <section class="col-12 section-home-today">
    <div class="card card-home-today">
      <div class="card-header home-card-header card-home-today-header">
        <nav class="navbar card-home-today-header-nav">
          <div class="row">
            <div class="col-auto">
              <div class="refresh" id="refresh-title">
                <h1 class="header-primary">
                  <?php echo config::get('name')->value; ?>
                </h1>
              </div>
            </div>
            <div class="col-auto">
              <div class="refresh-icon invisible">
                <div class="spinner-grow" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </div>

          </div>
          <h1 class="header-primary">
            <!--
            <?php echo  strftime('%A %d.%m.%Y - '); ?>
            -->
            <span id="display_time"></span>
          </h1>
        </nav>
      </div>
      <div class="card-body home-card-body card-home-today-body refresh" id="refresh-card-home">
        <div class="table-responsive">
          <table class="table table-striped">
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
              </tr>
            </thead>
            <tbody>
              <?php

              foreach ($result as $row) {
                if (strftime('%Y-%m-%d', strtotime($row['start'])) <= strftime('%Y-%m-%d')) {
                  if (strftime('%Y-%m-%d', strtotime($row['end'])) >= strftime('%Y-%m-%d')) {
                    if ($row['not_applicable'] == 1) {
                      $disabled = 'class="table-danger strikethrough"';
                    } else {
                      $disabled = '';
                    }

                    echo '
              <tr ' . $disabled . '>
                <td>' . $row['event'] . '</td>';
                    echo '<td>';

                    $teams = explode(';', $row['team']);

                    foreach ($teams as $team) {

                      $color = GROUP::find($team)->color;
                      echo '<span class="badge text-dark" style="background-color:' . $color . ';">' . $team . '</span> ';
                    }


                    echo '</td>';
                    echo '<td>' . $row['room'] . '</td>';

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
                  }
                }
              }
              echo '</tr>';
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  <section class="col-12 section-home-preview">
    <div class="card card-home-preview">
      <div class="card-header card-home-preview-header">
        <nav class="navbar navbar-dark card-home-preview-header-nav">

          <div class="row">
            <div class="col-auto">
              <h2 class="header-secondary">
                <?php echo lang['event'] . ' ' .  lang['preview']; ?>
              </h2>
            </div>
            <div class="col-auto">
              <div class="refresh-icon invisible">
                <div class="spinner-grow" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </div>
          </div>
          <div class="refresh" id="refresh-title-preview">
          <h2 class="header-secondary">
            <?php
            $future = config::get('future_day');
            switch ($future->time_unit) {
              case 'day':
                $output_time_unit = lang['days'];
                break;
              case 'week':
                $output_time_unit = lang['weeks'];
                break;
            }

            echo $future->value . ' ' .  $output_time_unit;
            ?>
          </h2>
          </div>
        </nav>
      </div>
      <div class="card-body refresh card-home-preview-body" id="refresh-card-preview">
        <div class="table-responsive">
          <table class="table table-striped">
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
                <th scope="col">
                  <?php echo lang['remaining_days'] ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $config = config::get('future_day');
              foreach ($result as $row) {
                $start = strftime('%Y-%m-%d', strtotime($row['start']));
                $end = strftime('%Y-%m-%d', strtotime($row['end']));
                if ($start >= strftime('%Y-%m-%d', strtotime('+ 1 day'))) {
                  if ($start <= strftime('%Y-%m-%d', strtotime(' + ' . $config->value . ' ' . $config->time_unit))) {
                    if ($row['not_applicable'] == 1) {
                      $disabled = 'class="table-danger strikethrough"';
                    } else {
                      $disabled = '';
                    }

                    echo '
              <tr ' . $disabled . '>
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
                    echo '<td>' . abs(strtotime(strftime('%Y-%m-%d', strtotime($row['start']))) - strtotime(strftime('%Y-%m-%d'))) / 60 / 60 / 24 . ' ' . lang['meet'] . '</td>
              </tr>';
                  }
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  <section class="col-12 newsBanner-container d-flex justify-content-center">
    <div class="alert alert-secondary newsBanner" role="alert">
      <h3 class="alert-heading">
        <?php echo lang['news']; ?>
      </h3>
      <hr>
      <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so
        that you can see how spacing within an alert works with this kind of content.</p>
    </div>
  </section>
</article>
<script>
  setInterval(function() {
    refresh_loop();
  }, <?php echo config::get('refresh')->value; ?> * 1000);

  function refresh_loop() {
    $('.refresh-icon').each(function(index, element) {
      $(element).removeClass("invisible");
      $(element).addClass("visible");
    });
    $('.refresh').each(function(index, element) {
      $(element).load(window.location.href + " #" + this.id + " > *");
    });
    setTimeout(function() {
      $('.refresh-icon').each(function(index, element) {
        $(element).removeClass("visible");
        $(element).addClass("invisible");
      });
    }, 1 * 1000);
    console.log(Date.now() +' Content  Refreshed!');
  }
</script>
<?php
echo '<script>
show_clock();
function show_clock(){
const days = ["' . lang['sunday'] . '", "' . lang['monday'] . '", "' . lang['tuesday'] . '", "' . lang['wednesday'] . '", "' . lang['thursday'] . '", "' . lang['friday'] . '", "' . lang['saturday'] . '"];
display_time = document.getElementById("display_time");
  const today = new Date();
  let y = today.getFullYear();
  let M = today.getMonth() + 1;
  let d= today.getDate();
  let D = today.getDay();
  D = days[D];
  let h = today.getHours();
  let m = today.getMinutes();
  let s = today.getSeconds();
  M = checkTime(M);
  d = checkTime(d);
  h = checkTime(h);
  m = checkTime(m);
  s = checkTime(s);
  // display_time.innerHTML = h + ":" + m + ":" + s;
  date = D + " " + d + "." + M + "." + y;
  time = h + ":" + m;
  display_time.innerHTML = date + " - " + time;
  setTimeout(show_clock, 1000)
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}
</script>';
?>