<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- <meta http-equiv="refresh" content="1"> -->
    <link rel="icon" type="image/png" href="#" />
    <title>404</title>
    <!-- Custom CSS -->
    <link href="/resources/css/custom.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="/resources/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="container-fluid">
    <article class="row g-5">
        <section class="col-12">
            <div class="row g-3">
                <div class="col-12 d-flex justify-content-center">
                    <h1 class="error-404">
                        <b>404</b>
                    </h1>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <h2 class="error-txt">
                        Die Seite wurde nicht gefunden!
                    </h2>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <a class="btn btn-outline-secondary btn-lg w-50" type="button" href="<?php echo(!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/'; ?>">
                        Home
                    </a>
                </div>
            </div>
        </section>
    </article>
</body>

</html>