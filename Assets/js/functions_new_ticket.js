document.addEventListener('DOMContentLoaded', function () {

    let form = $("#formNewTicket");
    let base_url = document.querySelector('meta[name="base-url"]').getAttribute('content');

    initialize_upload();

    /* TODO: Llenar Combo categoria */
    $.post(base_url + "/categories/combo",function(data){
        $('#select-category').html(data);
    });

    $("#select-category").change(function(){
        cat_id = $(this).val();
        /* TODO: llenar Combo subcategoria segun cat_id */
        $.post(base_url + "/subcategories/combo",{cat_id : cat_id},function(data){
            $('#select-subcategory').html(data);
        });
    });

    /* TODO: Llenar combo Prioridad  */
    $.post(base_url + "/priorities/combo",function(data){
        $('#select-priority').html(data);
    });

    form.submit(function(e){
        e.preventDefault();
        
        var url = base_url + '/tickets/insert_ticket';
        var form_data = new FormData(form[0]);
        form_data = result_data(form_data);

        $.ajax({
            url: url,
            type:"POST",
            data: form_data, 
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                var response = JSON.parse(response);
                if (response.status === false) {
                    showMessage(response.type, response.message);
                } else {
                    showMessage(response.type, response.message);
                    form[0].reset();
                    $('#select-subcategory').html('<option selected disabled value="">Selecciona una opción</option>');
                    clear_uploaded_files();
                }

            }      
        });

    });


});