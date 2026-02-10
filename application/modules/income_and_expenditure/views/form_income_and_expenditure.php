<div class="row" style="padding-top:20px;" >
    <div class="col-md-9"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default" style="min-height:555px;">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>Income and Expenditure
                <div class="panel-tools"></div>
                <!--<div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>-->
            </div>
            <div class="panel-body">
                <div id="table"></div>
            </div>
        </div>
    </div>

    <!-- end: PAGE TITLE & BREADCRUMB -->

    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <!--                <div class="page-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h1>Income and Expenditure <small></small></h1>
                
                                        </div>
                                    </div>
                                </div>-->
                <!--        <div class="row">
                          <div class="col-md-2">-->
                <div class="form-group">
                    <label class="control-label"> From Date</label>
                    <span class="input-icon input-icon-right">
                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="from_date" id="from_date"/>
                        <i class="icon-calendar"></i> </span> </div>
                <!--          </div>
                          <div class="col-md-2">-->
                <div class="form-group">
                    <label class="control-label"> To Date</label>
                    <span class="input-icon input-icon-right">
                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="to_date" name="to_date"/>
                        <i class="icon-calendar"></i> </span> </div>
                <?php
                $sess_array = $this->session->userdata('logged_in');
                $user_type = $sess_array['user_type'];
                $company_code = $sess_array['comp_code'];
                if ($user_type == 'ADMIN') {
                    ?>
                    <div class="form-group">
                        <label class="control-label"> Company</label>
                        <select name="company_code" id="company_code" class="form-control">
                            <option value="">Select</option>
                            <?php
                            foreach ($company->result() as $key => $value) {
                                echo "<option value='" . $value->ID . "'>" . $value->COMP_NAME . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                <?php } else { ?>
                    <input type="hidden" name="company_code" id="company_code" value="<?php echo $company_code ?>">
                <?php } ?>        
                <!--          </div>
                          <div class="col-md-1">-->
                <div class="form-group"> 
                    <button type="button" class="btn btn-green btn-block" onclick="disp_table()">search</button>
                    <!--</div>-->
                    <!--          </div>
                              <div class="col-md-1">-->
                    <!--<div class="form-group"> <br/>-->
                    <!--<button type="button" class="btn btn-green" onclick="printDiv('table', 'Income and Expenditure')">Print</button>-->
                </div>
                <!--      </div>
                        </div>-->
                <div>
                    <!-- end: DYNAMIC TABLE PANEL --> 
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: PAGE HEADER --> 

<script>

    jQuery(document).ready(function () {
        Main.init();
        FormElements.init();

    });



</script> 
<script>
    function disp_table()
    {
        lode_image_true();
        $.ajax({
            type: "POST",
            data: {
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
                comp_code: $("#company_code").val()
            },
            url: "<?php echo site_url('income_and_expenditure/calculation') ?>",
            success: function (data)
            {
                //alert('hello');
                $('#table').html(data);
                if ($("#form_excel_pdf").length == 0) {
                    var pdf = '<form action="<?php echo site_url('income_and_expenditure/calculation'); ?>" method="post" id="form_excel_pdf" name="form_excel_pdf" target="_blank">' +
                            '<input type="hidden" name="from_date" value="">' +
                            '<input type="hidden" name="to_date" value="">' +
                            '<input type="hidden" name="generate_pdf" value="generate_pdf">' +
                            '<button title="Export to pdf" class="btn_pdf_excel export_pdf" onclick="document.form_excel_pdf.generate_pdf.value=\'generate_pdf\';this.form.target=\'_blank\';this.form.submit();"><i class="clip-file-pdf"></i></button>' +
                            '<button class="btn_pdf_excel export_excel" title="export to excel" onclick="document.form_excel_pdf.generate_pdf.value=\'generate_excel\';this.form.target=\'\';this.form.submit();"><i class="clip-file-excel"></i></button>' +
                            '</form>';
                    $(".panel-heading .panel-tools").append(pdf);
                }
//                $("#output").append(pdf);
                $("input[name=from_date]").val($('#from_date').val());
                $("input[name=to_date]").val($('#to_date').val());
            }
        });

    }

</script> 
<script src="<?php echo base_url(); ?>assets/js/print.js"></script>