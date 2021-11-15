<?php
echo'<nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
<a href="/">
          <span class="navbar-text">
'. lang['index'] .'
          </span>
        </a>
      </div>
      <div class="col">
        <a href="?b=events">
          <span class="navbar-text">
'. lang['events'] .'
          </span>
        </a>
      </div>
      <div class="col">
        <a href="?b=settings">
          <span class="navbar-text">
'. lang['settings'] .'
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

                        <button class="nav-link col" id="nav-group_create-tab" data-bs-toggle="tab" data-bs-target="#nav-group_create" type="button" role="tab" aria-controls="nav-group_create" aria-selected="false">
'. lang['group'] .' '. lang['add'] .'
                        </button>
                        <button class="nav-link col active" id="nav-active_group-tab" data-bs-toggle="tab" data-bs-target="#nav-active_group" type="button" role="tab" aria-controls="nav-active_group" aria-selected="true">
'. lang['active'] .' '. lang['groups'] .'
                        </button>
                        <button class="nav-link col" id="nav-deactivated_group-tab" data-bs-toggle="tab" data-bs-target="#nav-deactivated_group" type="button" role="tab" aria-controls="nav-deactivated_group" aria-selected="false">
'. lang['inactive'] .' '. lang['groups'] .'
                        </button>
                    </div>
                </nav>

                <div class="tab-content" id="myTabContent">
<div class="tab-pane fade" id="nav-group_create" role="tabpanel" aria-labelledby="nav-group_create-tab">';
  require __DIR__ . '/components/group/add.blade.php';
  echo'</div>
<div class="tab-pane fade show active" id="nav-active_group" role="tabpanel" aria-labelledby="nav-active_group-tab">';
  require __DIR__ . '/components/group/active.blade.php';
  echo'</div>
<div class="tab-pane fade" id="nav-deactivated_group" role="tabpanel" aria-labelledby="nav-deactivated_group-tab">';
  require __DIR__ . '/components/group/inactive.blade.php';
  echo'</div>
                </div>          
            </div>
        </div>
    </section>
</article>';