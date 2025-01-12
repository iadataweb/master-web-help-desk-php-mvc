<div class="modal fade text-left" id="ModalCRUD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4"
    data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4"></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>

            <form id="formUser">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group mandatory">
                                <label for="input-first-names-user" class="form-label">Nombre Completo</label>
                                <input type="text" id="input-first-names-user" class="form-control"
                                    placeholder="Nombre completo" name="first_names_user">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group mandatory">
                                <label for="input-last-names-user" class="form-label">Apellido Completo</label>
                                <input type="text" id="input-last-names-user" class="form-control"
                                    placeholder="Apellido completo" name="last_names_user">
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group mandatory">
                                <label for="input-email-user" class="form-label">Correo Electrónico</label>
                                <input type="text" id="input-email-user" class="form-control"
                                    placeholder="Correo electrónico" name="email_user">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group mandatory">
                                <label for="input-cell-phone-user" class="form-label">Teléfono / Celular</label>
                                <input type="text" id="input-cell-phone-user" class="form-control"
                                    placeholder="Teléfono / Celular" name="cell_phone_user">
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div id="groupPassword" class="form-group mandatory">
                                <label for="input-password-user" class="form-label">Contraseña</label>
                                <input type="text" id="input-password-user" class="form-control"
                                    placeholder="Contraseña" name="password_user">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group mandatory">
                                <label for="select-role"
                                    class="form-label">Rol</label>
                                <select class="form-select" id="select-role" name="id_role_user">
                                    <option selected disabled value="">Selecciona una opción</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group mandatory">
                                <label for="select-status"
                                    class="form-label">Estado</label>
                                <select class="form-select" id="select-status" name="status_active_user">
                                    <option selected disabled value="">Selecciona una opción</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
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