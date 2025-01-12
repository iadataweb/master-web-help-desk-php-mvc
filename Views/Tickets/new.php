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
                        <h3>Nuevo Ticket</h3>
                    </div>
                    
                    <section id="multiple-column-form">
                        <div class="row match-height">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Ingresar Información</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form id="formNewTicket" class="form" enctype="multipart/form-data" data-parsley-validate>
                                                <div class="row">
                                                    <div class="col-md-6 col-12 mb-2">
                                                        <div class="form-group mandatory">
                                                            <label for="input-title" class="form-label">Título</label>
                                                            <input type="text" id="input-title" class="form-control"
                                                                placeholder="Ingrese Título" name="title"
                                                                data-parsley-required="true" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12 mb-2">
                                                        <div class="form-group mandatory">
                                                            <label for="select-category"
                                                                class="form-label">Categoría</label>
                                                            <select class="form-select" id="select-category" name="id_category"
                                                                data-parsley-required="true">
                                                                <option selected disabled value="">Selecciona una opción</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12 mb-2">
                                                        <div class="form-group mandatory">
                                                            <label for="select-subcategory"
                                                                class="form-label">Subcategoría</label>
                                                            <select class="form-select" id="select-subcategory"
                                                                name="id_subcategory" data-parsley-required="true">
                                                                <option selected disabled value="">Selecciona una opción</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12 mb-2">
                                                        <div class="form-group mandatory">
                                                            <label for="select-priority"
                                                                class="form-label">Prioridad</label>
                                                            <select class="form-select" id="select-priority" name="id_priority"
                                                                data-parsley-required="true">
                                                                <option selected disabled value="">Selecciona una opción</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mb-2">
                                                        <div class="form-group">
                                                            <label for="company-column" class="form-label">Documentos
                                                                Adicionales</label>   
                                                            <div id="custom-btn-upload-table"></div>                                                            
                                                            <div class="table-responsive">
                                                                <table id="table-handler" class="table mb-0 custom-table-handler">
                                                                    <thead class="thead-dark">
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Archivo</th>
                                                                            <th>Acción</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-12 mb-2">
                                                        <div class="form-group mandatory">
                                                            <label for="textarea-description" class="form-label">Descripción</label>
                                                            <textarea class="form-control" id="textarea-description" rows="6" placeholder="Ingrese Descripción" name="description" data-parsley-required="true"></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary me-1 mb-1">
                                                            Enviar
                                                        </button>
                                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                                            Reiniciar
                                                        </button>
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