<div class="row" style="padding-top:20px;" >
    <div class="col-md-9">
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default" style="min-height:555px;">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Trial Balance
                <div class="panel-tools"></div>
                <!--<div class="panel-tools"><a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a></div>-->
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
                            <h1>Trial Balance <small></small></h1>
                        </div>
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="control-label"> From Date</label>
                    <span class="input-icon input-icon-right">
                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="date" id="date"/>
                        <i class="icon-calendar"></i> </span> 
                </div>
                <div class="form-group">
                    <label class="control-label"> To Date</label>
                    <span class="input-icon input-icon-right">
                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_to" name="txt_to"/>
                        <i class="icon-calendar"></i> </span> 
                </div>
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
                <div class="form-group"> <br/>
                    <button type="button" class="btn btn-green btn-block" onclick="disp_table()">search</button>
                    <!--<input type="button" name="btn_print" id="btn_print" value="PRINT" onclick="printDiv('table', 'Trial Balance')" class="btn btn-green"  >-->
                </div>
                <label for="form-field-mask-1"> Mail To </label>
                <div class="input-group">
                    <input autocomplete="off" type="text" class="form-control" placeholder="Search By name" name="txt_email" id="txt_email">
                    <span class="input-group-btn">
                        <button class="btn btn-green" type="button" onclick="sendmail()"> <i class="icon-search"></i> Go! </button>
                    </span> 
                </div>
                <!-- end: DYNAMIC TABLE PANEL --> 
            </div>
        </div>
    </div>
</div>
<!-- end: PAGE HEADER --> 

<form action="" method="post">
    <p>&nbsp;</p>
    <span class="input-icon input-icon-right">
        <i class="icon-calendar"></i> 
    </span>
</form>
<script src="<?php echo base_url(); ?>assets/js/print.js"></script>
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
                date: $('#date').val(),
                to_date: $('#txt_to').val(),
                comp_code: $("#company_code").val()
            },
            url: "<?php echo site_url('trialbalance/calculation') ?>",
            success: function (data)
            {
                $('#table').html(data);
                if ($("#form_excel_pdf").length == 0) {
                    var pdf = '<form action="<?php echo site_url('trialbalance/calculation'); ?>" method="post" id="form_excel_pdf" name="form_excel_pdf" target="_blank">' +
                            '<input type="hidden" name="date" value="">' +
                            '<input type="hidden" name="to_date" value="">' +
                            '<input type="hidden" name="comp_code" value="">' +
                            '<input type="hidden" name="generate_pdf" value="generate_pdf">' +
                            '<button title="Export to pdf" class="btn_pdf_excel export_pdf" onclick="document.form_excel_pdf.generate_pdf.value=\'generate_pdf\';this.form.target=\'_blank\';this.form.submit();"><i class="clip-file-pdf"></i></button>' +
                            '<button class="btn_pdf_excel export_excel" title="export to excel" onclick="document.form_excel_pdf.generate_pdf.value=\'generate_excel\';this.form.target=\'\';this.form.submit();"><i class="clip-file-excel"></i></button>' +
                            '</form>';
                    //                $("#table").append(pdf);
                    $(".panel-heading .panel-tools").append(pdf);
                }
                $("input[name=date]").val($('#date').val());
                $("input[name=to_date]").val($('#txt_to').val());
                $("input[name=comp_code]").val($("#company_code").val());
            }
        });

    }

</script>

<script>
    function sendmail()
    {
        //alert('hhhhh');
        $.ajax({
            type: "POST",
            data:
            {
                mail_data: $('#my_data').val(),
                to_mail: $('#txt_email').val(),
                mail_sub: $('#my_sub').val()
            },
            url: "<?php echo site_url('trialbalance/mail_trialbalance'); ?>",
            success: function (data)
            {
                //$('#table').html(data);
                alert('mail send');
            }
        }
        );
    }
</script>