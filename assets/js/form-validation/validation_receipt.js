var FormValidator = function () {
    // function to initiate Validation Sample 1
    var runValidator1 = function () {
        var form1 = $('#form');
        var errorHandler1 = $('.errorHandler', form1);
        var successHandler1 = $('.successHandler', form1);
        $.validator.addMethod("BatchAddOrNot", function () {
            //if all values are selected
            if ($("#Num").val() == 2) {
                return false;
            } else {
                return true;
            }
        }, 'Please add batch');
        $('#form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                    error.insertAfter($(element).closest('.form-group').children('div').children().last());
                } 
				else {
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
                }
            },
            ignore: "",
            rules: {
                txt_receipt_date: {
                    required: true
                },	
					
				txt_voucher_date:{
					  required: true
				},
				
            },
            messages: {
				required : "This field is required.",
				//firstname : "Please specify first name",
                course_name: "Please specify course name",
                course_short: "Please specify course short name",
                email: {
                    required: "We need your email address to contact you",
                    email: "Your email address must be in the format of name@domain.com"
                },
               // gender: "Please check a gender!"
            },
                invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler1.hide();
                errorHandler1.show();
				document.getElementById('sub_reg').disabled=false;
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
            },
            submitHandler: function (form) {
                //successHandler1.show();
				
				//window.location= 'dashboard/branch_registration_1';
				//--------------------------------------------------------------------------
				/*var url = 'course_registration';
				var form = $('<form action="' + url + '" method="post"></form>');
				$('body').append(form);  // This line is not necessary
				$(form).submit();*/
				//-----------------------------------------------------------------------------------
                errorHandler1.hide();
				form.submit();
            }
        });
    };
   
    return {
        //main function to initiate template pages
        init: function () {
            runValidator1();
           
        }
    };
}();