<div class="row" style="padding-top:20px;">
    <div class="col-md-12">
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Payment Report
                <div class="panel-tools">
                    <form action="<?php echo site_url('invoice/get_payment_report_list'); ?>" method="post" id="form_excel_pdf" name="form_excel_pdf" target="_blank">
                        <input type="hidden" name="frm" id="frm" value="">
                        <input type="hidden" name="to" id="to" value="">
                        <input type="hidden" name="key_words" id="key_words" value="">
                        <input type="hidden" name="invoice_type" id="invoice_type" value="">
                        <input type="hidden" name="per_page" id="per_page" value="10">
                        <input type="hidden" name="cur_page" id="cur_page" value="1">
                        <input type="hidden" name="generate_pdf" value="generate_pdf">
                        <button title="Export to pdf" class="btn_pdf_excel export_pdf" onclick="document.form_excel_pdf.generate_pdf.value='generate_pdf';this.form.target='_blank';this.form.submit();"><i class="clip-file-pdf"></i></button>
                        <button class="btn_pdf_excel export_excel" title="export to excel" onclick="document.form_excel_pdf.generate_pdf.value='generate_excel';this.form.target='';this.form.submit();"><i class="clip-file-excel"></i></button>
                    </form>
                </div>
            </div>

            <!-- end: PAGE TITLE & BREADCRUMB -->
            <div class="col-md-12">
                <h1>Payment Report<small></small></h1>
                <hr />
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> From Date</label>
                            <span class="input-icon input-icon-right">
                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_from" name="txt_from" />
                                <i class="icon-calendar"></i> </span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> To Date</label>
                            <span class="input-icon input-icon-right">
                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_to" name="txt_to" />
                                <i class="icon-calendar"></i> </span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Invoice Type<span class="symbol required"> </span></label>
                            <select class="form-control" id="sel_invoice_type" name="sel_invoice_type">
                                <option value="">Select</option>
                                <option value="with_tax">With Tax</option>
                                <option value="without_tax">Without Tax</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="form-field-mask-1"> Key Words </label>
                        <div class="input-group">
                            <input autocomplete="off" type="text" class="form-control" placeholder="Search By name" name="txt_key_words" id="txt_key_words">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" onclick="search_data()"> <i class="icon-search"></i> Go! </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div id="output">

                </div>
            </div>
        </div>

        <!-- end: DYNAMIC TABLE PANEL -->
    </div>
</div>

<!-- end: PAGE HEADER -->
<script>
    function search_data() {
        $.ajax({
            type: "POST",
            data: {
                frm: $('#txt_from').val(),
                to: $('#txt_to').val(),
                key_words: $('#txt_key_words').val(),
                invoice_type: $('#sel_invoice_type').val(),
            },
            url: "<?php echo site_url('invoice/get_payment_report_list'); ?>",
            success: function(data) {
                $('#output').html(data);
                $("#frm").val($('#txt_from').val());
                $("#to").val($('#txt_to').val());
                $("#key_words").val($('#txt_key_words').val());
                $("#invoice_type").val($('#sel_invoice_type').val());
            }
        });
    }
</script>
<script>
    jQuery(document).ready(function() {
        Main.init();
        FormElements.init();

    });
</script>