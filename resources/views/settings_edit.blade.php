<?php 
use app\controller\config;
$setting = config::find($_GET['id']);
require __DIR__ . '/../layout/navigation.php';
?>
<article class="row">
  <section class="col">
    <div class="card">
      <div class="card-body">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="needs-validation" novalidate>
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
                        <input type="text" class="form-control" name="setting_value" id="setting_value" placeholder="'. $setting->value .'" value="'. $setting->value .'" maxlength="50" required>
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
                    }
                    if($setting->setting == 'name'){
                      echo'<div class="col-md-10">
                    <fieldset id="input_name">
                      <div class="form-floating has-validation">
                        <input type="text" class="form-control" name="setting_value" id="setting_value" placeholder="'. $setting->value.'" value="'. $setting->value .'" maxlength="50" required>
                        <label for="setting_value">
'. lang['value'] .'
                          <span style="color: red;">
                            *
                          </span>
                          <span id="setting_value_label" class="label"></span>
                        </label>
                        <div id="setting_value_label" class="label">
                        </div>
                        <div class="invalid-feedback">
                          Bitte geben sie einen Wert an (Maximal 50 Zeichen länge)!
                        </div>
                      </div>
                    </fieldset>
                  </div>';
                    }
                    if($setting->setting == 'refresh'){
                    echo'<div class="col-md-10">
                      <fieldset id="input_name">
                        <div class="form-floating has-validation">
                          <input type="text" class="form-control" name="setting_value" id="setting_value" placeholder="'. $setting->value.'"
                            value="'. $setting->value .'" maxlength="50" required>
                          <label for="setting_value">
                            '. lang['value'] .'
                            <span style="color: red;">
                              *
                            </span>
                          </label>
                          <div class="invalid-feedback">
                            Bitte geben sie einen Wert an!
                          </div>
                        </div>
                      </fieldset>
                    </div>';
                    }
                    
                    if($setting->setting == 'language'){
                    echo'<div class="col-md-10">
                      <fieldset id="input_name">
                      <div class="form-floating">
                        <select class="form-select" id="setting_value" name="setting_value" aria-label="Sprache">';
                          // var_dump(config::language());
                          foreach(config::language() as $lang){
                            $setting->value == $lang['code'] ? $selected = 'selected' : $selected = '';
                            echo'<option value="'. $lang['code'] .'" '. $selected .'>'. $lang['view'] .'</option>';
                          }
                          echo'</select>
                        <label for="setting_value">Spache</label>
                      </div>
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
<script>
  setting_value = document.getElementById('setting_value');
  setting_value_label = document.getElementById('setting_value_label');
  setting_value_label.innerHTML = setting_value.value.length + ' von 50';
  setting_value.addEventListener('input', input_change);

  function input_change(e){
    setting_value_label.innerHTML = e.target.value.length + ' von 50';
    if(e.target.value.length >= 30){
      setting_value_label.style.color = 'orange';
    }
    if(e.target.value.length >= 45){
      setting_value_label.style.color = 'red';
    }
    if(e.target.value.length < 30){
      setting_value_label.style.color='green' ;
    }
  }
</script>