<h1 id="reloading"><?php echo date('d.m.Y - H:i:s'); ?></h1>
<article>
    <section>
        <table class="table table-striped table-hover" id="table-to-refresh">
            <thead>
              <tr>
                <th scope="col">Vorhaben</th>
                <th scope="col">Vom</th>
                <th scope="col">Bis zum</th>
              </tr>
            </thead>
            <tbody>
              <?php

                use app\controller\events;
                require './app/controller/events.controller.php';

                foreach(events::index() as $row){
                    echo'
              <tr>
                <td>'. $row['event'] .'</td>
                <td>'. $row['start'] .'</td>
                <td>'. $row['end'] .'</td>
              </tr>';
                  }
              ?>
            </tbody>
        </table>
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
    }, 60 * 1000)
}
</script>