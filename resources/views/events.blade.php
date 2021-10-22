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
          <nav>
            <div class="nav nav-tabs justify-content-evenly" id="nav-tab" role="tablist">
              <button class="nav-link col active" id="nav-event_add-tab" data-bs-toggle="tab" data-bs-target="#nav-event_add" type="button" role="tab" aria-controls="nav-event_add" aria-selected="false">
                <?php echo$lang['event'] .' '. $lang['add'] ?>
              </button>
              <button class="nav-link col" id="nav-event_edit-tab" data-bs-toggle="tab" data-bs-target="#nav-event_edit" type="button" role="tab" aria-controls="nav-event_edit" aria-selected="true">
                <?php echo$lang['events'] .' '. $lang['edit'] ?>
              </button>
            </div>
          </nav>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="nav-event_add" role="tabpanel" aria-labelledby="nav-event_add-tab">
              <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="row mt-3 g-3 justify-content-center">
                  <div class="col-md-10">
                    <fieldset>
                      <div class="form-floating">
                        <input type="text" class="form-control" name="event" id="event" placeholder="<?php echo$lang['event'] ?>" list="event_list" required>
                        <label for="event">
                            <?php echo$lang['event'] ?>
                          <span style="color: red;">
                            *
                          </span>
                        </label>
                        <datalist id="event_list">
                          <?php
                          use app\controller\events;
                          foreach(events::proposals() as $row){
                            echo'<option value="'. $row['event'] .'">';
                          }
                          ?>
                        </datalist>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-md-10">
                    <div class="row g-3" id="groups">
                      <div class="col-12">
                        <fieldset>
                          <div class="form-floating input-group">
                            <select class="form-select" name="group" id="group" aria-label="Floating label select example" required>
                              <?php
                                use app\controller\group;
                                foreach(group::index('v_teams_active') as $row){
                                    echo'<option value="'. $row['alias'] .'">'. $row['name'] .' ('. $row['alias'] .')</option>';
                                }
                              ?>
                            </select>
                              <label for="group">
                              <?php echo$lang['group'] ?>
                            <span style="color: red;">
                              *
                              </span>
                            </label>
                      </div>
                    </fieldset>
                  </div>
                  <!--
                  <div class="col-1">
                      <button type="button" class="btn btn-secondary" onclick="add_group()">
                        <i class="bi bi-plus"></i>
                      </button>
                  </div>
                -->
                </div>
              </div>
                  <div class="col-md-10">
                    <div class="row">
                  <div class="col-md-3">
                    <fieldset>
                      <div class="form-floating">
                        <input type="text" class="form-control" name="room" id="room" placeholder="<?php echo$lang['room'] ?>">
                        <label for="room">
                          <?php echo$lang['room'] ?>
                        </label>
                      </div>
                    </fieldset>
                  </div>
                  </div>
                  </div>
                  <div class="col-md-5">
                    <fieldset>
                      <div class="form-floating">
                        <input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo date("Y-m-d") ?>" required>
                        <label for="start_date">
                          <?php echo$lang['start'] .' '. $lang['date'] ?>
                          <span style="color: red;">
                            *
                          </span>
                        </label>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-md-5">
                    <fieldset>
                      <div class="form-floating">
                        <input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo date("Y-m-d") ?>" required>
                        <label for="end_date">
                          <?php echo$lang['end'] .' '. $lang['date'] ?>
                          <span style="color: red;">
                            *
                          </span>
                        </label>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-md-10">
                    <fieldset>
                      <div class="form-group">
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" id="set_repeat" name="set_repeat" data-toggle="toggle" autocomplete="off">
                          <label class="form-check-label" for="set_repeat">
                            <?php echo$lang['repeat'] ?>
                          </label>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <fieldset id="set_repeat_input_1" disabled>
                            <label class="form-label" for="days">
                              <?php echo$lang['days'] ?> :
                            </label>
                            <input class="form-control" type="number" placeholder="<?php echo$lang['days'] ?>" min="0" name="repeat_days" id="repeat_days">
                          </fieldset>
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <fieldset id="set_repeat_input_2" disabled>
                            <label class="form-label" for="repeats">
                              <?php echo$lang['repeat'] ?> :
                            </label>
                            <input class="form-control" type="number" placeholder="<?php echo$lang['repeat'] ?>" min="0" name="repeats" id="repeats">
                          </fieldset>
                        </div>
                      </div>
                      
                  <div class="col-8">
                    <div class="form-group">
                      <button type="submit" class="btn btn-outline-success w-100" name="submit_event" value="submit">
                        <?php echo$lang['add'] ?>
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>

            <div class="tab-pane fade" id="nav-event_edit" role="tabpanel" aria-labelledby="nav-event_edit-tab">
              <div class="table-responsive">
                  <table class="table table-striped table-hover" id="table-to-refresh">
                      <thead>
                        <tr>
                          <th scope="col"><?php echo$lang['project'] ?></th>
                          <th scope="col"><?php echo$lang['group'] ?></th>
                          <th scope="col"><?php echo$lang['room'] ?></th>
                          <th scope="col"><?php echo$lang['from'] ?></th>
                          <th scope="col"><?php echo$lang['till'] ?></th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach(events::show() as $row){
                        if($row['not_applicable'] == 1){
                          $disabled = 'class="table-danger strikeout"';
                        }else{
                          $disabled = '';
                        }
                        echo'
                            <tr '.$disabled.'>
                              <td>
                                '. $row['event'] .'
                              </td>';
                          echo'<td>
                              <span class="badge text-dark" style="background-color:'. $row['team_color'] .';">
                                '. $row['team'] .'
                              </span>
                            </td>';
                          echo'<td>
                              '. $row['room'] .'
                            </td>';
                          if($row['start'] != $row['end']){
                            echo'<td>'. strftime('%d.%m.%Y', strtotime($row['start'])) .'</td>';
                            echo'<td>'. strftime('%d.%m.%Y', strtotime($row['end'])) .'</td>';
                          }
                          if($row['start'] == $row['end']){
                            echo'<td colspan="2">'. strftime('%d.%m.%Y', strtotime($row['start'])) .'</td>';
                          }
                          echo'<td>
                            <a href="?b=events_edit&id='. $row['id'] .'" type="button" class="btn btn-sm btn-secondary position-relative">
                              <i class="bi bi-gear-wide"></i>
                            </a>
                          </td>';
                        }
                        echo'</tr>';
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

    <script>
        var set_repeat = document.getElementById("set_repeat");
        var repeat_input_1 = document.getElementById("set_repeat_input_1");
        var repeat_input_2 = document.getElementById("set_repeat_input_2");

        set_repeat.onchange = function () {
          if (repeat_input_1.hasAttribute('disabled')) {
            repeat_input_1.disabled = false;
          } else {
            repeat_input_1.disabled = true;
          }
          if (repeat_input_2.hasAttribute('disabled')) {
            repeat_input_2.disabled = false;
          } else {
            repeat_input_2.disabled = true;
          }
        };
    </script>
    <script>
        var start_date = document.getElementById("start_date");
        var end_date = document.getElementById("end_date");
        
        start_date.onchange = function () {
          if (start_date.value > end_date.value) {
            end_date.value = start_date.value
          }
          if (!end_date.value) {
            end_date.value = start_date.value
          }
        };
        end_date.onchange = function () {
          if (end_date.value < start_date.value) {
            start_date.value = end_date.value
          }
          if (!start_date.value) {
            start_date.value = end_date.value
          }
        };
    </script>
    <!--
    <script>
      function add_group(el) {
        let groups = document.getElementById("groups");
        let new_content = groups.firstChild.nextElementSibling.cloneNode(true);
        count_child = groups.children.length;
        new_content.id = 'group_' + count_child
        change_id_and_name = new_content.getElementsByTagName('select');
        change_id_and_name[0].id= "select_"+ count_child
        change_id_and_name[0].name= "select_"+ count_child
        
        add_del = new_content.getElementsByTagName('fieldset');
        del_button = document.createElement('button');
        del_button.setAttribute('class', 'btn btn-outline-secondary')
        del_button.setAttribute('type', 'button')
        del_button.setAttribute('id', 'select_button_' + count_child)
        del_button.setAttribute("onclick", "remove_select('group_" + parseInt(count_child) -1 + "');")
        del_button.innerHTML = '<i class="bi bi-trash"></i>';
        add_del[0].firstElementChild.appendChild(del_button)

        insertAfter(new_content, groups.lastElementChild)

        rename()
      }

      function insertAfter(newNode, existingNode) {
        existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
      }
      function remove_select(el) {
        let groups = document.getElementById("groups");
        let node = document.getElementById(el)
        groups.removeChild(node);

        rename()
      }

      function rename() {
        let groups = document.getElementById("groups");
        let count_child = groups.children.length;

        for (let j = 1; count_child >= j; j++) {
          let child = groups.childNodes[j+3];
          let name_group = 'group_' + j;
          let name_select = 'select_' + j;
          let name_button = 'del_button_' + j;

          child.id = name_group;

          select = child.getElementsByTagName('select');
          button = child.getElementsByTagName('button');
          console.log(button)
          select[0].id = name_select;
          select[0].name = name_select;
          button[0].id = name_button;
          button[0].onclick = "remove_select(name_group)";
        }
      }
    </script>
  -->