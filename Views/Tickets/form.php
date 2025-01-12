<?php
if ($data['form_message'] === true && $data['specific_ticket']['status_open_ticket'] === 1) {
?>
<section class="custom-section-message-input-box">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ingresar Mensaje</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form id="formNewMessage" class="form" enctype="multipart/form-data"
                            data-parsley-validate>
                            <div class="row">

                                <input type="hidden" id="input-id-ticket" class="form-control"
                                    value="<?php echo $data['specific_ticket']['id_ticket']; ?>"
                                    name="id_ticket" />

                                <div class="col-12 mb-2">
                                    <div class="form-group mandatory">
                                        <label for="textarea-message"
                                            class="form-label">Mensaje</label>
                                        <textarea class="form-control" id="textarea-message"
                                            rows="6" placeholder="Ingrese su mensaje" name="message"
                                            data-parsley-required="true"></textarea>
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

                            </div>

                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                        Enviar
                                    </button>

                                    <?php
                                        if ($_SESSION['user_data']['id_role'] != ROLE_END_USER) {
                                            if (!empty($data['close_ticket'])) {
                                    ?>
                                    <button type="button" class="btn btn-warning js-btn-close me-1 mb-1">
                                        Cerrar Ticket
                                    </button>
                                    <?php
                                        }}
                                    ?>
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
<?php
}
?>

<?php
if ($_SESSION['user_data']['id_role'] != ROLE_END_USER && $data['specific_ticket']['status_open_ticket'] === 0) {
    if ($data['reopen_ticket'] === 1) {
?>
<section class="custom-section-ticket-reopen-form">
    <form id="formTicketReopen" class="form">
        <input type="hidden" class="form-control" value="<?php echo $data['specific_ticket']['id_ticket']; ?>" name="id_ticket">
        <button type="submit" class="btn btn-warning w-100 me-1 mb-1">Reabrir Ticket</button>
    </form>
</section>
<?php
}}
?>