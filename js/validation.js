jQuery(function() {
    // Setup form validation on the #register-form element

    jQuery("#ck_subscribe_form").validate({

    
        // Specify the validation rules
        rules: {
            ck_firstNameField: "required",
            ck_emailField: {
                required: true,
                email: true
            }
        },
        
        // Specify the validation error messages
        messages: {
            ck_firstNameField: "Please enter your first name",
            ck_emailField: "Please enter a valid email address",
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });



  });
