var FormValidator = function () {
    // function to initiate Validation Sample 1
    var runValidator1 = function () {
        var form1 = $('#form');
        var errorHandler1 = $('.errorHandler', form1);
        var successHandler1 = $('.successHandler', form1);
        $.validator.addMethod("FullDate", function () {
            //if all values are selected
            if ($("#dd").val() != "" && $("#mm").val() != "" && $("#yyyy").val() != "") {
                return true;
            } else {
                return false;
            }
        }, 'Please select a day, month, and year');
        $('#form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                    error.insertAfter($(element).closest('.form-group').children('div').children().last());
                } else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
                    error.insertAfter($(element).closest('.form-group').children('div'));
                } else {
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
                }
            },
            ignore: "",
            rules: {
                branch_name: {
                    minlength: 2,
					maxlength: 50,
                    required: true
                },
				branch_code: {
                    minlength: 2,
					maxlength: 5,
                    required: true
                },
				address_1: {
                    minlength: 2,
					maxlength: 50,
                    required: true
                },
				address_2: {
                    minlength: 2,
					maxlength: 50,
                },
				address_3: {
                    minlength: 2,
					maxlength: 50,
                    required: true
                },
				state: {
                    minlength: 2,
					maxlength: 50,
                    required: true
                },
				country: {
                    minlength: 2,
					maxlength: 50,
                    required: true
                },
				zip_code: {
                    minlength: 6,
					maxlength: 6,
                    required: true
                },
				phone_1:{
					minlength: 6,
					maxlength: 15,
                    required: true
				},
				phone_2:{
					minlength: 6,
					maxlength: 15,
				},
				fax:{
					minlength: 6,
					maxlength: 13,
				},
				email_id:{
					minlength: 5,
					maxlength: 50,
                    required: true,
					email: true
				},
				website:{
					minlength: 5,
					maxlength: 50,
                    required: true
				}
            },
            messages: {
                branch_name: "Please specify branch name",
			branch_name: {
				maxlength : "This field maximum length 50",
			},
			branch_code: {
				maxlength : "This field maximum length 5",
			},
			address_1: {
				maxlength : "This field maximum length 50",
			},
			address_2: {
				maxlength : "This field maximum length 50",
			},
			address_3: {
				maxlength : "This field maximum length 50",
			},
			state: {
				maxlength : "This field maximum length 50",
			},
			country: {
				maxlength : "This field maximum length 50",
			},
			zip_code: {
				maxlength : "This field maximum length 50",
			},
			email_id: {
				email: "Your email address must be in the format of name@domain.com"
			},
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler1.hide();
                errorHandler1.show();
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
                successHandler1.show();
				form.submit();
				//window.location= 'dashboard/branch_registration_1';
				//--------------------------------------------------------------------------
				/*var url = 'course_registration';
				var form = $('<form action="' + url + '" method="post"></form>');
				$('body').append(form);  // This line is not necessary
				$(form).submit();*/
				//-----------------------------------------------------------------------------------
                errorHandler1.hide();
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