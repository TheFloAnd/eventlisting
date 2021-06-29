<nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <a href="?b=main">
          <span class="navbar-text">
            <?php echo$lang['index'] ?>
          </span>
        </a>
      </div>
      <div class="col">
        <a href="?b=events">
          <span class="navbar-text">
            <?php echo$lang['events'] ?>
          </span>
        </a>
      </div>
    </div>
  </div>
</nav>
<article class="row">
    <section class="col">
        <div class="card">
            <div class="card-body">

                <nav>
                    <div class="nav nav-tabs justify-content-evenly" id="nav-tab" role="tablist">

                        <button class="nav-link col active" id="nav-group_create-tab" data-bs-toggle="tab" data-bs-target="#nav-group_create" type="button" role="tab" aria-controls="nav-group_create" aria-selected="false">
                            <?php echo$lang['group'] .' '. $lang['add'] ?>
                        </button>
                        <button class="nav-link col" id="nav-active_group-tab" data-bs-toggle="tab" data-bs-target="#nav-active_group" type="button" role="tab" aria-controls="nav-active_group" aria-selected="true">
                            <?php echo$lang['active'] .' '. $lang['groups'] ?>
                        </button>
                        <button class="nav-link col" id="nav-deactivated_group-tab" data-bs-toggle="tab" data-bs-target="#nav-deactivated_group" type="button" role="tab" aria-controls="nav-deactivated_group" aria-selected="false">
                            <?php echo$lang['inactive'] .' '. $lang['groups'] ?>
                        </button>
                    </div>
                </nav>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="nav-group_create" role="tabpanel" aria-labelledby="nav-group_create-tab">
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="row mt-3 g-3 justify-content-center">
                  <div class="col-md-10">
                    <fieldset>
                      <div class="form-floating">
                        <input type="text" class="form-control" name="group_name" id="group_name" placeholder="" required>
                        <label for="floatingInput">
                          <?php echo$lang['groups'] .' '. $lang['name'] ?>
                          <span style="color: red;">
                            *
                          </span>
                        </label>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-md-8">
                    <fieldset>
                      <div class="form-floating">
                        <input type="text" class="form-control" name="group_alias" id="group_alias" placeholder="" required>
                        <label for="floatingInput">
                          <?php echo$lang['groups'] .' '. $lang['alias'] ?>
                          <span style="color: red;">
                            *
                          </span>
                        </label>
                      </div>
                    </fieldset>
                  </div>

                  <div class="col-md-2">
                    <fieldset>
                      <div class="form-group">
                        <label for="floatingInput">
                          <?php echo$lang['groups'] .' '. $lang['color'] ?>
                          <span style="color: red;">
                            *
                          </span>
                        </label>
                        <input type="color" class="form-control form-control-color" name="group_color" id="group_color" placeholder="" required>
                      </div>
                    </fieldset>
                  </div>
                  
                  <div class="col-8">
                    <div class="form-group">
                      <button type="submit" class="btn btn-outline-success w-100" name="submit_group" value="submit">
                        <?php echo$lang['add'] ?>
                      </button>
                    </div>
                  </div>
                </div>
              </form>
                    </div>
                    <div class="tab-pane fade" id="nav-active_group" role="tabpanel" aria-labelledby="nav-active_group-tab">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="table-to-refresh">
                                <thead>
                                    <tr>
                                    <th scope="col"><?php echo$lang['alias'] ?></th>
                                    <th scope="col"><?php echo$lang['name'] ?></th>
                                    <th scope="col"><?php echo$lang['color'] ?></th>
                                    <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    use app\controller\group;
                                    foreach(group::show() as $group){
                                        if($group['active'] == 1){
                                            echo'
                                            <tr>
                                            
                                                <td>'. $group['alias'] .'</td>
                                                <td>'. $group['name'] .'</td>
                                                <td style="background-color:'. $group['color'] .';">'. $group['color'] .'</td>
                                                <td>
                                                  <a href="?b=group_edit&g='. $group['alias'] .'" type="button" class="btn btn-sm btn-secondary position-relative">
                                                    <i class="bi bi-gear-wide"></i>
                                                  </a>
                                                </td>
                                            </tr>';
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-deactivated_group" role="tabpanel" aria-labelledby="nav-deactivated_group-tab">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="table-to-refresh">
                                <thead>
                                    <tr>
                                    <th scope="col"><?php echo$lang['alias'] ?></th>
                                    <th scope="col"><?php echo$lang['name'] ?></th>
                                    <th scope="col"><?php echo$lang['color'] ?></th>
                                    <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach(group::show() as $group){
                                        if($group['active'] == 0){
                                            echo'
                                            <tr>
                                                <td><a href="?b=group_edit&g='. $group['alias'] .'">'. $group['alias'] .'</a></td>
                                                <td>'. $group['name'] .'</td>
                                                <td style="background-color:'. $group['color'] .';">'. $group['color'] .'</td>
                                                <td>
                                                  <a href="?b=group_edit&g='. $group['name'] .'" type="button" class="btn btn-sm btn-secondary position-relative">
                                                    <i class="bi bi-wrench"></i>
                                                  </a>
                                                </td>
                                            </tr>';
                                        }
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