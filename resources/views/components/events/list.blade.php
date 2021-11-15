<?php
use app\controller\events;
use app\controller\group;

$events = events::index();
?>
<div class="table-responsive">
    <table class="table table-striped table-hover" id="refresh_edit">
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
                          if(strftime('%H:%M', strtotime($row['start'])) == strftime('%H:%M', strtotime($row['end']))){
                          
                          if(strftime('%H:%M', strtotime($row['start'])) == '00:00'){
                          echo'<td colspan="2">'. strftime('%d.%m.%Y ', strtotime($row['start'])) .'</td>';
                          }else{
                          echo'<td colspan="2">'. strftime('%d.%m.%Y - %H:%M', strtotime($row['start'])) .'</td>';
                          }
                          }
                          if(strftime('%H:%M', strtotime($row['start'])) != strftime('%H:%M', strtotime($row['end']))){
                          if(strftime('%H:%M', strtotime($row['start'])) == '00:00'){
                          echo'<td>'. strftime('%d.%m.%Y', strtotime($row['start'])) .'</td>';
                          }else{
                          echo'<td>'. strftime('%d.%m.%Y - %H:%M', strtotime($row['start'])) .'</td>';
                          }
                          if(strftime('%H:%M', strtotime($row['end'])) == '00:00'){
                          echo'<td>'. strftime('%d.%m.%Y', strtotime($row['end'])) .'</td>';
                          }else{
                          echo'<td>'. strftime('%H:%M', strtotime($row['end'])) .'</td>';
                          }
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