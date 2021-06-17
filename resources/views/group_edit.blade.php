<?php 
use app\controller\group;
$group = group::show_group($_GET['g']);
?>
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
      <div class="col">
        <a href="?b=groups">
          <span class="navbar-text">
            Gruppen
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
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="row mt-3 g-3 justify-content-center">
                <div class="col-md-10">
                    <fieldset>
                        <div class="form-check">
                        <?php
                        if($group['active'] == 1){
                            $checked = 'checked';
                        }else{
                            $checked = '';
                        }
                        ?>
                            <input class="form-check-input" type="checkbox" name="deactivate_group" id="deactivate_group" value="1" <?php echo$checked; ?>>
                            <label class="form-check-label" for="deactivate_group">
                                Aktiviert
                            </label>
                        </div>
                    </fieldset>
                  </div>
                  <div class="col-md-10">
                    <fieldset>
                      <div class="form-floating">
                        <input type="text" class="form-control" name="group_name" id="group_name" placeholder="" value="<?php echo$group['name'] ?>" required>
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
                        <input type="text" class="form-control" name="group_alias" id="group_alias" placeholder="" value="<?php echo $group['alias'] ?>" required readonly deactivated>
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
                        <input type="color" class="form-control form-control-color" name="group_color" id="group_color" placeholder="" value="<?php echo $group['color'] ?>" required>
                      </div>
                    </fieldset>
                  </div>
                  
                  <div class="col-8">
                    <div class="form-group">
                      <button type="submit" class="btn btn-outline-success w-100" name="submit_edit_group" value="submit">
                        Ändern
                      </button>
                    </div>
                  </div>
                </div>
              </form>          
            </div>
        </div>
    </section>
</article>