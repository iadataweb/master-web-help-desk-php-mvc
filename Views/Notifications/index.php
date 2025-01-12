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
                        <h3>Notificaciones</h3>
                    </div>

                    <section id="multiple-column-form">
                        <div class="row match-height">
                            <div class="col-12">
                                <div class="card">                                    
                                    <div class="card-content">
                                        <div class="card-body">

                                            <?php if (!empty($data['notifications'])) { ?>
                                            
                                            <div class="list-group"> 
                                                <?php
                                                foreach ($data['notifications'] as $notification) {
                                                    $status_read = $notification['status_read_notification'];
                                                    if ($status_read === 1) {
                                                        $status_read = "ist-group-item-light";
                                                    } else {
                                                        $status_read = "list-group-item-primary";
                                                    }
                                                ?>   
                                                <a href="<?= base_url(); ?>/tickets/ticket_details/<?= $notification['id_ticket_notification'] ?>" target="_blank" class="list-group-item list-group-item-action <?= $status_read ?>">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <span class="mb-1 fw-bolder">Actualización sobre su ticket N° <?= $notification['id_ticket_notification'] ?></span>
                                                        <small><?= $notification['date_created_notification'] ?></small>
                                                    </div>
                                                    <p class="mb-1"><?= $notification['message_notification'] ?></p>
                                                </a>
                                                <?php
                                                }
                                                ?>                                                                                                                                                                                                
                                            </div>

                                            <nav class="mt-5">
                                                <ul class="pagination pagination-primary  justify-content-end">
                                                    <li class="page-item <?= $data['current_page'] == 1 ? 'disabled' : '' ?>">
                                                        <a class="page-link" href="?page=<?= $data['current_page'] - 1 ?>" tabindex="-1" aria-disabled="true">Anterior</a>
                                                    </li>

                                                    <?php for ($i = 1; $i <= $data['total_pages']; $i++) { ?>

                                                    <li class="page-item <?= $i == $data['current_page'] ? 'active' : '' ?>">
                                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                                    </li>

                                                    <?php } ?>

                                                    <li class="page-item <?= $data['current_page'] == $data['total_pages'] ? 'disabled' : '' ?>">
                                                        <a class="page-link" href="?page=<?= $data['current_page'] + 1 ?>">Siguiente</a>
                                                    </li>
                                                </ul>
                                            </nav>
                                            
                                            <?php
                                            } else {
                                                echo '<p class="text-center m-0">No tienes notificaciones en este momento.</p>';
                                            }
                                            ?>

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