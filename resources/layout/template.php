<!doctype html>
<html lang="de">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta http-equiv="refresh" content="1"> -->

    <title>Liste</title>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->

    <!-- Custom CSS -->
    <link href="/resources/css/custom.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="/resources/css/bootstrap.min.css" rel="stylesheet" />
  </head>
  <body>
    <main class="container">
    <?php

      require __DIR__ . '/../views/'. blade .'.blade.php';

    ?>
    </main>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="/resources/js/bootstrap.bundle.js"></script>
    <script>$(".switch").bootstrapSwitch()</script>
  </body>
</html>