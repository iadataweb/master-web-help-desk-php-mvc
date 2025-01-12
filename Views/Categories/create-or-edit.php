<div class="modal fade text-left" id="ModalCRUD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4"
    data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4"></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>

            <form id="formCategory">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mandatory">
                                <label for="input-name-category" class="form-label">Nombre Categoría</label>
                                <input type="text" id="input-name-category" class="form-control"
                                    placeholder="Nombre categoría" name="name_category">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cerrar</span>
                    </button>
                    <button type="submit" class="btn btn-primary ms-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span id="btnSubmit" class="d-none d-sm-block"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>