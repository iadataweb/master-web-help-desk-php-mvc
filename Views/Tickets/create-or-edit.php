<div class="modal fade" id="ModalCRUD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4"
    data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4"></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="formTicket" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group mandatory">
                                <label for="input-title" class="form-label">Título</label>
                                <input type="text" id="input-title" class="form-control" placeholder="Título" name="title">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group mandatory">
                                <label for="select-category" class="form-label">Categoría</label>
                                <select class="form-select" id="select-category" name="id_category">
                                    <option selected disabled value="">Selecciona una opción</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group mandatory">
                                <label for="select-subcategory" class="form-label">Subcategoría</label>
                                <select class="form-select" id="select-subcategory" name="id_subcategory">
                                    <option selected disabled value="">Selecciona una opción</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group mandatory">
                                <label for="select-priority" class="form-label">Prioridad</label>
                                <select class="form-select" id="select-priority" name="id_priority">
                                    <option selected disabled value="">Selecciona una opción</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group mandatory">
                                <label for="select-user" class="form-label">Usuario Final</label>
                                <select class="form-select" id="select-user" name="id_user">
                                    <option selected disabled value="">Selecciona una opción</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
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
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="textarea-description" class="form-label">Descripción</label>
                                <textarea class="form-control" id="textarea-description" rows="6"
                                    placeholder="Ingrese Descripción" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cerrar</span>
                </button>
                <button type="submit" form="formTicket" class="btn btn-primary ms-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span id="btnSubmit" class="d-none d-sm-block"></span>
                </button>
            </div>
        </div>
    </div>
</div>