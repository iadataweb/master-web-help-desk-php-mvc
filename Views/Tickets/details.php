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
                        <h3>Detalle Ticket</h3>
                    </div>

                    <section id="multiple-column-form">
                        <div class="row match-height">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Información del Ticket Nro.
                                            <?php echo $data['specific_ticket']['id_ticket']; ?></h4>

                                        <?= $data['specific_ticket']['status_open_ticket'] ?>
                                        <span class="badge bg-primary">Generado por <?= $data['specific_ticket']['first_names_user'] ?></span>
                                        <span class="badge bg-secondary">Generado en <?= $data['specific_ticket']['date_created_ticket'] ?></span>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12 mb-2">
                                                    <div class="form-group">
                                                        <label for="input-title" class="form-label">Título</label>
                                                        <input type="text" id="input-title" class="form-control"
                                                            value="<?php echo $data['specific_ticket']['title_ticket']; ?>"
                                                            name="title" disabled readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 mb-2">
                                                    <div class="form-group">
                                                        <label for="select-category"
                                                            class="form-label">Categoría</label>
                                                        <input type="text" id="select-category" class="form-control"
                                                            value="<?php echo $data['specific_ticket']['name_category']; ?>"
                                                            name="category" disabled readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 mb-2">
                                                    <div class="form-group">
                                                        <label for="select-subcategory"
                                                            class="form-label">Subcategoría</label>
                                                        <input type="text" id="select-subcategory" class="form-control"
                                                            value="<?php echo $data['specific_ticket']['name_subcategory']; ?>"
                                                            name="subcategory" disabled readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 mb-2">
                                                    <div class="form-group">
                                                        <label for="select-priority"
                                                            class="form-label">Prioridad</label>
                                                        <input type="text" id="select-priority" class="form-control"
                                                            value="<?php echo $data['specific_ticket']['name_priority']; ?>"
                                                            name="priority" disabled readonly />
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-2">
                                                        <div class="form-group">
                                                            <label for="company-column" class="form-label">Documentos
                                                                Adicionales</label>                                                            
                                                            <div class="table-responsive">
                                                                <table class="table mb-0">
                                                                    <thead class="thead-dark">
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Archivo</th>
                                                                            <th>Acción</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    <?php 
                                                                        
                                                                        if (!empty($data['attachments_ticket']) && is_array($data['attachments_ticket'])) { 

                                                                            $index_counter = 1;

                                                                            foreach ($data['attachments_ticket'] as $attachment) {
                                                                    ?>
                                                                            <tr>
                                                                                <td class="text-bold-500"><?= $index_counter ?></td>
                                                                                <td><?= $attachment['name_attachment_ticket'] ?></td>
                                                                                <td>
                                                                                    <a href="<?= base_url().'/'.$attachment['route_attachment_ticket'] ?>" target="_blank" rel="noopener noreferrer" class="btn icon btn-primary btn-see">
                                                                                        <i class="bi bi-eye-fill"></i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>                                                                            

                                                                    <?php
                                                                                $index_counter = $index_counter + 1;
                                                                            }
                                                                        } else {                                                                        
                                                                    ?>
                                                                        <tr id="no-files-row"><td colspan="3" class="text-center text-muted">Ningún archivo disponible.</td></tr>
                                                                    <?php
                                                                        }
                                                                    ?>

                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>
                                                </div>

                                                <div class="col-12 mb-2">
                                                    <div class="form-group">
                                                        <label for="textarea-description"
                                                            class="form-label">Descripción</label>
                                                        <textarea class="form-control" id="textarea-description"
                                                            rows="6" name="description" disabled
                                                            readonly><?php echo $data['specific_ticket']['description_ticket']; ?></textarea>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="custom-section-message-box">
                        <div id="content-message-box-ajax" class="ms-4 ps-4 border-start border-primary"></div>
                    </section>

                    <section class="custom-section-form">
                        <div id="content-form-ajax"></div>
                    </section>
                    
                </div>
            </div>

            <?php require('Layouts/footer.php'); ?>

        </div>
    </div>

    <?php require('Layouts/script.php'); ?>

</body>

</html>