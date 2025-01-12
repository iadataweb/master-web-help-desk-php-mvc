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
                    <h3>Dashboard</h3>
                </div>

                <div class="page-content">
                    <section class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldTicket"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Tickets Generados</h6>
                                                    <h6 class="font-extrabold mb-0"><?= $data['total_tickets_generated'] ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon red mb-2">
                                                        <i class="iconly-boldTime-Circle"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Tickets Pendientes</h6>
                                                    <h6 class="font-extrabold mb-0"><?= $data['total_pending_tickets'] ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon blue mb-2">
                                                        <i class="iconly-boldWork"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Tickets en Proceso</h6>
                                                    <h6 class="font-extrabold mb-0"><?= $data['total_in_progress_tickets'] ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon green mb-2">
                                                        <i class="iconly-boldTick-Square"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Tickets Cerrados</h6>
                                                    <h6 class="font-extrabold mb-0"><?= $data['total_closed_tickets'] ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-12 col-lg-7">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Total de Tickets por Categoría</h4>
                                        </div>
                                        <div class="card-body">
                                            <div id="chart-category"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-5">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Distribución de Categorías</h4>
                                        </div>
                                        <div class="card-body">
                                            <div id="chart-category-distribution"></div>
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