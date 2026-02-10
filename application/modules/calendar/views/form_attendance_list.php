<style>
/*    .hide_daywise, .hide_individual {
        display: none;
    }*/
</style>

<div class="row" style="padding-top:20px;" >
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default" style="min-height:555px;">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Attendance Report
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> 
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> 
                    <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> 
<!--                    <form action="<?php // echo site_url('spare/mult_search');    ?>" method="post" id="form_excel_pdf" name="form_excel_pdf" target="_blank"> 
                        <input type="hidden" name="type" id="type" value="toner_rep">
                        <input type="hidden" name="ins_statu" id="ins_statu" value="">
                        <input type="hidden" name="fromdate" id="fromdate" value="">
                        <input type="hidden" name="todate" id="todate" value="">
                        <input type="hidden" name="call_statu" id="call_statu" value="">
                        <input type="hidden" name="generate_pdf" value="generate_pdf">
                        <button title="Export to pdf" class="btn_pdf_excel export_pdf" onclick="document.form_excel_pdf.generate_pdf.value = 'generate_pdf';this.form.target = '_blank';this.form.submit();"><i class="clip-file-pdf"></i></button>
                        <button class="btn_pdf_excel export_excel" title="export to excel" onclick="document.form_excel_pdf.generate_pdf.value = 'generate_excel';this.form.target = '';this.form.submit();"><i class="clip-file-excel"></i></button>
                    </form>-->
                </div>
            </div>

            <div class="panel-body" >
                <!--                <div class="row">
                                    <div class="col-md-12">
                                        <h1>Leave Application List<small></small></h1>
                                        <hr />
                                    </div>
                                </div>-->
                <div class="row">
<!--                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="form-field-mask-1">Report Type </label>
                            <select class="form-control" id="search_rep_type" name="search_rep_type" onchange="show_rep_type(this)">
                                <option value="">Select</option>
                                <option value="daywise">Daywise</option>
                                <option value="individual">Individual</option>
                            </select>
                            <span for="search_rep_type" class="help-block"></span>
                        </div>
                    </div>-->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="form-field-mask-1">Year </label>
                            <select class="form-control" id="search_year" name="search_year" onchange="get_month(this)">
                                <option value="">Select</option>
                                <?php foreach ($year_list->result() as $key => $value) {
                                    $selected_year = ($value->YEAR == date('Y')) ? "selected" : ""
                                    ?>
                                    <option value="<?php echo $value->YEAR ?>" <?php echo $selected_year ?>><?php echo $value->YEAR ?></option>
                                <?php } ?>
                            </select>
                            <span for="search_year" class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="form-field-mask-1">Month </label>
                            <select class="form-control" id="search_month" name="search_month">
                                <option value="">Select</option>
                                <?php foreach ($mnth_list->result() as $key => $value) {
                                    $selected_mnth = ($value->ID == date('m')) ? "selected" : ""
                                    ?>
                                    <option value="<?php echo $value->ID ?>" <?php echo $selected_mnth ?>><?php echo $value->MONTH ?></option>
                                <?php } ?>
                            </select>
                            <span for="search_month" class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-md-2 hide_individual">
                        <div class="form-group">
                            <label for="form-field-mask-1">Staff Status </label>
                            <select class="form-control" id="search_staff_status" name="search_staff_status">
                                <option value="">All</option>
                                <option value="ACTIVE" selected="">Active</option>
                                <!--<option value="">Select</option>-->
                                <?php // foreach ($staff_list->result() as $key => $value) { ?>
                                    <!--<option value="<?php // echo $value->BIOMETRIC_CODE ?>"><?php // echo $value->ACC_NAME ?></option>-->
                                <?php // } ?>
                            </select>
                            <!--<span for="search_staff" class="help-block"></span>-->
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group"> <br>
                            <button type="button" class="btn btn-green btn-block" onclick="search_data()">search</button>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="" >
                            <div id="output" class="">
                                <div class="panel-group accordion-custom accordion-teal" id="accordion">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end: DYNAMIC TABLE PANEL --> 
    </div>
</div>

<!-- end: PAGE HEADER --> 

<script>
    function search_data()
    {
        $(".form-group").removeClass("has-error");
        $(".help-block").html("");
        var flag = 0;
        console.log($('#search_rep_type').val())
        if($("#search_rep_type").val() == "") {
            $("#search_rep_type").closest(".form-group").addClass("has-error");
            $("#search_rep_type").siblings(".help-block").html("This field is required.");
        } else {
            if($("#search_rep_type").val() == "individual") {
                if($("#search_year").val() != "" && $("#search_month").val() != "" && $("#search_staff").val() != "") {
                    flag = 1;
                } else {
                    if($("#search_year").val() == "") {
                        $("#search_year").closest(".form-group").addClass("has-error");
                        $("#search_year").siblings(".help-block").html("This field is required.");
                    }
                    if($("#search_month").val() == "") {
                        $("#search_month").closest(".form-group").addClass("has-error");
                        $("#search_month").siblings(".help-block").html("This field is required.");
                    }
                    if($("#search_staff").val() == "") {
                        $("#search_staff").closest(".form-group").addClass("has-error");
                        $("#search_staff").siblings(".help-block").html("This field is required.");
                    }
                }
            } else {
                if($("#txt_from").val() == "") {
                    $("#txt_from").closest(".form-group").addClass("has-error");
                    $("#txt_from").closest(".input-icon").siblings(".help-block").html("This field is required.");
                } else {
                    flag = 1;
                }
            }
        }
        if(flag == 1) { 
            $.ajax({
                type: "POST",
                data:
                {
                    rep_type: $('#search_rep_type').val(),
                    year: $('#search_year').val(),
                    month: $('#search_month').val(),
                    staff: $('#search_staff').val(),
                    date: $('#txt_from').val(),
                    staff_status: $('#search_staff_status').val()
                },
                url: "<?php echo site_url('calendar/mult_search'); ?>",
                success: function (data)
                {
                    $('#output').html(data);
    //                $("#ins_statu").val($('#search_ins_status').val())
    //                $("#call_statu").val($('#search_call_status').val())
    //                $("#fromdate").val($('#txt_from').val())
    //                $("#todate").val($('#txt_to').val())
    //                $("#sort_by").val($('#order_by').val())
    //                $("#per_page").val($('#search_status').val())
    //                $("#cur_page").val($('#search_status').val())
                }
            });
        }
    }
    
    function get_month(obj)
    {
        //alert("hai");
        var year = $(obj).val();
        $.ajax({
            type: "POST",
            data: {year: year},
            url: "<?php echo site_url('attendance/get_month'); ?>",
            success: function (data)
            {
                data = jQuery.parseJSON( data );
                var option = '<option value="">Select</option>';
                $.each(data, function( index, value ) {
                    option += '<option value="' + value['ID'] + '">' + value['MONTH'] + '</option>';
                });
                $("#search_month").html(option);
            }
        });
    }
    
//    function show_rep_type(obj) {
//        if($(obj).val() == 'daywise') {
//            $(".hide_individual").hide();
//            $(".hide_daywise").show();
//        } else if($(obj).val() == 'individual'){
//            $(".hide_daywise").hide();
//            $(".hide_individual").show();
//        } else {
//            $(".hide_individual").hide();
//            $(".hide_daywise").hide();
//        }
//    }
</script> 
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormElements.init();
        
        search_data();
    });

</script> 
