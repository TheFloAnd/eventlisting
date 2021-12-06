<?php

use app\controller\config;
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

    require __DIR__ . '/../views/' . blade . '.blade.php';

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

  <script src="/resources/js/jquery.min.js"></script>
  <script src="/resources/js/jquery-ui.min.js"></script>

  <script src="/resources/js/jquery.dataTables.min.js"></script>
  <script src="/resources/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
      var table = $(".dataTable").DataTable({
        'responsive': true,
        'displayLength': 10,
        'autoWidth': false,
        'stateSave': true,
        'ordering': true,
        'orderable': true,
        "columnDefs": [ {
          "targets": ['no-sort'],
          "orderable": false
          }],
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"],
        ],
        "order": [],
        initComplete: function() {
          var api = this.api();
          api.$(".table_search").click(function() {
            api.search($.trim(this.innerHTML)).draw();
          });
        },
        "language": {
          "decimal": "",
          "emptyTable": "Es wurden keine Einträge gefunden!",
          "info": "Zeige _START_ bis _END_ von _TOTAL_ Einträgen",
          "infoEmpty": "0 Einträgen",
          "infoFiltered": "(Suche aus insgesamt _MAX_ Einträgen)",
          "infoPostFix": "",
          "thousands": ",",
          "lengthMenu": "Einträge anzeigen: _MENU_",
          "loadingRecords": "Laden...",
          "processing": "Verarbeiten...",
          "search": "Suche:",
          "zeroRecords": "Es sind keine Einträge vorhanden!",
          "paginate": {
            "first": "Erste",
            "last": "Letzte",
            "next": "Nächste",
            "previous": "Vorherige"
          },
          "aria": {
            "sortAscending": ": activate to sort column ascending",
            "sortDescending": ": activate to sort column descending"
          },
        }
      });

      $('a.toggle-vis').on('click', function(e) {
        e.preventDefault();

        // Get the column API object
        var column = table.column($(this).attr('data-column'));

        // Toggle the visibility
        column.visible(!column.visible());
      });

      $(".dataTable tbody").on("click", "tr", function() {
        if ($(this).hasClass("selected")) {
          $(this).removeClass("selected");
        } else {
          table.$("tr.selected").removeClass("selected");
          $(this).addClass("selected");
        }
      });
    });

    $(document).ready(function() {
      var table = $(".dataTable_group_active").DataTable({
        'responsive': true,
        'displayLength': 10,
        'autoWidth': false,
        'stateSave': true,
        'ordering': true,
        'orderable': true,
        "columnDefs": [ {
          "targets": ['no-sort'],
          "orderable": false
          }],
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"],
        ],
        "order": [],
        initComplete: function() {
          var api = this.api();
          api.$(".table_search").click(function() {
            api.search($.trim(this.innerHTML)).draw();
          });
        },
        "language": {
          "decimal": "",
          "emptyTable": "Es wurden keine Einträge gefunden!",
          "info": "Zeige _START_ bis _END_ von _TOTAL_ Einträgen",
          "infoEmpty": "0 Einträgen",
          "infoFiltered": "(Suche aus insgesamt _MAX_ Einträgen)",
          "infoPostFix": "",
          "thousands": ",",
          "lengthMenu": "Einträge anzeigen: _MENU_",
          "loadingRecords": "Laden...",
          "processing": "Verarbeiten...",
          "search": "Suche:",
          "zeroRecords": "Es sind keine Einträge vorhanden!",
          "paginate": {
            "first": "Erste",
            "last": "Letzte",
            "next": "Nächste",
            "previous": "Vorherige"
          },
          "aria": {
            "sortAscending": ": activate to sort column ascending",
            "sortDescending": ": activate to sort column descending"
          },
        }
      });
      $('a.toggle-vis').on('click', function(e) {
        e.preventDefault();

        // Get the column API object
        var column = table.column($(this).attr('data-column'));

        // Toggle the visibility
        column.visible(!column.visible());
      });

      $(".dataTable_group_active tbody").on("click", "tr", function() {
        if ($(this).hasClass("selected")) {
          $(this).removeClass("selected");
        } else {
          table.$("tr.selected").removeClass("selected");
          $(this).addClass("selected");
        }
      });
    });
    $(document).ready(function() {
      var table = $(".dataTable_group_inactive").DataTable({
        'responsive': true,
        'displayLength': 10,
        'autoWidth': false,
        'stateSave': true,
        'ordering': true,
        'orderable': true,
        "columnDefs": [ {
          "targets": ['no-sort'],
          "orderable": false
          }],
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"],
        ],
        "order": [],
        initComplete: function() {
          var api = this.api();
          api.$(".table_search").click(function() {
            api.search($.trim(this.innerHTML)).draw();
          });
        },
        "language": {
          "decimal": "",
          "emptyTable": "Es wurden keine Einträge gefunden!",
          "info": "Zeige _START_ bis _END_ von _TOTAL_ Einträgen",
          "infoEmpty": "0 Einträgen",
          "infoFiltered": "(Suche aus insgesamt _MAX_ Einträgen)",
          "infoPostFix": "",
          "thousands": ",",
          "lengthMenu": "Einträge anzeigen: _MENU_",
          "loadingRecords": "Laden...",
          "processing": "Verarbeiten...",
          "search": "Suche:",
          "zeroRecords": "Es sind keine Einträge vorhanden!",
          "paginate": {
            "first": "Erste",
            "last": "Letzte",
            "next": "Nächste",
            "previous": "Vorherige"
          },
          "aria": {
            "sortAscending": ": activate to sort column ascending",
            "sortDescending": ": activate to sort column descending"
          },
        }
      });
      $('a.toggle-vis').on('click', function(e) {
        e.preventDefault();

        // Get the column API object
        var column = table.column($(this).attr('data-column'));

        // Toggle the visibility
        column.visible(!column.visible());
      });

      $(".dataTable_group_inactive tbody").on("click", "tr", function() {
        if ($(this).hasClass("selected")) {
          $(this).removeClass("selected");
        } else {
          table.$("tr.selected").removeClass("selected");
          $(this).addClass("selected");
        }
      });
    });
  </script>
  <script src="/resources/js/select2.full.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.multiple-select').select2();
    });
  </script>

<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
'use strict'

// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.querySelectorAll('.needs-validation')

// Loop over them and prevent submission
Array.prototype.slice.call(forms)
.forEach(function (form) {
form.addEventListener('submit', function (event) {
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