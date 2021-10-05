jQuery(document).ready(function(){

    $('input').on('blur keyup', function() {
        if($("#tk-login-btn").hasClass("validateActive")){
            console.log('checking');
            if ($("#tokenly-login-form").valid()) {
                $('#tk-login-btn').prop('disabled', false);  
            } else {
                $('#tk-login-btn').prop('disabled', 'disabled');
            }
        }
    });
})