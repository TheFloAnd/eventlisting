<?php 
use app\controller\config;
$setting = config::find($_GET['id']);
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
                <input type="text" class="form-control" name="setting_id" id="setting_id"
                  value="<?php echo$setting->id ?>">
              </div>
            </fieldset>
            <div class="col-md-10">
              <fieldset id="input_name">
                <div class="form-floating">
                  <input type="text" class="form-control" name="setting_name" id="setting_name"
placeholder="<?php echo ucwords($setting->view) ?: ucwords( lang['settings']) ?>"
                    value="<?php echo ucwords($setting->view) ?>" required disabled>
                  <label for="setting_name">
<?php echo lang['settings'] ?>
                    <span style="color: red;">
                      *
                    </span>
                  </label>
                </div>
              </fieldset>
            </div>
            <?php
                    if($setting->setting == 'future_day'){
                      echo'<div class="col-md-10">
                    <div class="row g-3">
                      <div class="col-md-8">
                    <fieldset id="input_name">
                      <div class="form-floating">
                        <input type="text" class="form-control" name="setting_value" id="setting_value" placeholder="'. $setting->value .'" value="'. $setting->value .'" required>
                        <label for="setting_value">
'. lang['value'] .'
                          <span style="color: red;">
                            *
                          </span>
                        </label>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-md-4">
                    <fieldset id="input_name">
                      <div class="form-floating">
                        <select class="form-select" id="time_unit" name="time_unit" aria-label="Einheit">';
              if($setting->time_unit == 'day'){
                echo'<option value="day">in Tagen</option>';
                echo'<option value="week">in Wochen</option>';
              }
              if($setting->time_unit == 'week'){
                echo'<option value="week">in Wochen</option>';
                echo'<option value="day">in Tagen</option>';
              }
                        echo'</select>
                        <label for="time_unit">Einheit</label>
                      </div>
                    </fieldset>
                  </div>
                  </div>
                  </div>';
                    }else{
                      echo'<div class="col-md-10">
                    <fieldset id="input_name">
                      <div class="form-floating">
                        <input type="text" class="form-control" name="setting_value" id="setting_value" placeholder="'. $setting->value.'" value="'. $setting->value .'" required>
                        <label for="setting_value">
'. lang['value'] .'
                          <span style="color: red;">
                            *
                          </span>
                        </label>
                      </div>
                    </fieldset>
                  </div>';
                    }
                  ?>

            <div class="col-md-10">
              <div class="row g-2 justify-content-evenly">
                <div class="col-8">
                  <div class="form-group">
                    <button type="submit" class="btn btn-outline-success w-100" name="submit_edit_setting"
                      value="submit">
<?php echo lang['update'] ?>
                    </button>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <a type="button" class="btn btn-outline-secondary w-100" href="?b=settings">
<?php echo lang['back'] ?>
                    </a>
                  </div>
                </div>
              </div>
            </div>
        </form>
      </div>
    </div>
  </section>
</article>