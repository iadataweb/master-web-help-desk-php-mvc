document.addEventListener('DOMContentLoaded', function () {

    let base_url = document.querySelector('meta[name="base-url"]').getAttribute('content');
    let tablaDataTable;
    let url;
    url = base_url + "/tickets/show_tickets";
    tablaDataTable = $('#tableListTicket').DataTable({
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

    /* TODO: Link para poder ver el detalle de ticket en otra ventana */
    $(document).on("click",".btn-see",function(){
        const url_details = $(this).data("url-details");
        window.open( base_url + '/tickets/ticket_details/' + url_details);
    });

});