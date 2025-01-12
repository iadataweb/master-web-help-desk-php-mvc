<div class="modal fade text-left" id="ModalPermission" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4"
    data-bs-backdrop="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">Actualizar Permisos</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <form id="formPermission">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Nro.</th>
                                    <th>Módulo Grupo</th>
                                    <th>Ver</th>
                                    <th>Crear</th>
                                    <th>Actualizar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                foreach ($data['permissions_modules'] as $index => $permission_module) {
                                    $r_check = $permission_module['r_read_permission'] === 1 ? " checked " : "";
                                    $w_check = $permission_module['w_write_permission'] === 1 ? " checked " : "";
                                    $u_check = $permission_module['u_update_permission'] === 1 ? " checked " : "";
                                    $d_check = $permission_module['d_delete_permission'] === 1 ? " checked " : "";
                                ?>
                                
                                <input type="hidden" class="form-control" value="<?= $permission_module['id_module']; ?>" name="modules[<?= $permission_module['id_module']; ?>][id_module]">

                                <tr>
                                    <td><?= $index + 1; ?></td>
                                    <td><?= $permission_module['name_module']; ?></td>
                                    <td>
                                        <div class="form-check">
                                            <div class="checkbox d-flex">
                                                <input type="checkbox" class="form-check-input" name="modules[<?= $permission_module['id_module']; ?>][r]" <?= $r_check; ?>>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <div class="checkbox d-flex">
                                                <input type="checkbox" class="form-check-input" name="modules[<?= $permission_module['id_module']; ?>][w]" <?= $w_check; ?>>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <div class="checkbox d-flex">
                                                <input type="checkbox" class="form-check-input" name="modules[<?= $permission_module['id_module']; ?>][u]" <?= $u_check; ?>>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <div class="checkbox d-flex">
                                                <input type="checkbox" class="form-check-input" name="modules[<?= $permission_module['id_module']; ?>][d]" <?= $d_check; ?>>
                                            </div>
                                        </div>
                                    </td>                                                                                                                                                            
                                </tr>     

                                <?php
                                }
                                ?>
                                                                    
                            </tbody>
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