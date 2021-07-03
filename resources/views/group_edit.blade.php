<?php 
use app\controller\group;
$group = group::find($_GET['g']);

if($group->active == 1){
    $checked = 'checked';
    $disabled = '';
}else{
    $checked = '';
    $disabled = 'disabled';
}
?>
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
      <div class="col">
        <a href="?b=groups">
          <span class="navbar-text">
            <?php echo$lang['groups'] ?>
          </span>
        </a>
      </div>
      <div class="col">
        <a href="?b=settings">
          <span class="navbar-text">
            <?php echo$lang['settings'] ?>
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
                            <input class="form-check-input" type="checkbox" name="deactivate_group" id="deactivate_group" value="1" <?php echo$checked; ?>>
                            <label class="form-check-label" for="deactivate_group">
                                <?php echo$lang['active'] .' '. $lang['group'] ?>
                            </label>
                        </div>
                    </fieldset>
                  </div>
                  <div class="col-md-10">
                    <fieldset id="input_name" <?php echo$disabled ?>>
                      <div class="form-floating">
                        <input type="text" class="form-control" name="group_name" id="group_name" placeholder="<?php echo$group->name ?: $lang['groups'] .' '. $lang['name'] ?>" value="<?php echo$group->name ?>" required>
                        <label for="group_name">
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
                        <input type="text" class="form-control" name="group_alias" id="group_alias" placeholder="<?php echo $group->alias ?: $lang['groups'] .' '. $lang['alias'] ?>" value="<?php echo $group->alias ?>" required deactivated>
                        <label for="group_alias">
                          <?php echo$lang['groups'] .' '. $lang['alias'] ?>
                          <span style="color: red;">
                            *
                          </span>
                        </label>
                      </div>
                    </fieldset>
                  </div>

                  <div class="col-md-2">
                    <fieldset id="input_color" <?php echo$disabled ?>>
                      <div class="form-group">
                        <label for="group_color">
                          <?php echo$lang['groups'] .' '. $lang['color'] ?>
                          <span style="color: red;">
                            *
                          </span>
                        </label>
                        <input type="color" class="form-control form-control-color" name="group_color" id="group_color" placeholder="<?php echo $group->color ?>" value="<?php echo $group->color ?>" required>
                      </div>
                    </fieldset>
                  </div>
                  
                  <div class="col-md-10">
                    <div class="row g-2 justify-content-evenly">
                      <div class="col-8">
                        <div class="form-group">
                          <button type="submit" class="btn btn-outline-success w-100" name="submit_edit_group" value="submit">
                            <?php echo$lang['update'] ?>
                          </button>
                        </div>
                      </div>
                      <div class="col-4">
                          <div class="form-group">
                              <a type="button" class="btn btn-outline-secondary w-100" href="?b=groups">
                                  <?php echo$lang['back'] ?>
                              </a>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>          
            </div>
        </div>
    </section>
</article>
    <script>
        var disable = document.getElementById("deactivate_group");
        var input_name = document.getElementById("input_name");
        var input_color = document.getElementById("input_color");

        disable.onchange = function () {
          if (input_name.hasAttribute('disabled')) {
            input_name.disabled = false;
          } else {
            input_name.disabled = true;
          }

          if (input_color.hasAttribute('disabled')) {
            input_color.disabled = false;
          } else {
            input_color.disabled = true;
          }
        };
    </script>