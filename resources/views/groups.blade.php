<?php

use app\controller\group;

$group = GROUP::index();

require __DIR__ . '/../layout/navigation.php';
?>
<article class="row g-3">
  <section class="col-12">
    <div class="card">
      <div class="card-header">
        <nav class="navbar navbar-dark">
          <h1 class="header-primary">
            <?php echo lang['groups'] . ' ' . lang['add']; ?>
          </h1>
        </nav>
      </div>
      <div class="card-body">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="needs-validation" novalidate>
          <div class="row mt-3 g-3 justify-content-center">
            <div class="col-md-10">
              <fieldset>
                <div class="form-floating has-validation">
                  <input type="text" class="form-control" name="group_name" id="group_name" placeholder="<?php echo lang['groups'] . ' ' .  lang['name'] ?>" maxlength="100" required>
                  <label for="group_name">
                    <?php echo lang['groups'] . ' ' .  lang['name'] ?>
                    <span style="color: red;">
                      *
                    </span>
                  </label>
                  <div class="invalid-feedback">
                    <?php echo lang['invalide-group_name-input']; ?>
                  </div>
                </div>
              </fieldset>
            </div>
            <div class="col-md-8">
              <fieldset>
                <div class="form-floating">
                  <input type="text" class="form-control" name="group_alias" id="group_alias" placeholder="<?php echo lang['groups'] . ' ' .  lang['alias'] ?>" maxlength="10" required>
                  <label for="group_alias">
                    <?php echo lang['groups'] . ' ' .  lang['alias'] ?>
                    <span style="color: red;">
                      *
                    </span>
                  </label>
                  <div class="invalid-feedback">
                    <?php echo lang['invalide-group_name-input']; ?>
                  </div>
                </div>
              </fieldset>
            </div>

            <div class="col-md-2">
              <fieldset>
                <div class="form-group">
                  <label for="floatingInput">
                    <?php echo lang['groups'] . ' ' .  lang['color'] ?>
                    <span style="color: red;">
                      *
                    </span>
                  </label>
                  <input type="color" class="form-control form-control-color" name="group_color" id="group_color" value="<?php echo '#' . substr(str_shuffle(" 0123456789abcdef"), 6, 6); ?>" required>
                </div>
              </fieldset>
            </div>

            <div class="col-8">
              <div class="form-group">
                <button type="submit" class="btn btn-outline-success w-100" name="submit_group" value="submit">
                  <?php echo lang['add'] ?>
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Auflistung -->
  <section class="col-12">
    <div class="card">
      <div class="card-header">
        <nav class="navbar navbar-dark">
          <h1 class="header-primary">
            <?php echo lang['groups']; ?>
          </h1>
        </nav>
      </div>
      <div class="card-body">

        <nav>
          <div class="nav nav-tabs justify-content-evenly" id="nav-tab" role="tablist">
            <button class="nav-link col active" id="nav-active_group-tab" data-bs-toggle="tab" data-bs-target="#nav-active_group" type="button" role="tab" aria-controls="nav-active_group" aria-selected="true">
              <?php echo lang['active'] . ' ' .  lang['groups'] ?>
            </button>
            <button class="nav-link col" id="nav-deactivated_group-tab" data-bs-toggle="tab" data-bs-target="#nav-deactivated_group" type="button" role="tab" aria-controls="nav-deactivated_group" aria-selected="false">
              <?php echo lang['inactive'] . ' ' .  lang['groups'] ?>
            </button>
          </div>
        </nav>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="nav-active_group" role="tabpanel" aria-labelledby="nav-active_group-tab">
            <div class="table-responsive mt-2">
              <div class="my-2">
                Toggle column:
                <a class="toggle-vis" data-column="2">Farbe</a> -
                <a class="toggle-vis" data-column="3">Settings</a>
              </div>
              <table class="table dataTable_group_active table-striped table-hover mt-5" id="table-to-refresh">
                <thead>
                  <tr>
                    <th scope="col">
                      <?php echo lang['alias'] ?>
                    </th>
                    <th scope="col">
                      <?php echo lang['name'] ?>
                    </th>
                    <th scope="col">
                      <?php echo lang['color'] ?>
                    </th>
                    <th class="no-sort" scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($group['active'] as $active) {
                    echo '
                                            <tr>
                                            
                                                <td class="table_search">' . $active['alias'] . '</td>
                                                <td class="table_search">' . $active['name'] . '</td>
                                                <td style="background-color:' . $active['color'] . ';">' . $active['color'] . '</td>
                                                <td>
                                                  <a href="?b=group_edit&g=' . $active['alias'] . '" type="button" class="btn btn-sm btn-secondary position-relative">
                                                    <i class="bi bi-gear-wide"></i>
                                                  </a>
                                                </td>
                                            </tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="nav-deactivated_group" role="tabpanel" aria-labelledby="nav-deactivated_group-tab">
            <div class="table-responsive mt-2">
              <div class="my-2">
                Toggle column:
                <a class="toggle-vis" data-column="2">Farbe</a> -
                <a class="toggle-vis" data-column="3">Settings</a>
              </div>
              <table class="table dataTable_group_inactive table-striped table-hover" id="table-to-refresh">
                <thead>
                  <tr>
                    <th scope="col">
                      <?php echo lang['alias'] ?>
                    </th>
                    <th scope="col">
                      <?php echo lang['name'] ?>
                    </th>
                    <th scope="col">
                      <?php echo lang['color'] ?>
                    </th>
                    <th class="no-sort"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($group['inactive']  as $inactive) {
                    echo '
                                            <tr>
                                                <td class="table_search">' . $inactive['alias'] . '</td>
                                                <td class="table_search">' . $inactive['name'] . '</td>
                                                <td style="background-color:' . $inactive['color'] . ';">' . $inactive['color'] . '</td>
                                                <td>
                                                  <a href="?b=group_edit&g=' . $inactive['alias'] . '" type="button" class="btn btn-sm btn-secondary position-relative">
                                                    <i class="bi bi-gear-wide"></i>
                                                  </a>
                                                </td>
                                            </tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

</article>