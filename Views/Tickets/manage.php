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
                        <h3>Gestionar Tickets</h3>
                    </div>                    
                    <section class="section">
                        <div class="card">                            
                            <div class="card-header">
                                <div class="mb-4">
                                    <button type="button" id="btnNew" class="btn btn-primary">Nuevo</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tableManageTickets"  class="table table-striped nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nro.Ticket</th>
                                                <th>Categoría</th>
                                                <th>Título</th>
                                                <th>Prioridad</th>
                                                <th>Estado</th>
                                                <th>Fecha Creación</th>
                                                <th>Fecha Asignación</th>
                                                <th>Fecha Cierre</th>
                                                <th>Soporte</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </section>

                    <?php require('assign.php'); ?>
                    <?php require('create-or-edit.php'); ?>

                </div>
            </div>

            
            <?php require('Layouts/footer.php'); ?>

        </div>
    </div>

    <?php require('Layouts/script.php'); ?>

</body>

</html>