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
                        <h3>Gestionar Usuarios</h3>
                    </div>
                    
                    <section class="section">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4">
                                    <button type="button" id="btnNew" class="btn btn-primary">Nuevo</button>
                                </div>
                                <div class="table-responsive">
                                    <table id="tableManageUsers"  class="table table-striped nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nro.</th>
                                                <th>Nombre Completo</th>
                                                <th>Apellido Completo</th>
                                                <th>Correo Electrónico</th>
                                                <th>Teléfono / Celular</th>
                                                <th>Rol</th>
                                                <th>Estado</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                    <?php require('see.php'); ?>
                    <?php require('create-or-edit.php'); ?>

                </div>
            </div>

            <?php require('Layouts/footer.php'); ?>

        </div>
    </div>

    <?php require('Layouts/script.php'); ?>
    
</body>

</html>