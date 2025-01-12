<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Desk</title>
    <link rel="icon" href="<?= assets(); ?>/img/logo/logo_img.ico">
    <link rel="stylesheet" crossorigin href="<?= assets(); ?>/css/app.css">
    <link rel="stylesheet" crossorigin href="<?= assets(); ?>/css/error.css">
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="error">


        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img class="img-error" src="<?= assets(); ?>/svg/error-500.svg" alt="System Error">
                    <h1 class="error-title">Error del Sistema</h1>
                    <p class="fs-5 text-gray-600">El sitio web no está disponible actualmente. Intenta nuevamente más tarde o contacta al
                    desarrollador.</p>
                </div>
            </div>
        </div>

    </div>
</body>

</html>