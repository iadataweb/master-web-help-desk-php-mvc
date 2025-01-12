document.addEventListener('DOMContentLoaded', function () {

    let form = $("#formSubcategory");
    let base_url = document.querySelector('meta[name="base-url"]').getAttribute('content');
    let tablaDataTable;
    let url;
    let url_submit;
    let url_read;
    let url_delete;
    var id_subcategory;
    var modal;

    url = base_url + "/subcategories/show_subcategories";

    tablaDataTable = $('#tableManageSubcategories').DataTable({
        "aProcessing":true,
        "aServerSide":true,
        "ajax": {
            "url": url,
            "dataSrc":""
        },
        "language": languageDatatable(),
        "columns": [
            {"data":"id_subcategory"},
            {"data":"name_subcategory"},
            {"data":"name_category"},
            {"data":"options"}
        ],
        "responsive":"true",
        "destroy": true,
        "idisplaylength": 10,
        "order":[[0,"desc"]] 
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA LLENAR SELECT CATEGORY CON EL RESULTADO
    --------------------------------------------------------------*/
    $.post(base_url + "/categories/combo", function(data) {
        $('#select-category').html(data);
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE AGREGAR NUEVO REGISTRO
    --------------------------------------------------------------*/
    $("#btnNew").click(function () {
        url_submit = base_url + '/subcategories/insert_subcategory';
        form.trigger("reset");
        $(".modal-title").text("Nuevo Registro");
        $("#btnSubmit").text("Guardar");
        $("#ModalCRUD").modal("show");
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE REGISTRO
    --------------------------------------------------------------*/
    $(document).on("click", ".js-btn-view", function () {
        id_subcategory = $(this).data('id');
        modal = "view";
        show_data(id_subcategory, modal);
        $(".modal-title").text("Datos del Registro");
        $("#ModalSee").modal("show");
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE EDITAR
    --------------------------------------------------------------*/
    $(document).on("click", ".js-btn-edit", function () {
        url_submit = base_url + '/subcategories/update_subcategory';
        id_subcategory = $(this).data('id');
        modal = "edit";
        show_data(id_subcategory, modal);
        $(".modal-title").text("Actualizar Registro");
        $("#btnSubmit").text("Actualizar");
        $("#ModalCRUD").modal("show");
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR LOS DATOS EN EL MODAL
    --------------------------------------------------------------*/
    function show_data(id_subcategory) {
        url_read = base_url + '/subcategories/show_subcategory';
        $.ajax({
            url: url_read,
            type: "POST",
            dataType: "json",
            data: {id_subcategory:id_subcategory},
            success: function (response) {
                if (response.status === false) {
                    showMessage(response.type, response.message);
                } else {
                    if (modal == "edit") {
                        $("#input-name-subcategory").val(response.result.name_subcategory);
                        $("#select-category").val(response.result.id_category_subcategory);
                    }
                    if (modal == "view") {
                        $("#cell-name-subcategory").text(response.result.name_subcategory);
                        $("#cell-name-category").text(response.result.name_category);
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
        form_data.append('id_subcategory', id_subcategory);
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
            id_subcategory = $(this).data('id');
            url_delete = base_url + "/subcategories/delete_subcategory";
            Swal.fire({
                title: "¿Está seguro de eliminar el registro " + id_subcategory + " del sistema?",
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
                        data: {id_subcategory:id_subcategory},
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
