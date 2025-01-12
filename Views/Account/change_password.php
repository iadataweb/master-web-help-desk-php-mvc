<!DOCTYPE html>
<html lang="en">

<?php require('Layouts/head.php'); ?>

<body>

    <div id="app">

        <?php require('Layouts/sidebar.php'); ?>

        <div id="main" class="layout-navbar navbar-fixed">

            <?php require('Layouts/header.php'); ?>

            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <h3>Cambiar Contraseña</h3>
                    </div>

                    <section class="section-change-password">
                        <div class="row match-height">
                            <div class="col-12">
                                <div class="card">
                                <div class="card-header">
                                        <h4 class="card-title">Formulario para Cambiar Contraseña</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form id="formChangePassword" class="form" data-parsley-validate>
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group has-icon-left mandatory">
                                                            <label for="input-current-password" class="form-label">Contraseña Actual</label>
                                                            <div class="position-relative">
                                                                <input type="password" class="form-control" placeholder="Contraseña actual"
                                                                    id="input-current-password" name="current_password" data-parsley-required="true">
                                                                <div class="form-control-icon">
                                                                    <i class="bi bi-lock"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group has-icon-left mandatory">
                                                            <label for="input-new-password" class="form-label">Nueva Contraseña</label>
                                                            <div class="position-relative">
                                                                <input type="password" class="form-control" placeholder="Nueva contraseña"
                                                                    id="input-new-password" name="new_password" data-parsley-required="true">
                                                                <div class="form-control-icon">
                                                                    <i class="bi bi-lock"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group has-icon-left mandatory">
                                                            <label for="input-repeat-password" class="form-label">Repetir Nueva Contraseña</label>
                                                            <div class="position-relative">
                                                                <input type="password" class="form-control" placeholder="Repetir nueva contraseña"
                                                                    id="input-repeat-password" name="repeat_password" data-parsley-required="true"/>
                                                                <div class="form-control-icon">
                                                                    <i class="bi bi-lock"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button type="submit"
                                                            class="btn btn-primary me-1 mb-1">Guardar Cambios</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>

            <?php require('Layouts/footer.php'); ?>

        </div>
    </div>

    <?php require('Layouts/script.php'); ?>
    
</body>

</html>