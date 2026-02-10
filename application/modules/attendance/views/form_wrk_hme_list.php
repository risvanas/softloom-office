<div class="row" style="padding-top:20px;" >
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default" style="min-height:555px;">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Work On Home List
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> 
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> 
                    <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> 
<!--                    <form action="<?php // echo site_url('spare/mult_search');      ?>" method="post" id="form_excel_pdf" name="form_excel_pdf" target="_blank"> 
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
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="form-field-mask-1">Year </label>
                            <select class="form-control" id="search_year" name="search_year" onchange="get_month(this)">
                                <option value="">Select</option>
                                <?php foreach ($year_list->result() as $key => $value) { ?>
                                    <option value="<?php echo $value->YEAR ?>"><?php echo $value->YEAR ?></option>
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
                            </select>
                            <span for="search_month" class="help-block"></span>
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
                        <div class="ps-container" >
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
        if ($("#search_year").val() != "" && $("#search_month").val() != "") {
            flag = 1;
        } else {
            if ($("#search_year").val() == "") {
                $("#search_year").closest(".form-group").addClass("has-error");
                $("#search_year").siblings(".help-block").html("This field is required.");
            }
            if ($("#search_month").val() == "") {
                $("#search_month").closest(".form-group").addClass("has-error");
                $("#search_month").siblings(".help-block").html("This field is required.");
            }
//            if ($("#search_staff").val() == "") {
//                $("#search_staff").closest(".form-group").addClass("has-error");
//                $("#search_staff").siblings(".help-block").html("This field is required.");
//            }
        }
        if (flag == 1) {
            $.ajax({
                type: "POST",
                data:
                {
                    year: $('#search_year').val(),
                    month: $('#search_month').val(),
//                    staff: $('#search_staff').val(),
                    type: 'hme'
                },
                url: "<?php echo site_url('attendance/mult_search'); ?>",
                success: function (data)
                {
                    $('#output').html(data);
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
                data = jQuery.parseJSON(data);
                var option = '<option value="">Select</option>';
                $.each(data, function (index, value) {
                    option += '<option value="' + value['ID'] + '">' + value['MONTH'] + '</option>';
                });
                $("#search_month").html(option);
            }
        });
    }

    function show_rep_type(obj) {
        if ($(obj).val() == 'daywise') {
            $(".hide_individual").hide();
            $(".hide_daywise").show();
        } else if ($(obj).val() == 'individual') {
            $(".hide_daywise").hide();
            $(".hide_individual").show();
        } else {
            $(".hide_individual").hide();
            $(".hide_daywise").hide();
        }
    }
</script> 
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormElements.init();

    });

</script> 
