document.addEventListener('DOMContentLoaded', function () {

    let base_url = document.querySelector('meta[name="base-url"]').getAttribute('content');

    load_notifications();

    function load_notifications() {
        $.get(base_url + "/notifications/show_notification_dropdown",function(data){
            $('#content-dropdown-notifications-ajax').html(data);
        });
    }
    
    $(document).on('hidden.bs.dropdown', '#js-btn-notification', function () {
        $.post(base_url + "/notifications/mark_notifications_read",function(){
            load_notifications();
        });
    });

    setInterval(function() {
        load_notifications();
    }, 30000);

});