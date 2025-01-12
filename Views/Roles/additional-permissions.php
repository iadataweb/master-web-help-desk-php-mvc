<div class="modal fade text-left" id="ModalAdditionalPermission" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4"
    data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Actualizar Permisos Adicionales</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <form id="formAdditionalPermission">
                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <?php
                            $modules = [];
                            foreach ($data['additional_permissions'] as $additional_permission) {
                                $modules[$additional_permission['name_module']][] = $additional_permission;
                            }

                            foreach ($modules as $module_name => $permissions) {
                            ?>

                            <tr>
                                <th>Nro.</th>
                                <th>Módulo <?= $module_name; ?></th>
                                <th>Si</th>
                                <th>No</th>
                            </tr>

                            <?php
                            foreach ($permissions as $index => $additional_permission) {
                                $yes_check = $additional_permission['allow_additional_permission'] === 1 ? " checked " : "";
                                $not_check = $additional_permission['allow_additional_permission'] === 0 ? " checked " : "";
                            ?>
                            
                            <input type="hidden" class="form-control" value="<?= $additional_permission['id_control']; ?>" name="controls[<?= $additional_permission['id_control']; ?>][id_control]">

                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= $additional_permission['name_control']; ?></td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="controls[<?= $additional_permission['id_control']; ?>][allow]" value="1" <?= $yes_check; ?>>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="controls[<?= $additional_permission['id_control']; ?>][allow]" value="0" <?= $not_check; ?>>
                                    </div>
                                </td>                                                                                                                                                          
                            </tr>

                            <?php
                            }}
                            ?>
                                                                    
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cerrar</span>
                    </button>
                    <button type="submit" class="btn btn-primary ms-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Actualizar</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>