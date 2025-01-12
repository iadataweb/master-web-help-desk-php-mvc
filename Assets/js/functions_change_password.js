document.addEventListener('DOMContentLoaded', function () {

    let form = document.getElementById("formChangePassword");
    let base_url = document.querySelector('meta[name="base-url"]').getAttribute('content');

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        var url = base_url + '/account/update_password';
        var form_data = new FormData(form);

        fetch(url, {
            method: 'POST',
            body: form_data
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (response) {
            if (response.status === false) {
                showMessage(response.type, response.message);
            } else {
                showMessage(response.type, response.message);
                form.reset();
            }
        })
        .catch(function (error) {
            console.error('Error:', error);
        });
        
    });

});
