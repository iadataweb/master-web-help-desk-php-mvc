document.addEventListener('DOMContentLoaded', function () {
    let form = $("#formLogin");
    let base_url = document.querySelector('meta[name="base-url"]').getAttribute('content');
    let url_submit;
    let email;
    let password;
    /*--------------------------------------------------------------
    # FUNCIÓN PARA INICIAR SESIÓN
    --------------------------------------------------------------*/
    form.submit(function(e){                         
        e.preventDefault();
        email = $.trim($("#email").val());    
        password = $.trim($("#password").val());
        if(email.length == ""){
            showMessage("warning", "Debe ingresar el correo electrónico.");
            return false; 
        } else if(password.length == ""){
            showMessage("warning", "Debe ingresar la contraseña.");
            return false; 
        } else if(email.length == "" && password.length == ""){
            showMessage("warning", "Debe ingresar el correo electrónico y la contraseña.");
            return false; 
        } else {
            url_submit = base_url + '/login/login_user'; 
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
                        window.location = base_url + '/dashboard';
                    }
                },
                error: function (error) {
                    console.error("Error:", error);
                    showMessage("error", "Ocurrió un problema al procesar la solicitud.");
                }
            });
        }
    });
});
