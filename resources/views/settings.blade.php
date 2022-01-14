<?php
require __DIR__ . '/../layout/navigation.php';
?>
<article class="row g-3">
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

              foreach (config::index() as $row) {
                echo '
                            <tr>
                              <td>';
                switch ($row['time_unit']) {
                  case 'day':
                    $output_time_unit = lang['meet'];
                    break;
                  case 'week':
                    $output_time_unit = lang['weeks'];
                    break;
                  case 'seconds':
                    $output_time_unit = lang['seconds'];
                    break;
                  default:
                    $output_time_unit = '';
                }

                switch ($row['setting']) {
                  case 'refresh':
                    echo lang['setting-refresh'];
                    break;
                  case 'future_day':
                    echo lang['setting-future_day'];
                    break;
                  case 'name':
                    echo lang['setting-name'];
                    break;
                  case 'language':
                    echo lang['setting-language'];
                    break;
                  case 'design':
                    echo lang['setting-design'];
                    break;
                  case 'protection':
                    echo lang['password'];
                    break;
                }
                echo '</td>
                              <td>';

                if ($row['setting'] != 'protection') {
                if ($row['setting'] == 'design') {
                }
                switch ($row['value']) {
                  case 'light':
                    echo lang['light'];
                    break;
                  case 'dark':
                    echo lang['dark'];
                    break;
                  default:
                    echo $row['value'] . ' ' . $output_time_unit;
                }
              }

                echo '</td>';
                echo '<td data-bs-toggle="tooltip" data-bs-placement="top" title="' . lang['edit'] . '">
                            <a href="?b=settings_edit&id=' . $row['id'] . '" type="button" class="btn btn-sm btn-secondary position-relative">
                              <i class="bi bi-gear-wide"></i>
                            </a>
                          </td>';
              }
              echo '</tr>';
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
        <?php echo lang['database'] ?>:
      </div>
      <div class="card-body">
        <div class="btn-group btn-group-vertical w-100" role="group" aria-label="Basic checkbox toggle button group">
          <input type="button" class="btn-check" id="table_events" data-bs-toggle="modal" data-bs-target="#modal_table" data-bs-whatever="<?php echo lang['events'] ?>">
          <label class="btn btn-outline-danger" for="table_events"><?php echo lang['events'] ?></label>

          <input type="button" class="btn-check" id="table_groups" data-bs-toggle="modal" data-bs-target="#modal_table" data-bs-whatever="<?php echo lang['groups'] ?>">
          <label class="btn btn-outline-danger" for="table_groups"><?php echo lang['groups'] ?></label>
        </div>
      </div>
    </div>

  </section>
</article>
<div class="modal fade" id="modal_table" tabindex="-1" aria-labelledby="modal_tableLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_tableLabel"><?php echo lang['delete'] ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3 mb-2">
            <div class="col-12">
              <div class="row mb-2">
                <div class="col-auto mx-0">
                  <label class="form-check-label" for="table_empty">
                    <?php echo lang['delete'] ?>
                  </label>
                </div>
                <div class="col-auto mx-0">
                  <div class="form-check form-switch">
                    <input class=" form-check-input" type="checkbox" value="1" name="table_empty" id="table_empty" checked>
                  </div>
                </div>
                <div class="col-auto mx-0">

                  <label class="form-check-label" for="table_empty">
                    <?php echo lang['to_empty'] ?>
                  </label>
                </div>
              </div>
            </div>
            <div class="col-12">

              <fieldset>
                <div class="form-group">
                  <input class="input_table" id="modal_table_input" value="" name="modal_table_input" readOnly>
                </div>
              </fieldset>
            </div>
            <div class="col-12">
              <p>
                <?php echo lang['delete_table'] ?>
              </p>
              <span>
                <?php echo lang['delete_table-info'] ?>
              </span>
            </div>
          </div>
            <div class="col-12 mb-2">

              <fieldset>
                <div class="form-floating">
                  <input type="password" class="form-control" name="protection_pass" id="protection_pass" placeholder="Password">
                  <label for="protection_pass">Password</label>
                </div>
              </fieldset>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo lang['close'] ?></button>
            <button type="submit" class="btn btn-danger" name="tabel_renew"><?php echo lang['submit'] ?></button>
          </div>
      </form>
    </div>
  </div>
</div>
<script>
  var modal_table = document.getElementById('modal_table')
  modal_table.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var table = button.getAttribute('data-bs-whatever')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var modalTitle = modal_table.querySelector('.modal-title')
    var modalBodyInput = modal_table.querySelector('.modal-body .input_table')

    modalTitle.textContent = '<?php echo lang['database-table'] ?>: ' + table
    modalBodyInput.value = table
  })
</script>