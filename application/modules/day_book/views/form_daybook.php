<div class="row" style="padding-top:20px;" >
    <div class="col-md-9"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default" style="min-height:555px;">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Day book
                <div class="panel-tools"></div>
<!--                <div class="panel-tools"><a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a><a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a></div>-->
            </div>
            <div id="output"> </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <!-- end: PAGE TITLE & BREADCRUMB -->
            <div class="panel-body">
<!--                <h2><i class="icon-edit-sign teal"></i>&nbsp Day book </h2>
                <hr />-->
                <div class="form-group">
                    <label class="control-label"> From Date</label>
                    <span class="input-icon input-icon-right">
                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_from" name="txt_from" value="<?php echo date('d-m-Y'); ?>"/>
                        <i class="icon-calendar"></i> </span> </div>
                <div class="form-group">
                    <label class="control-label"> To Date</label>
                    <span class="input-icon input-icon-right">
                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_to" name="txt_to" value="<?php echo date('d-m-Y'); ?>"/>
                        <i class="icon-calendar"></i>
                    </span>
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
                <input type="button" name="btn_show_day_book" id="btn_show_day_book"  onclick="show_day_book()" value="SHOW" class="btn btn-dark-beige btn-block" >
                <!--<input type="button" name="btn_print" id="btn_print" value="PRINT" onclick="printDiv('output', 'Day Book')" class="btn btn-dark-beige"  >-->
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/enquiry.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/print.js"></script>
<script>
    function show_day_book() {
        lode_image_true();
        $.ajax({
            type: "POST",
            data:
                    {
                        fromdate: $('#txt_from').val(),
                        todate: $('#txt_to').val(),
                        comp_code: $("#company_code").val()
                    },
            url: "<?php echo site_url('day_book/diff_date'); ?>",
            success: function (data)
            {
                $('#output').html(data);
                if ($("#form_excel_pdf").length == 0) {
                    var pdf = '<form action="<?php echo site_url('day_book/diff_date'); ?>" method="post" id="form_excel_pdf" name="form_excel_pdf" target="_blank">' +
                            '<input type="hidden" name="fromdate" value="">' +
                            '<input type="hidden" name="todate" value="">' +
                            '<input type="hidden" name="comp_code" value="">' +
                            '<input type="hidden" name="generate_pdf" value="generate_pdf">' +
                            '<button title="Export to pdf" class="btn_pdf_excel export_pdf" onclick="document.form_excel_pdf.generate_pdf.value=\'generate_pdf\';this.form.target=\'_blank\';this.form.submit();"><i class="clip-file-pdf"></i></button>' +
                            '<button class="btn_pdf_excel export_excel" title="export to excel" onclick="document.form_excel_pdf.generate_pdf.value=\'generate_excel\';this.form.target=\'\';this.form.submit();"><i class="clip-file-excel"></i></button>' +
                            '</form>';
                    //                $("#output").append(pdf);
                    $(".panel-heading .panel-tools").append(pdf);
                }
                $("input[name=fromdate]").val($('#txt_from').val());
                $("input[name=todate]").val($('#txt_to').val());
                $("input[name=comp_code]").val($("#company_code").val());
            }
        });
    }
</script> 
<script>
    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        UIModals.init();
        FormElements.init();
    });
</script> 
