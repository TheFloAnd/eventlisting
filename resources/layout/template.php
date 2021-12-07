<?php

use app\controller\config;
use app\module\file_exists;
?>
<!doctype html>
<html lang="de">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <meta http-equiv="refresh" content="1"> -->
  <link rel="icon" type="image/png" href="#" />

  <title><?php echo config::get('name')->value; ?></title>

  <!-- Custom CSS -->
  <link href="/resources/css/custom.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="/resources/css/bootstrap.min.css" rel="stylesheet" />
  <!-- <link rel="stylesheet" href="/resources/css/bootstrap-icons.css">-->

  <link rel="stylesheet" href="/resources/css/select2.min.css">
  <!-- <link rel="stylesheet" href="/resources/css/jquery.dataTables.min.css"> -->
  <link rel="stylesheet" href="/resources/css/dataTables.bootstrap5.min.css">
</head>

<body>
  <main class="container-fluid">
    <?php
    if (file_exists(__DIR__ . '/../views/' . blade . '.blade.php')) {
      require __DIR__ . '/../views/' . blade . '.blade.php';
    }
    ?>
  </main>
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="/resources/js/bootstrap.bundle.js"></script>
  <!-- <script src="/resources/js/bootstrap-toggle.min.js"></script> -->
  <script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
  </script>
  <!-- Jquery -->
  <script src="/resources/js/jquery.min.js"></script>
  <script src="/resources/js/jquery-ui.min.js"></script>

  <!-- Jquery Datatable -->
  <script src="/resources/js/jquery.dataTables.min.js"></script>
  <script src="/resources/js/dataTables.bootstrap5.min.js"></script>
  <script src="/resources/js/init/datatables.js"></script>

  <!-- Select 2 -->
  <script src="/resources/js/select2.full.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.multiple-select').select2();
    });
  </script>

  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict'

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.prototype.slice.call(forms)
        .forEach(function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        })
    })()
  </script>
</body>

</html>