document.addEventListener('DOMContentLoaded', function () {

    let form = $("#formCategory");
    let base_url = document.querySelector('meta[name="base-url"]').getAttribute('content');
    let tablaDataTable;
    let url;
    let url_submit;
    let url_read;
    let url_delete;
    var id_category;
    var modal;

    url = base_url + "/categories/show_categories";

    tablaDataTable = $('#tableManageCategories').DataTable({
        "aProcessing":true,
        "aServerSide":true,
        "ajax": {
            "url": url,
            "dataSrc":""
        },
        "language": languageDatatable(),
        "columns": [
            {"data":"id_category"},
            {"data":"name_category"},
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
        url_submit = base_url + '/categories/insert_category';
        form.trigger("reset");
        $(".modal-title").text("Nuevo Registro");
        $("#btnSubmit").text("Guardar");
        $("#ModalCRUD").modal("show");
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE REGISTRO
    --------------------------------------------------------------*/
    $(document).on("click", ".js-btn-view", function () {
        id_category = $(this).data('id');
        modal = "view";
        show_data(id_category, modal);
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE EDITAR
    --------------------------------------------------------------*/
    $(document).on("click", ".js-btn-edit", function () {
        url_submit = base_url + '/categories/update_category';
        id_category = $(this).data('id');
        modal = "edit";
        show_data(id_category, modal);
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR LOS DATOS EN EL MODAL
    --------------------------------------------------------------*/
    function show_data(id_category) {
        url_read = base_url + '/categories/show_category';
        $.ajax({
            url: url_read,
            type: "POST",
            dataType: "json",
            data: {id_category:id_category},
            success: function (response) {
                if (response.status === false) {
                    showMessage(response.type, response.message);
                } else {
                    if (modal == "edit") {
                        $("#input-name-category").val(response.result.name_category);
                        $(".modal-title").text("Actualizar Registro");
                        $("#btnSubmit").text("Actualizar");
                        $("#ModalCRUD").modal("show");
                    }
                    if (modal == "view") {
                        $("#cell-name-category").text(response.result.name_category);
                        $(".modal-title").text("Datos del Registro");
                        $("#ModalSee").modal("show");
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
    # FUNCIÓN PARA REGISTRAR O ACTUALIZAR REGISTRO
    --------------------------------------------------------------*/
    form.submit(function(e){                         
        e.preventDefault();
        var form_data = new FormData(form[0]);
        form_data.append('id_category', id_category);
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
            error: function (error) {
                console.error("Error:", error);
                showMessage("error", "Ocurrió un problema al procesar la solicitud.");
            }
        });											     			
    }); 


    /*--------------------------------------------------------------
    # FUNCIÓN PARA ELIMINAR REGISTRO
    --------------------------------------------------------------*/
        $(document).on("click", ".js-btn-delete", function () {
            id_category = $(this).data('id');
            url_delete = base_url + "/categories/delete_category";
            Swal.fire({
                title: "¿Está seguro de eliminar el registro " + id_category + " del sistema?",
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
                        data: {id_category:id_category},
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
