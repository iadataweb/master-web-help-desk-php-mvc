document.addEventListener('DOMContentLoaded', function () {

    let form;
    let base_url = document.querySelector('meta[name="base-url"]').getAttribute('content');
    const channel = new BroadcastChannel('tickets_updates');
    let id_ticket = window.location.href.match(/\/(\d+)$/)[1];
    let url_messages_ticket;
    let url_submit;

    display_messages_ticket(id_ticket);
    display_form(id_ticket)

    setInterval(() => {
        display_messages_ticket(id_ticket);
    }, 5000);

    function display_messages_ticket(id_ticket) {
        url_messages_ticket = base_url + '/tickets/show_messages_all';
        $.ajax({
            url: url_messages_ticket,
            type: "GET",
            dataType: "html",
            data: {id_ticket:id_ticket},
            success: function (response) {
                $('#content-message-box-ajax').html(response);
            },
            error: function (error) {
                console.error("Error:", error);
                showMessage("error", "Ocurrió un problema al procesar la solicitud.");
            }
        });
    }

    function display_form(id_ticket) {
        url_messages_ticket = base_url + '/tickets/show_form';
        $.ajax({
            url: url_messages_ticket,
            type: "GET",
            dataType: "html",
            data: {id_ticket:id_ticket},
            success: function (response) {
                $('#content-form-ajax').html(response);
                if ($('#formNewMessage').length > 0) {
                    initialize_upload();
                }
            },
            error: function (error) {
                console.error("Error:", error);
                showMessage("error", "Ocurrió un problema al procesar la solicitud.");
            }
        });
    }

    /*--------------------------------------------------------------
    # FUNCIÓN PARA MOSTRAR CERRAR TICKET
    --------------------------------------------------------------*/
    $(document).on("click", ".js-btn-close", function () {
        url_submit = base_url + '/tickets/close_ticket';
        form = $("#formNewMessage");
        var form_data = new FormData(form[0]);
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

                    $('#ticket-status').text('Ticket Cerrado').removeClass('badge bg-success').addClass('badge bg-danger');

                    display_form(id_ticket)

                    channel.postMessage({ action: 'reloadDataTable' });
                }
            },
            error: function (error) {
                console.error("Error:", error);
                showMessage("error", "Ocurrió un problema al procesar la solicitud.");
            }
        });	
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA ACTUALIZAR REGISTRO
    --------------------------------------------------------------*/
    $(document).on('submit', '#formTicketReopen', function (em) {                 
        em.preventDefault();
        form = $("#formTicketReopen");
        url_submit = base_url + '/tickets/reopen_ticket';
        var form_data = new FormData(form[0]);
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

                    $('#ticket-status').text('Ticket Activo').removeClass('badge bg-danger').addClass('badge bg-success');

                    display_form(id_ticket)

                    channel.postMessage({ action: 'reloadDataTable' });
                }
            },
            error: function (error) {
                console.error("Error:", error);
                showMessage("error", "Ocurrió un problema al procesar la solicitud.");
            }
        });											     			
    });

    /*--------------------------------------------------------------
    # FUNCIÓN PARA ENVIAR MENSAJE
    --------------------------------------------------------------*/
    $(document).on('submit', '#formNewMessage', function (ems) {                 
        ems.preventDefault();
        form = $("#formNewMessage");
        url_submit = base_url + '/tickets/insert_new_message';
        var form_data = new FormData(form[0]);
        form_data = result_data(form_data);

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
                    form[0].reset();
                    clear_uploaded_files();
                    // REINICIAR
                    // messageBox.innerHTML = '';
                    // displayMessagesTicket();
                }
            },
            error: function (error) {
                console.error("Error:", error);
                showMessage("error", "Ocurrió un problema al procesar la solicitud.");
            }
        });											     			
    });

});
