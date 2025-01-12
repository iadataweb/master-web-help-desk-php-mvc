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
                        <h3>Datos Personales</h3>
                    </div>

                    <section id="multiple-column-form">
                        <div class="row match-height">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Formulario de Datos Personales</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form id="formPersonalData" class="form" data-parsley-validate>
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group has-icon-left mandatory">
                                                            <label for="input-first-names-user" class="form-label">Nombre Completo</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control" value="<?= $_SESSION['user_data']['first_names_user'] ?>"
                                                                    id="input-first-names-user" name="first_names_user" data-parsley-required="true">
                                                                <div class="form-control-icon">
                                                                    <i class="bi bi-person"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group has-icon-left">
                                                            <label for="input-last-names-user" class="form-label">Apellido Completo</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control" value="<?= $_SESSION['user_data']['last_names_user'] ?>"
                                                                    id="input-last-names-user" name="last_names_user" data-parsley-required="true">
                                                                <div class="form-control-icon">
                                                                    <i class="bi bi-person"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group has-icon-left">
                                                            <label for="input-email-user" class="form-label">Correo Electrónico</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control" value="<?= $_SESSION['user_data']['email_user'] ?>"
                                                                    id="input-email-user" name="email_user" data-parsley-required="true">
                                                                <div class="form-control-icon">
                                                                    <i class="bi bi-envelope"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group has-icon-left">
                                                            <label for="input-cell-phone-user" class="form-label">Teléfono / Celular</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control" value="<?= $_SESSION['user_data']['cell_phone_user'] ?>"
                                                                    id="input-cell-phone-user" name="cell_phone_user" data-parsley-required="true">
                                                                <div class="form-control-icon">
                                                                    <i class="bi bi-phone"></i>
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