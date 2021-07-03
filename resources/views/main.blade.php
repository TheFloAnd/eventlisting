<?php
use app\controller\config;
?>
    <button class="btn btn-hidden" type="button" style="border: none;" href="?b=events" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
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

<article class="row g-3">
  <section class="col-12">
  <div class="card">
    <div class="card-header">
      <h1><?php echo config::get('name')->return . date('d.m.Y - H:i'); ?></h1>
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

                use app\controller\events;
                $events_current = events::index('v_events_current');
                if($events_current){

                foreach($events_current as $row){
                    if($row['not_applicable'] == 1){
                      $disabled = 'class="table-danger strikeout"';
                    }else{
                        $disabled = '';
                    }

                    echo'
              <tr '.$disabled.'>
                <td>'. $row['event'] .'</td>';
                echo'<td><span class="badge text-dark" style="background-color:'. $row['team_color'] .';">'. $row['team'] .'</span></td>';
                echo'<td>'. $row['room'] .'</td>';
                if($row['start'] != $row['end']){
                  echo'<td>'. date('d.m.Y', strtotime($row['start'])) .'</td>';
                  echo'<td>'. date('d.m.Y', strtotime($row['end'])) .'</td>';
                }
                if($row['start'] == $row['end']){
                  echo'<td colspan="2">'. date('d.m.Y', strtotime($row['start'])) .'</td>';
                }
              }
              echo'</tr>';
            }else{
              echo'<tr><td colspan="5">'. $lang['no_entry'] .'</td></tr>';
            }
              ?>
            </tbody>
        </table>
        </div>
    </div>
    </div>
  </section>
  <section class="col-12">
  <div class="card">
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

                $events_future = events::index('v_events_future');
                if($events_future){
                foreach($events_future as $row){
                    if($row['not_applicable'] == 1){
                      $disabled = 'class="table-danger strikeout"';
                    }else{
                        $disabled = '';
                    }

                    echo'
              <tr '.$disabled.'>
                <td>'. $row['event'] .'</td>
                <td><span class="badge text-dark" style="background-color:'. $row['team_color'] .'">'. $row['team'] .'</span></td>
                <td>'. $row['room'] .'</td>
                <td>'. date('d.m.Y', strtotime($row['start'])) .'</td>
                <td>'. date('d.m.Y', strtotime($row['end'])) .'</td>
                <td>'. date('j', strtotime($row['start']) - strtotime(date('Y-m-d').' +1 day')) .' Tagen</td>
              </tr>';
                  }
            }else{
              echo'<tr><td colspan="6">'. $lang['no_entry'] .'</td></tr>';
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
</script>