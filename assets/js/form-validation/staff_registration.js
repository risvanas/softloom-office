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
                } else {
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
                }
            },
            ignore: "",
            rules: {
                txt_staff_name: {
                    minlength: 2,
                    maxlength: 35,
                    required: true
                },
                desi: {

                    required: true
                },
                txt_staff_desi: {

                    required: true
                },
                txt_staff_bio: {
                    required: true
                },
                txt_staff_jdate: {
                    required: true
                },
                txt_address1: {
                    minlength: 2,
                    maxlength: 60,
                    required: true
                },
                txt_address2: {
                    minlength: 2,
                    maxlength: 60,
                },
                txt_contact: {
                    minlength: 10,
                    maxlength: 12,
                    required: true,
                    number: true
                },
                /*rad_gender: {
                 required: true
                 },
                 txt_staff_dobdate: {
                 required: true
                 },
                 txt_staff_jdate : {
                 required: true
                 },*/
                status: {
                    required: true
                },
                staff_mode: {
                    required: true
                },
                txt_email: {

                    required: true,
                    email: true,
                },

                txt_course1: {
                    minlength: 2,
                    maxlength: 35,
                },
                txt_college1: {
                    minlength: 2,
                    maxlength: 35,
                },
                txt_year1: {
                    number: true,
                    minlength: 4,
                    maxlength: 4,
                },
                txt_mark1: {
                    number: true,
                    minlength: 2,
                    maxlength: 4,
                },
                txt_course2: {
                    minlength: 2,
                    maxlength: 35,
                },
                txt_college2: {
                    minlength: 2,
                    maxlength: 35,
                },
                txt_year2: {
                    number: true,
                    minlength: 4,
                    maxlength: 4,
                },
                txt_mark2: {
                    number: true,
                    minlength: 2,
                    maxlength: 4,
                },
                txt_course3: {
                    minlength: 2,
                    maxlength: 35,
                },

                txt_college3: {
                    minlength: 2,
                    maxlength: 35,
                },
                txt_year3: {
                    number: true,
                    minlength: 4,
                    maxlength: 4,
                },
                txt_mark3: {
                    number: true,
                    minlength: 2,
                    maxlength: 4,
                },
                staff_salary: {
                    number: true,
//                    required: true
                },
                
                txt_inactive_date: {
                    required: function (element) {
                        if ($("#drp_status").val() != 'INACTIVE') {
                            return false;
                        } else {
                            return true;
                        }
                    }
                },

            },
            messages: {
                required: "This field is required",
                //firstname : "Please specify first name",
                course_name: "Please specify course name",
                course_short: "Please specify course short name",
                email: {
                    required: "We need your email address to contact you",
                    email: "Your email address must be in the format of name@domain.com"
                },
                // gender: "Please check a gender!"
            },
            groups: {
                DateofBirth: "dd mm yyyy",
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