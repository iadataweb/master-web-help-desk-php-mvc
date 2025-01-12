document.addEventListener('DOMContentLoaded', function () {

    let form = $("#formRole");
    let base_url = document.querySelector('meta[name="base-url"]').getAttribute('content');
    let tablaDataTable;
    let url;
    let url_submit;
    let url_permission;
    let url_additional_permissions;
    let url_read;
    let url_delete;
    var id_role;
    var modal;

    url = base_url + "/roles/show_roles";

    tablaDataTable = $('#tableManageRoles').DataTable({
        "aProcessing":true,
        "aServerSide":true,
        "ajax": {
            "url": url,
            "dataSrc":""
        },
        "language": languageDatatable(),
        "columns": [
            {"data":"id_role"},
            {"data":"name_role"},
            {"data":"status_active_role"},
            {"data":"options"}
        ],
        "responsive":"true",
        "destroy": true,
        "idisplaylength": 10,
        "order":[[0,"desc"]] 
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE AGREGAR NUEVO REGISTRO
    --------------------------------------------------------------*/
    $("#btnNew").click(function () {
        url_submit = base_url + '/roles/insert_role';
        form.trigger("reset");
        $(".modal-title").text("Nuevo Registro");
        $("#btnSubmit").text("Guardar");
        $("#ModalCRUD").modal("show");
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE REGISTRO
    --------------------------------------------------------------*/
    $(document).on("click", ".js-btn-view", function () {
        id_role = $(this).data('id');
        modal = "view";
        show_data(id_role, modal);
        $(".modal-title").text("Datos del Registro");
        $("#ModalSee").modal("show");
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE PERMISOS
    --------------------------------------------------------------*/
    $(document).on("click", ".js-btn-permissions", function () {
        url_submit = base_url + '/permissions/update_permission';
        id_role = $(this).data('id');
        show_permissions(id_role);
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE PERMISOS ADICIONALES
    --------------------------------------------------------------*/
    $(document).on("click", ".js-btn-additional-permissions", function () {
        url_submit = base_url + '/permissions/update_additional_permission';
        id_role = $(this).data('id');
        show_additional_permissions(id_role)
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE EDITAR
    --------------------------------------------------------------*/
    $(document).on("click", ".js-btn-edit", function () {
        url_submit = base_url + '/roles/update_role';
        id_role = $(this).data('id');
        modal = "edit";
        show_data(id_role, modal);
        $(".modal-title").text("Actualizar Registro");
        $("#btnSubmit").text("Actualizar");
        $("#ModalCRUD").modal("show");
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR LOS DATOS EN EL MODAL
    --------------------------------------------------------------*/
    function show_data(id_role) {
        url_read = base_url + '/roles/show_role';
        $.ajax({
            url: url_read,
            type: "POST",
            dataType: "json",
            data: {id_role:id_role},
            success: function (response) {
                if (response.status === false) {
                    showMessage(response.type, response.message);
                } else {
                    if (modal == "edit") {
                        $("#input-name-role").val(response.result.name_role);
                        $("#input-description-role").val(response.result.description_role);
                        $("#select-status-role").val(response.result.status_active_role);
                    }
                    if (modal == "view") {
                        $("#cell-name-role").text(response.result.name_role);
                        $("#cell-description-role").text(response.result.description_role);
                        if (response.result.status_active_role == 1) {
                            $("#cell-status-role").text("Activo");
                        } else {
                            $("#cell-status-role").text("Inactivo");
                        }
                    }
                }
            },
            error: function (error) {
                console.error("Error:", error);
                showMessage("error", "Ocurrió un problema al procesar la solicitud.");
            }
        });
    }

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR LOS PERMISOS EN EL MODAL
    --------------------------------------------------------------*/
    function show_permissions(id_role) {
        url_permission = base_url + '/permissions/show_permissions';
        $.ajax({
            url: url_permission,
            type: "POST",
            dataType: "html",
            data: {id_role:id_role},
            success: function (response) {
                $('#content-permissions-ajax').html(response);
                $("#ModalPermission").modal("show");
            },
            error: function (error) {
                console.error("Error:", error);
                showMessage("error", "Ocurrió un problema al procesar la solicitud.");
            }
        });
    }

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR LOS PERMISOS ADICIONALES EN EL MODAL
    --------------------------------------------------------------*/
    function show_additional_permissions(id_role) {
        url_additional_permissions = base_url + '/additional_permissions/show_additional_permissions';
        $.ajax({
            url: url_additional_permissions,
            type: "POST",
            dataType: "html",
            data: {id_role:id_role},
            success: function (response) {
                $('#content-additional-permissions-ajax').html(response);
                $("#ModalAdditionalPermission").modal("show");
            },
            error: function (error) {
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
        form_data.append('id_role', id_role);
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
    # FUNCIÓN PARA ACTUALIZAR PERMISOS
    --------------------------------------------------------------*/
    $(document).on('submit', '#formPermission', function (em) {                 
        em.preventDefault();
        let form_permission = $("#formPermission");
        url_submit = base_url + '/permissions/insert_or_update_permission';
        var form_data = new FormData(form_permission[0]);
        form_data.append('id_role', id_role);
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
                    $("#ModalPermission").modal("hide");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                showMessage("error", "Ocurrió un problema al procesar la solicitud.");
            }
        });											     			
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA ACTUALIZAR PERMISOS ADICIONALES
    --------------------------------------------------------------*/
    $(document).on('submit', '#formAdditionalPermission', function (em) {                 
        em.preventDefault();
        let form_additional_permission = $("#formAdditionalPermission");
        url_submit = base_url + '/additional_permissions/insert_or_update_additional_permission';
        var form_data = new FormData(form_additional_permission[0]);
        form_data.append('id_role', id_role);
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
                    $("#ModalAdditionalPermission").modal("hide");
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
            id_role = $(this).data('id');
            url_delete = base_url + "/roles/delete_role";
            Swal.fire({
                title: "¿Está seguro de eliminar el registro " + id_role + " del sistema?",
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
                        data: {id_role:id_role},
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
