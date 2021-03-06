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
                <input type="text" class="form-control" name="setting_id" id="setting_id" value="<?php echo $setting->id ?>">
                <input type="text" class="form-control" name="setting" id="setting" value="<?php echo $setting->setting ?>">
              
              </div>
            </fieldset>
            <div class="col-md-10">
              <fieldset id="input_name">
                <div class="form-floating">
                  <?php
                  switch ($setting->setting) {
                    case 'refresh':
                      $setting_title = lang['setting-refresh'];
                      break;
                    case 'future_day':
                      $setting_title = lang['setting-future_day'];
                      break;
                    case 'name':
                      $setting_title = lang['setting-name'];
                      break;
                    case 'language':
                      $setting_title = lang['setting-language'];
                      break;
                    case 'design':
                      $setting_title = lang['setting-design'];
                      break;
                    case 'protection':
                      $setting_title = lang['password'];
                      break;
                  }
                  ?>
                  <input type="text" class="form-control" name="setting_name" id="setting_name" placeholder="<?php echo ucwords($setting_title) ?: ucwords(lang['settings']) ?>" value="<?php echo ucwords($setting_title) ?>" required disabled>
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
            if ($setting->setting == 'future_day') {
              echo '<div class="col-md-10">
                    <div class="row g-3">
                      <div class="col-md-8">
                    <fieldset id="input_name">
                      <div class="form-floating">
                        <input type="text" class="form-control show_length" name="setting_value" id="setting_value" placeholder="' . $setting->value . '" value="' . $setting->value . '" maxlength="3" required>
                        <label for="setting_value">
' . lang['value'] . '
                          <span style="color: red;">
                            *
                          </span>
                        <span id="setting_value_label" class="label"></span>
                        </label>
                        <div class="invalid-feedback">
                          ' . lang['invalide-settings_value-input'] . '
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-md-4">
                    <fieldset id="input_name">
                      <div class="form-floating">
                        <select class="form-select" id="time_unit" name="time_unit" aria-label="' . lang['unit'] . '">';
              if ($setting->time_unit == 'day') {
                echo '<option value="day">' . lang['days'] . '</option>';
                echo '<option value="week">' . lang['weeks'] . '</option>';
              }
              if ($setting->time_unit == 'week') {
                echo '<option value="week">' . lang['weeks'] . '</option>';
                echo '<option value="day">' . lang['days'] . '</option>';
              }
              echo '</select>
                        <label for="time_unit">' . lang['unit'] . '</label>
                      </div>
                    </fieldset>
                  </div>
                  </div>
                  </div>';
            }
            if ($setting->setting == 'name') {
              echo '<div class="col-md-10">
                    <fieldset id="input_name">
                      <div class="form-floating has-validation">
                        <input type="text" class="form-control show_length" name="setting_value" id="setting_value" placeholder="' . $setting->value . '" value="' . $setting->value . '" maxlength="50" required>
                        <label for="setting_value">
' . lang['value'] . '
                          <span style="color: red;">
                            *
                          </span>
                          <span id="setting_value_label" class="label"></span>
                        </label>
                        <div id="setting_value_label" class="label">
                        </div>
                        <div class="invalid-feedback">
                          ' . lang['invalide-settings_value-input'] . '
                        </div>
                      </div>
                    </fieldset>
                  </div>';
            }
            if ($setting->setting == 'refresh') {
              echo '<div class="col-md-10">
                      <fieldset id="input_name">
                        <div class="form-floating has-validation">
                          <input type="text" class="form-control" name="setting_value" id="setting_value" placeholder="' . $setting->value . '"
                            value="' . $setting->value . '" maxlength="4" required>
                          <label for="setting_value">
                            ' . lang['value'] . '
                            <span style="color: red;">
                              *
                            </span>
                          </label>
                        <div class="invalid-feedback">
                          ' . lang['invalide-settings_value-input'] . '
                        </div>
                        </div>
                      </fieldset>
                    </div>';
            }

            if ($setting->setting == 'language') {
              echo '<div class="col-md-10">
                      <fieldset id="input_name">
                      <div class="form-floating">
                        <select class="form-select" id="setting_value" name="setting_value" aria-label="Sprache">';
              // var_dump(config::language());

              foreach (config::language() as $lang) {
                $setting->value == $lang['code'] ? $selected = 'selected' : $selected = '';
                echo '<option value="' . $lang['code'] . '" ' . $selected . '>' . lang[$lang['code']] . '</option>';
              }
              echo '</select>
                        <label for="setting_value">' . lang['value'] . '</label>
                      </div>
                    </div>';
            }



            if ($setting->setting == 'design') {
              if ($setting->value == 'light') {
                $check_light = "checked";
                $check_dark = "";
              }

              if ($setting->value == 'dark') {
                $check_light = "";
                $check_dark = "checked";
              }
              echo '<div class="col-md-10">
                      <fieldset id="input_name">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="setting_value" id="setting_value_design-1" value="light" ' . $check_light . '>
                          <label class="form-check-label" for="setting_value_design-1">
                            ' . $lang['light'] . '
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="setting_value" id="setting_value_design-2" value="dark" ' . $check_dark . '>
                          <label class="form-check-label" for="setting_value_design-1">
                            ' . $lang['dark'] . '
                          </label>
                        </div>
                    </div>';
            }


            if ($setting->setting == 'protection') {
              echo '<div class="col-md-10 mb-5">
              <fieldset>
                <div class="form-floating">
                  <input type="password" class="form-control" name="protection_pass" id="protection_pass" placeholder="' . lang['password'] . '" required>
                  <label for="protection_pass">' . lang['password'] . '</label>
                </div>
              </fieldset>
            </div>
            <div class="col-md-10">
              <fieldset>
                <div class="form-floating">
                  <input type="password" class="form-control" name="setting_value" id="setting_value" placeholder="' . lang['password_new'] . '" required>
                  <label for="protection_pass">' . lang['password_new'] . '</label>
                </div>
              </fieldset>
            </div>
            <div class="col-md-10">
              <fieldset>
                <div class="form-floating">
                  <input type="password" class="form-control" name="setting_value_2" id="setting_value_2" placeholder="' . lang['password_new'] . ' ' . lang['repeat'] . '" required>
                  <label for="protection_pass">' . lang['password_new'] . ' ' . lang['repeat'] . '</label>
                </div>
              </fieldset>
            </div>';
            }
            ?>

            <div class="col-md-10">
              <div class="row g-2 justify-content-evenly">
                <div class="col-8">
                  <div class="form-group">
                    <button type="submit" class="btn btn-outline-success w-100" name="submit_edit_setting" value="submit">
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
</script>