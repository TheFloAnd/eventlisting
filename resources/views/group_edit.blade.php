<?php 
use app\controller\group;
$group = group::find($_GET['g']);

if($group->deleted_at != 'NULL'){
    $checked = 'checked';
}else{
    $checked = '';
}
require __DIR__ . '/../layout/navigation.php';
?>
<article class="row">
  <section class="col">
    <div class="card">
      <div class="card-body">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
          <div class="row mt-3 g-3 justify-content-center">
            <fieldset class="" hidden>
              <div class="form-group">
                <input type="text" class="form-control" name="id" id="group_id" value="<?php echo$group->id ?>">
              </div>
            </fieldset>
            <fieldset class="" hidden>
              <div class="form-group">
                <input type="text" class="form-control" name="alias" id="alias" value="<?php echo$group->alias ?>">
              </div>
            </fieldset>
            <div class="col-md-10">
              <fieldset>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="deactivate_group" id="deactivate_group"
                    value="1" <?php echo$checked; ?>>
                  <label class="form-check-label" for="deactivate_group">
                    <?php echo lang['active'] .' '.  lang['group'] ?>
                  </label>
                </div>
              </fieldset>
            </div>
            <div class="col-md-10">
              <fieldset id="input_name">
                <div class="form-floating">
                  <input type="text" class="form-control disable" name="group_name" id="group_name"
                    placeholder="<?php echo$group->name ?:  lang['groups'] .' '.  lang['name'] ?>"
                    value="<?php echo$group->name ?>" required>
                  <label for="group_name">
                    <?php echo lang['groups'] .' '.  lang['name'] ?>
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
                  <input type="text" class="form-control" name="group_alias" id="group_alias"
                    placeholder="<?php echo $group->alias ?:  lang['groups'] .' '.  lang['alias'] ?>"
                    value="<?php echo $group->alias ?>" required disabled>
                  <label for="group_alias">
                    <?php echo lang['groups'] .' '.  lang['alias'] ?>
                    <span style="color: red;">
                      *
                    </span>
                  </label>
                </div>
              </fieldset>
            </div>

            <div class="col-md-2">
              <fieldset id="input_color">
                <div class="form-group">
                  <label for="group_color">
                    <?php echo lang['groups'] .' '.  lang['color'] ?>
                    <span style="color: red;">
                      *
                    </span>
                  </label>
                  <input type="color" class="form-control form-control-color disable" name="group_color"
                    id="group_color" placeholder="<?php echo $group->color ?>" value="<?php echo $group->color ?>"
                    required>
                </div>
              </fieldset>
            </div>

            <div class="col-md-10">
              <div class="row g-2 justify-content-evenly">
                <div class="col-8">
                  <div class="form-group">
                    <button type="submit" class="btn btn-outline-success w-100" name="submit_edit_group" value="submit">
                      <?php echo lang['update'] ?>
                    </button>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <a type="button" class="btn btn-outline-secondary w-100" href="?b=groups">
                      <?php echo lang['back'] ?>
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
  var toogle_disable = document.getElementById("deactivate_group");
  var disable = document.getElementsByClassName('disable');
  if(toogle_disable.checked != true){
    for(var i = 0; i < disable.length; i++){
      disable[i].disabled=true;
      disable[i].readOnly=true;
    }
  }
  toogle_disable.onchange=function() {
    if(toogle_disable.checked!=true){
      for(var i=0; i < disable.length; i++){
        disable[i].disabled=true;
        disable[i].readOnly=true;
      }
    }else{
      for(var i=0; i < disable.length; i++){
        disable[i].disabled=false;
        disable[i].readOnly=false;
      }
    }
  }
</script>