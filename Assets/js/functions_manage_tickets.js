document.addEventListener('DOMContentLoaded', function () {

    let form = $("#formTicket");
    let form_assign = $("#formAssign");
    let base_url = document.querySelector('meta[name="base-url"]').getAttribute('content');
    let tablaDataTable;
    let url;
    let url_submit;
    let url_read;
    let url_delete;
    var id_ticket;
    const channel = new BroadcastChannel('tickets_updates');
    url = base_url + "/tickets/show_tickets";

    tablaDataTable = $('#tableManageTickets').DataTable({
        "aProcessing":true,
        "aServerSide":true,
        "ajax": {
            "url": url,
            "dataSrc":""
        },
        "language": languageDatatable(),
        "columns": [
            {"data":"id_ticket"},
            {"data":"name_category"},
            {"data":"title_ticket"},
            {"data":"name_priority"},
            {"data":"status_open_ticket"},
            {"data":"date_created_ticket"},
            {"data":"date_assigned_ticket"},
            {"data":"date_closed_ticket"},
            {"data":"id_support_assigned_ticket"},
            {"data":"options"}
        ],
        "resonsieve":"true",
        "destroy": true,
        "idisplaylength": 10,
        "order":[[0,"desc"]] 
    });

    initialize_upload();

    $.post(base_url + "/categories/combo",function(data){
        $('#select-category').html(data);
    });

    $("#select-category").change(function(){
        cat_id = $(this).val();
        $.post(base_url + "/subcategories/combo",{cat_id : cat_id},function(data){
            $('#select-subcategory').html(data);
        });
    });
    
    $.post(base_url + "/priorities/combo",function(data){
        $('#select-priority').html(data);
    });

    $.post(base_url + "/users/show_end_users",function(data){
        $('#select-user').html(data);
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE AGREGAR NUEVO REGISTRO
    --------------------------------------------------------------*/
    $("#btnNew").click(function () {
        url_submit = base_url + '/tickets/insert_ticket';
        form.trigger("reset");
        clear_uploaded_files();
        $('#select-subcategory').html('<option selected disabled value="">Selecciona una opción</option>');
        $("#ModalCRUD .modal-title").text("Nuevo Registro");
        $("#btnSubmit").text("Guardar");
        $("#ModalCRUD").modal("show");
    });
    
    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE EDITAR
    --------------------------------------------------------------*/
    $(document).on("click", ".js-btn-edit", function () {
        url_submit = base_url + '/tickets/update_ticket';
        clear_uploaded_files();
        id_ticket = $(this).data('id');
        modal = "edit";
        show_data(id_ticket, modal);
        $("#ModalCRUD .modal-title").text("Actualizar Registro");
        $("#btnSubmit").text("Actualizar");
        $("#ModalCRUD").modal("show");
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR LOS DATOS EN EL MODAL
    --------------------------------------------------------------*/
    function show_data(id_ticket) {
        url_read = base_url + '/tickets/show_ticket';
        $.ajax({
            url: url_read,
            type: "POST",
            dataType: "json",
            data: {id_ticket:id_ticket},
            success: function (response) {
                if (response.status === false) {
                    showMessage(response.type, response.message);
                } else {
                    if (modal == "edit") {
                        $("#input-title").val(response.result.title_ticket);
                        $("#select-category").val(response.result.id_category);
                        $.post(base_url + "/subcategories/combo",{cat_id : response.result.id_category},function(data){
                            $('#select-subcategory').html(data);
                            $("#select-subcategory").val(response.result.id_subcategory);
                        });
                        $("#select-priority").val(response.result.id_priority);
                        $("#select-user").val(response.result.id_user_ticket);
                        $("#textarea-description").val(response.result.description_ticket);
                        load_existing_attachments(response.attachments);
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
    # FUNCIÓN PARA LLENAR SELECT SUPPORT CON EL RESULTADO
    --------------------------------------------------------------*/
    $.post(base_url + "/tickets/show_support", function(data) {
        $('#select-support').html(data);
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR MODAL DE ASIGNAR
    --------------------------------------------------------------*/
    $(document).on("click", ".js-btn-assign", function () {
        url_submit = base_url + '/tickets/update_support';
        form.trigger("reset");
        id_ticket = $(this).data('id');
        $("#ModalAssign .modal-title").text("Asignar soporte");
        $("#ModalAssign").modal("show");
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA ACTUALIZAR REGISTRO
    --------------------------------------------------------------*/
    form_assign.submit(function(e){                         
        e.preventDefault();
        var form_data = new FormData(form_assign[0]);
        form_data.append('id_ticket', id_ticket);
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
                    $("#ModalAssign").modal("hide");
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
    # FUNCIÓN PARA REGISTRAR O ACTUALIZAR REGISTRO
    --------------------------------------------------------------*/
    form.submit(function(e){
        e.preventDefault();
        
        var form_data = new FormData(form[0]);
        form_data = result_data(form_data);
        form_data.append('id_ticket', id_ticket);

        $.ajax({
            url: url_submit,
            type:"POST",
            data: form_data, 
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                var response = JSON.parse(response);
                if (response.status === false) {
                    console.log(response.message);
                    showMessage(response.type, response.message);
                } else {
                    showMessage(response.type, response.message);
                    $("#ModalCRUD").modal("hide");
                    tablaDataTable.ajax.reload(null, false);
                    
                    form[0].reset();

                    $('#select-subcategory').html('<option selected disabled value="">Selecciona una opción</option>');
                }

            }      
        });

    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA ELIMINAR REGISTRO
    --------------------------------------------------------------*/
    $(document).on("click", ".js-btn-delete", function () {
        id_ticket = $(this).data('id');
        url_delete = base_url + "/tickets/delete_ticket";
        Swal.fire({
            title: "¿Está seguro de eliminar el registro " + id_ticket + " del sistema?",
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
                    data: {id_ticket:id_ticket},
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

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MANEJAR LOS MENSAJES DEL CANAL
    --------------------------------------------------------------*/
    channel.onmessage = function(event) {
        if (event.data.action === 'reloadDataTable') {
            tablaDataTable.ajax.reload(null, false);
        }
    };

    /* TODO: Link para poder ver el detalle de ticket en otra ventana */
    $(document).on("click",".btn-see",function(){
        const url_details = $(this).data("url-details");
        window.open( base_url + '/tickets/ticket_details/' + url_details);
    });

});