<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= base_url(); ?>">
    <title>Help Desk</title>
    <link rel="icon" href="<?= assets(); ?>/img/logo/logo_img.ico">
    <link rel="stylesheet" href="<?= assets(); ?>/extensions/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= assets(); ?>/css/extra-component-sweetalert.css">
    <link rel="stylesheet" href="<?= assets(); ?>/css/app.css">
    <link rel="stylesheet" href="<?= assets(); ?>/css/app-dark.css">
    <link rel="stylesheet" href="<?= assets(); ?>/css/auth.css">
</head>

<body>

    <div class="d-flex justify-content-center align-items-center vh-100 p-4">


        <div class="card shadow">
            <div class="card-header">
                <h4 class="card-title text-center">Iniciar sesión</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form id="formLogin" class="form form-horizontal">
                        <div class="form-body">
                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="email" class="form-control" placeholder="Correo Electrónico"
                                                name="email" id="email">
                                            <div class="form-control-icon">
                                                <i class="bi bi-envelope"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="password" class="form-control" placeholder="Contraseña"
                                                name="password" id="password">
                                            <div class="form-control-icon">
                                                <i class="bi bi-lock"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-1 mb-1 btn-block shadow-lg">Ingresar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="text-center mt-5 text-lg fs-6">
                        <p><a class="font-bold" href="auth-forgot-password.html">¿Has olvidado tu contraseña?</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php require('Layouts/script.php'); ?>

</body>

</html>