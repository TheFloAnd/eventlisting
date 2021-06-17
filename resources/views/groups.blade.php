<nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <a href="?b=main">
          <span class="navbar-text">
            Hauptseite
          </span>
        </a>
      </div>
      <div class="col">
        <a href="?b=create">
          <span class="navbar-text">
            Hinzufügen
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
                            Gruppe Hinzufügen
                        </button>
                        <button class="nav-link col" id="nav-active_group-tab" data-bs-toggle="tab" data-bs-target="#nav-active_group" type="button" role="tab" aria-controls="nav-active_group" aria-selected="true">
                            Aktive Gruppen
                        </button>
                        <button class="nav-link col" id="nav-deactivated_group-tab" data-bs-toggle="tab" data-bs-target="#nav-deactivated_group" type="button" role="tab" aria-controls="nav-deactivated_group" aria-selected="false">
                            Deaktivierte Gruppen
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
                          Gruppen Name
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
                          Gruppen Alias
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
                          Gruppen Farbe
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
                        Hinzufügen
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
                                    <th scope="col">Alias</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Farbe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    use app\controller\group;
                                    foreach(group::show() as $group){
                                        if($group['active'] == 1){
                                            echo'
                                            <tr>
                                            
                                                <td><a href="?b=group_edit&g='. $group['alias'] .'">'. $group['alias'] .'</a></td>
                                                <td>'. $group['name'] .'</td>
                                                <td style="background-color:'. $group['color'] .';">'. $group['color'] .'</td>
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
                                    <th scope="col">Alias</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Farbe</th>
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