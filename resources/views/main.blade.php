
    <a class="btn btn-hidden" type="button" style="border: none;" href="?b=create">
      <span class="navbar-toggler-icon"></span>
    </a>

<article class="row g-3">
  <section class="col-12">
  <div class="card">
    <div class="card-header">
      <h1 id="reloading"><?php echo date('d.m.Y - H:i'); ?></h1>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table align-center table-striped table-hover" id="table-to-refresh">
            <thead>
              <tr>
                <th scope="col">Vorhaben</th>
                <th scope="col">Gruppe</th>
                <th scope="col">Raum</th>
                <th scope="col">Vom</th>
                <th scope="col">Bis zum</th>
              </tr>
            </thead>
            <tbody>
              <?php

                use app\controller\events;
                use app\controller\group;

                foreach(events::index() as $row){
                    foreach(group::index() as $group){
                      if($row['team'] == $group['alias']){
                        $group_badge = $group['color'];
                      }
                    }

                    echo'
              <tr>
                <td>'. $row['event'] .'</td>';
                echo'<td><span class="badge text-dark" style="background-color:'. $group_badge .';">'. $row['team'] .'</span></td>';
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
                <th scope="col">Vorhaben</th>
                <th scope="col">Gruppe</th>
                <th scope="col">Raum</th>
                <th scope="col">Vom</th>
                <th scope="col">Bis zum</th>
                <th scope="col">In</th>
              </tr>
            </thead>
            <tbody>
              <?php

                foreach(events::future() as $row){
                    foreach(group::index() as $group){
                      if($row['team'] == $group['alias']){
                        $group_badge = $group['color'];
                      }
                    }
                    echo'
              <tr>
                <td>'. $row['event'] .'</td>
                <td><span class="badge text-dark" style="background-color:'. $group_badge .'">'. $row['team'] .'</span></td>
                <td>'. $row['room'] .'</td>
                <td>'. date('d.m.Y', strtotime($row['start'])) .'</td>
                <td>'. date('d.m.Y', strtotime($row['end'])) .'</td>
                <td>'. date('j', strtotime($row['start']) - strtotime(date('Y-m-d').' +1 day')) .' Tagen</td>
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

var i = 1
function refresh_loop(){
    setTimeout(function(){
        // console.log('Hallo');
        window.location.reload();
        i++;
        if(i < 10){
            refresh_loop();
        }
    }, 5 * 1000)
}
</script>