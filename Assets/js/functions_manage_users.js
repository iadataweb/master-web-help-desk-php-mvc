document.addEventListener('DOMContentLoaded', function () {

    let form = $("#formUser");
    let base_url = document.querySelector('meta[name="base-url"]').getAttribute('content');
    let tablaDataTable;
    let url;
    let url_submit;
    let url_read;
    let url_delete;
    var id_user;
    var modal;

    url = base_url + "/users/show_users";

    tablaDataTable = $('#tableManageUsers').DataTable({
        "aProcessing":true,
        "aServerSide":true,
        "ajax": {
            "url": url,
            "dataSrc":""
        },
        "language": languageDatatable(),
        "columns": [
            {"data":"id_user"},
            {"data":"first_names_user"},
            {"data":"last_names_user"},
            {"data":"email_user"},
            {"data":"cell_phone_user"},
            {"data":"name_role"},
            {"data":"status_active_user"},
            {"data":"options"}
        ],
        "responsive":"true",
        "destroy": true,
        "idisplaylength": 10,
        "order":[[0,"desc"]] 
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA LLENAR SELECT ROLE CON EL RESULTADO
    --------------------------------------------------------------*/
    $.post(base_url + "/roles/combo_roles", function(data) {
        $('#select-role').html(data);
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE AGREGAR NUEVO REGISTRO
    --------------------------------------------------------------*/
    $("#btnNew").click(function () {
        url_submit = base_url + '/users/insert_user';
        form.trigger("reset");
        $("#groupPassword").addClass("mandatory");
        $(".modal-title").text("Nuevo Registro");
        $("#btnSubmit").text("Guardar");
        $("#ModalCRUD").modal("show");
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE REGISTRO
    --------------------------------------------------------------*/
    $(document).on("click", ".js-btn-view", function () {
        id_user = $(this).data('id');
        modal = "view";
        show_data(id_user, modal);
        $(".modal-title").text("Datos del Registro");
        $("#ModalSee").modal("show");
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE EDITAR
    --------------------------------------------------------------*/
    $(document).on("click", ".js-btn-edit", function () {
        url_submit = base_url + '/users/update_user';
        form.trigger("reset");
        id_user = $(this).data('id');
        modal = "edit";
        show_data(id_user, modal);
        $("#groupPassword").removeClass("mandatory");
        $(".modal-title").text("Actualizar Registro");
        $("#btnSubmit").text("Actualizar");
        $("#ModalCRUD").modal("show");
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR LOS DATOS EN EL MODAL
    --------------------------------------------------------------*/
    function show_data(id_user) {
        url_read = base_url + '/users/show_user';
        $.ajax({
            url: url_read,
            type: "POST",
            dataType: "json",
            data: {id_user:id_user},
            success: function (response) {
                if (response.status === false) {
                    showMessage(response.type, response.message);
                } else {
                    if (modal == "edit") {
                        $("#input-first-names-user").val(response.result.first_names_user);
                        $("#input-last-names-user").val(response.result.last_names_user);
                        $("#input-email-user").val(response.result.email_user);
                        $("#input-cell-phone-user").val(response.result.cell_phone_user);
                        $("#select-role").val(response.result.id_role);
                        $("#select-status").val(response.result.status_active_user);
                    }
                    if (modal == "view") {
                        $("#cell-first-names-user").text(response.result.first_names_user);
                        $("#cell-last-names-user").text(response.result.last_names_user);
                        $("#cell-email-user").text(response.result.email_user);
                        $("#cell-cell-phone-user").text(response.result.cell_phone_user);
                        $("#cell-name-role").text(response.result.name_role);
                        if (response.result.status_active_user == 1) {
                            $("#cell-status-user").text("Activo");
                        } else {
                            $("#cell-status-user").text("Inactivo");
                        }
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                showMessage("error", "Ocurrió un problema al procesar la solicitud.");
            }
        });
    }

    /*--------------------------------------------------------------
    # FUNCIÓN PARA REGISTRAR O ACTUALIZAR REGISTRO
    --------------------------------------------------------------*/
    form.submit(function(e){                         
        e.preventDefault();
        var form_data = new FormData(form[0]);
        form_data.append('id_user', id_user);
        $.ajax({
            url: url_submit,
            type: "POST",
            data: form_data,
            processData: false,
            contentType: false,
            success: function (response) {
                var response = JSON.parse(response);
                if (response.status === false) {
                    showMessage(response.type, response.message);
                } else {
                    showMessage(response.type, response.message);
                    $("#ModalCRUD").modal("hide");
                    tablaDataTable.ajax.reload(null, false);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                showMessage("error", "Ocurrió un problema al procesar la solicitud.");
            }
        });											     			
    }); 


    /*--------------------------------------------------------------
    # FUNCIÓN PARA ELIMINAR REGISTRO
    --------------------------------------------------------------*/
        $(document).on("click", ".js-btn-delete", function () {
            id_user = $(this).data('id');
            url_delete = base_url + "/users/delete_user";
            Swal.fire({
                title: "¿Está seguro de eliminar el registro " + id_user + " del sistema?",
                text: "No volveras a usar este registro",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Eliminar",
                cancelButtonText: "Cancelar",
                customClass: {
                    confirmButton: "btn btn-danger m-2",
                    cancelButton: "btn btn-danger m-2",
                },
                allowOutsideClick: false,
            }).then((resul) => {
                if (resul.value) {
                    $.ajax({
                        url: url_delete,
                        method: "POST",
                        dataType: "json",
                        data: {id_user:id_user},
                        success: function (response) {
                            if (response.status === false) {
                                showMessage(response.type, response.message);
                            } else {
                                showMessage(response.type, response.message);
                                tablaDataTable.ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
        });
});
