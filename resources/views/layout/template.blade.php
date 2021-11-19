<?php
// include __DIR__ ."/../views/lib/BladeOne.php";
// use eftec\bladeone;
// $views = __DIR__ . '/../../public/views'; // it uses the folder /views to read the templates
// $cache = __DIR__ . '/../../public/cache'; // it uses the folder /cache to compile the result. 
// $blade = new bladeone\BladeOne($views,$cache,bladeone\BladeOne::MODE_AUTO);

?>
<!doctype html>
<html lang="de">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <meta http-equiv="refresh" content="1"> -->
  <link rel="icon" type="image/png" href="#" />

  <title>Liste</title>

  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->

  <!-- Custom CSS -->
  <link href="/resources/css/custom.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="/resources/css/bootstrap.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="/resources/css/bootstrap-icons.css">
  <link rel="stylesheet" href="/resources/css/select2.min.css">
</head>

<body>
  <main class="container-fluid">
    @php
    // $path = __DIR__ . '/../views/'. $blade .'.blade.php';
    // if(file_exists($path)){
    // require $path;
    // }
    echo $blade->run("main");

    @endphp
  </main>
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="/resources/js/bootstrap.bundle.js"></script>
  <!-- <script src="/resources/js/bootstrap-toggle.min.js"></script> -->
  <script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
  </script>

  <script src="/resources/js/jquery-3.3.1.min.js"></script>

  <script src="/resources/js/jquery-ui.min.js"></script>
  <script src="/resources/js/select2.full.min.js"></script>
  <script>
    $(document).ready(function() {
    $('.multiple-select').select2();
    
});
  </script>
</body>

</html>