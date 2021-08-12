jQuery(document).ready(function(){

    jQuery("#tokenly-login-form").validate({
        rules: {
            "cn-ex-balance": {
                required: true
            },
            "cn-ex-interest": {
                required: true
            },
            "cn-ex-monthly-charges": {
                required: true
            },
            "cn-ex-monthly-payment": {
                required: true
            },
        },
        messages: {
            "cn-ex-balance": {
                required: "This field is required"
            },
            "cn-ex-interest": {
                required: "This field is required"
            },
            "cn-ex-monthly-charges": {
                required: "This field is required"
            },
            "cn-ex-monthly-payment": {
                required: "This field is required"
            },
        }
        // errorClass: "help-inline text-danger",
        // errorElement: "span",
        // highlight: function(element, errorClass, validClass) {
        //     $(element).parents('.form-group').addClass('has-error');
        // },
        // unhighlight: function(element, errorClass, validClass) {
        //     $(element).parents('.form-group').removeClass('has-error');
        //     $(element).parents('.form-group').addClass('has-success');
        // },
    });
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
    console.log('js check');
    // jQuery(document).on('click','#tk-login-btn',function(e){
    //     e.preventDefault();
    //     console.log('form submit hit !!');
    //     var formData = jQuery('#tokenly-login-form').serializeArray();
    //     console.log(formData);
    //     var tk_username = formData[0]['value'];
    //     var tk_password= formData[1]['value'];
    //     $(".error").remove();


    //     if($("#tokenly-login-form").valid() == false){
    //         $('#tk-login-btn').prop('disabled', 'disabled');
    //         $('#tk-login-btn').addClass('validateActive');
    //         return false;
    //     }else{
    //         jQuery.ajax({
    //             url: '/tokenly/wp-admin/admin-ajax.php',
    //             type: 'POST',
    //             data: { 
    //                 action:'get_calc_form',
    //                 form_data: formData,
    //             },
    //             success: function(data) {
    //                 console.log(data);
    //                 jQuery('#loginModal .modal-body ').html(data);
    //                 jQuery('#loginModal').modal('show');
    //             }
    //         });
    //     }


    //     // console.log($('form[id="tokenly-login-form"]').validate());

    //     console.log( $("#tokenly-login-form").valid());
    // })

    jQuery(document).on('click','.cn-calc-recalculate',function(){
        var template = jQuery(this).attr('template');
        var filename = jQuery(this).attr('filename');
        setTimeout(function () {
            $('#tk-login-btn').prop('disabled', 'disabled');
            $('#tk-login-btn').addClass('validateActive');
        }, 2500);

        jQuery.ajax({
            url: '/centsai/wp-admin/admin-ajax.php',
            type: 'POST',
            data: { 
                action:'fetch_template',
                templateName: template,
                fileName:filename
            },
            success: function(data) {
                console.log(data);
                jQuery('.entry-content').html(data);
            }
        });
    });
})