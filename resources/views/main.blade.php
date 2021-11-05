<?php
use app\controller\config;
use app\controller\main;
use app\controller\group;
$main = MAIN::index();
?>
    <button class="btn btn-hidden" type="button" style="border: none;z-index:999;" href="?b=events" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasTopLabel">Navigation</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="row">
        <a href="?b=events">
          <span class="navbar-text">
            <?php echo$lang['events'] ?>
          </span>
        </a>
        <a href="?b=groups">
          <span class="navbar-text">
            <?php echo$lang['groups'] ?>
          </span>
        </a>
        <a href="?b=settings">
          <span class="navbar-text">
            <?php echo$lang['settings'] ?>
          </span>
        </a>
    </div>
  </div>
</div>

<article class="row g-3 main">
  <section class="col-12">
  <div class="card">
    <div class="card-header">
<nav class="navbar navbar-dark">
      <h1 class="header-primary"><?php echo config::get('name')->return ?></h1>
      <h1 class="header-primary"><?php echo  strftime('%A %d.%m.%Y - '); ?><span id="display_time"></span></h2>
</nav>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table align-center table-striped table-hover" id="table-to-refresh">
            <thead>
              <tr>
                <th scope="col"><?php echo$lang['project'] ?></th>
                <th scope="col"><?php echo$lang['group'] ?></th>
                <th scope="col"><?php echo$lang['room'] ?></th>
                <th scope="col"><?php echo$lang['from'] ?></th>
                <th scope="col"><?php echo$lang['till'] ?></th>
              </tr>
            </thead>
            <tbody>
              <?php

                foreach($main['today'] as $row){
                    if($row['not_applicable'] == 1){
                      $disabled = 'class="table-danger strikethrough"';
                    }else{
                        $disabled = '';
                    }

                    echo'
              <tr '.$disabled.'>
                <td>'. $row['event'] .'</td>';
                echo'<td>';

                  $teams = explode(';', $row['team']);
                      array_pop($teams);
                      foreach($teams as $team){
                        $color = GROUP::find($team)->color;
                        echo'<span class="badge text-dark" style="background-color:'. $color.';">'. $team .'</span> ';
                      }
                  
                  
                  echo'</td>';
                echo'<td>'. $row['room'] .'</td>';
                if($row['start'] != $row['end']){
                  echo'<td>'. strftime('%a %d.%m.%Y', strtotime($row['start'])) .'</td>';
                  echo'<td>'. strftime('%a %d.%m.%Y', strtotime($row['end'])) .'</td>';
                }
                if($row['start'] == $row['end']){
                  echo'<td colspan="2">'. strftime('%a %d.%m.%Y', strtotime($row['start'])) .'</td>';
                }
              }
              echo'</tr>';
              ?>
            </tbody>
        </table>
        </div>
    </div>
    </div>
  </section>
  <section class="col-12">
  <div class="card">
    <div class="card-header">
<nav class="navbar navbar-dark">
      <h2 class="header-secondary"><?php echo$lang['event'] .' '. $lang['preview']; ?></h2>
      <h2 class="header-secondary"><?php echo  config::get('future_day')->return; ?> Tage</h2>
</nav>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover" id="table-to-refresh">
            <thead>
              <tr>
                <th scope="col"><?php echo$lang['project'] ?></th>
                <th scope="col"><?php echo$lang['group'] ?></th>
                <th scope="col"><?php echo$lang['room'] ?></th>
                <th scope="col"><?php echo$lang['from'] ?></th>
                <th scope="col"><?php echo$lang['till'] ?></th>
                <th scope="col"><?php echo$lang['remaining_days'] ?></th>
              </tr>
            </thead>
            <tbody>
              <?php

                foreach($main['future'] as $row){
                    if($row['not_applicable'] == 1){
                      $disabled = 'class="table-danger strikethrough"';
                    }else{
                        $disabled = '';
                    }

                    echo'
              <tr '.$disabled.'>
                <td>'. $row['event'] .'</td>
                <td>';

                  $teams = explode(';', $row['team']);
                      array_pop($teams);
                      foreach($teams as $team){
                        $group_color = GROUP::find($team)->color;
                        echo'<span class="badge text-dark" style="background-color:'. $group_color.';">'. $team .'</span> ';
                      }
                  
                  echo'</td>
                <td>'. $row['room'] .'</td>';
                if($row['start'] != $row['end']){
                  echo'<td>'. strftime('%a %d.%m.%Y', strtotime($row['start'])) .'</td>';
                  echo'<td>'. strftime('%a %d.%m.%Y', strtotime($row['end'])) .'</td>';
                }
                if($row['start'] == $row['end']){
                  echo'<td colspan="2">'. strftime('%a %d.%m.%Y', strtotime($row['start'])) .'</td>';
                }
              echo'<td>'. date('j', strtotime($row['start']) - strtotime(date('Y-m-d').' +1 day')) .' Tagen</td>
              </tr>';
                  }
              ?>
            </tbody>
        </table>
      </div>
    </div>
    </div>
  </section>
</article>
<script>
refresh_loop();
show_clock()

var i = 1
function refresh_loop(){
    setTimeout(function(){
        // console.log('Hallo');
        window.location.reload();
        i++;
        if(i < 10){
            refresh_loop();
        }
    }, <?php echo config::get('refresh')->return ?> * 1000)
}

function show_clock(){
  const today = new Date();
  let h = today.getHours();
  let m = today.getMinutes();
  let s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  display_time = document.getElementById("display_time");
  // display_time.innerHTML = h + ":" + m + ":" + s;
  display_time.innerHTML = h + ":" + m;
  setTimeout(show_clock, 1000)
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}
</script>
