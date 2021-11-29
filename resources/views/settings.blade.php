<?php
require __DIR__ . '/../layout/navigation.php';
?>
<article class="row">
  <section class="col">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover" id="table-to-refresh">
            <thead>
              <tr>
                <th scope="col">
                  <?php echo lang['settings'] ?>
                </th>
                <th scope="col">
                  <?php echo lang['value'] ?>
                </th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php
                        use app\controller\config;
                        foreach(config::index() as $row){
                        echo'
                            <tr>
                              <td>';
              switch ($row['time_unit']){
                case 'day':
                  $output_time_unit = 'Tagen';
                  break;
                case 'week':
                  $output_time_unit = 'Wochen';
                  break;
                case 'seconds':
                  $output_time_unit = 'Sekunden';
                  break;
                default:
                  $output_time_unit = '';
                }
                                echo ucwords($row['view']);
                                echo'</td>
                              <td>
                                '. $row['value'] .' '. $output_time_unit .'
                              </td>';
                          echo'<td>
                            <a href="?b=settings_edit&id='. $row['id'] .'" type="button" class="btn btn-sm btn-secondary position-relative">
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
  </section>
</article>