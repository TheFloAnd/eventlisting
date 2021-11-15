<nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
<a href="/">
          <span class="navbar-text">
<?php echo lang['index'] ?>
          </span>
        </a>
      </div>
      <div class="col">
        <a href="?b=groups">
          <span class="navbar-text">
<?php echo lang['groups'] ?>
          </span>
        </a>
      </div>
      <div class="col">
        <a href="?b=settings">
          <span class="navbar-text">
<?php echo lang['settings'] ?>
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
            <button class="nav-link col active" id="nav-event_add-tab" data-bs-toggle="tab"
              data-bs-target="#nav-event_add" type="button" role="tab" aria-controls="nav-event_add"
              aria-selected="false">
<?php echo lang['event'] .' '.  lang['add'] ?>
            </button>
            <button class="nav-link col" id="nav-event_edit-tab" data-bs-toggle="tab" data-bs-target="#nav-event_edit"
              type="button" role="tab" aria-controls="nav-event_edit" aria-selected="true">
<?php echo lang['events'] .' '.  lang['edit'] ?>
            </button>
          </div>
        </nav>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="nav-event_add" role="tabpanel" aria-labelledby="nav-event_add-tab">
<?php require __DIR__ . '/components/events/add.blade.php'; ?>
</div>
          <div class="tab-pane fade" id="nav-event_edit" role="tabpanel" aria-labelledby="nav-event_edit-tab">
<?php require __DIR__ . '/components/events/list.blade.php'; ?>
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
