
    <a class="btn btn-hidden" type="button" style="border: none;" href="?b=events">
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

                foreach(events::index() as $row){
                  switch ($row['team']){
                    case 'FISI19':
                      $group_badge = 'primary';
                      break;
                    case 'FISI20':
                      $group_badge = 'success';
                      break;
                    case 'BVB':
                      $group_badge = 'danger';
                      break;
                    default:
                      $group_badge = 'secondary';

                  }
                    echo'
              <tr>
                <td>'. $row['event'] .'</td>';
                echo'<td><span class="badge bg-'. $group_badge .'">'. $row['team'] .'</span></td>';
                echo'<td>'. $row['room'] .'</td>';
                if($row['start'] != $row['end']){
                  echo'<td>'. $row['start'] .'</td>';
                  echo'<td>'. $row['end'] .'</td>';
                }
                if($row['start'] == $row['end']){
                  echo'<td colspan="2">'. $row['start'] .'</td>';
                }
                
              echo'</tr>';
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
                <th scope="col">Vorhaben</th>
                <th scope="col">Gruppe</th>
                <th scope="col">Raum</th>
                <th scope="col">Vom</th>
                <th scope="col">Bis zum</th>
              </tr>
            </thead>
            <tbody>
              <?php

                foreach(events::future() as $row){
                  switch ($row['team']){
                    case 'FISI19':
                      $group_badge = 'primary';
                      break;
                    case 'FISI20':
                      $group_badge = 'success';
                      break;
                    case 'BVB':
                      $group_badge = 'danger';
                      break;
                    default:
                      $group_badge = 'secondary';

                  }
                    echo'
              <tr>
                <td>'. $row['event'] .'</td>
                <td><span class="badge bg-'. $group_badge .'">'. $row['team'] .'</span></td>
                <td>'. $row['room'] .'</td>
                <td>'. $row['start'] .'</td>
                <td>'. $row['end'] .'</td>
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