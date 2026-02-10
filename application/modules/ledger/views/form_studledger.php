<div class="row" style="padding-top:20px;" >
    <div class="col-md-9">
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default" style="min-height:555px;">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Ledger
                <div class="panel-tools"></div>
                <!--<div class="panel-tools"><a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a></div>-->
            </div>

            <!-- end: PAGE TITLE & BREADCRUMB -->

            <div class="panel-body">
                <div id="output"> </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
<!--                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h1>Ledger <small></small></h1>
                        </div>
                    </div>
                </div>-->

                <div class="form-group">
                    <label class="control-label"> From Date</label>
                    <span class="input-icon input-icon-right">
                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_from" name="txt_from"/>
                        <i class="icon-calendar"></i> </span> </div>
                <div class="form-group">
                    <label class="control-label"> To Date</label>
                    <span class="input-icon input-icon-right">
                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_to" name="txt_to"/>
                        <i class="icon-calendar"></i> </span> </div>
                <div class="form-group">
                    <label class="control-label"> Status </label>
                    <select class="form-control"  id="txt_status" name="txt_status" onchange="status_data()">
                        <option value="">All</option>
                        <option value="ACTIVE">Active</option>
                        <option value="INACTIVE">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"> Account </label>
                    <select class="form-control"  id="txt_account" name="txt_account">
                        <option value="">Select</option>
                        <?php
                        foreach ($cond->result() as $res) {
                            ?>
                            <option value="<?php echo $res->ACC_ID; ?>"><?php echo $res->ACC_NAME; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div id="stoutpt">
                    <div class="form-group" id="h1">
                        <label class="control-label"> Sub Account</label>
                        <select class="form-control" name="txt_sub_account" id="txt_sub_account">
                            <option value="">Select</option>
                            <?php
                            foreach ($sub_acc->result() as $res) {
                                ?>
                                <option value="<?php echo $res->ACC_ID; ?>"><?php echo $res->ACC_NAME; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
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
                    <button type="button" class="btn btn-green btn-block" onclick="hiddenFunction()">search</button>
<!--                    <form action="<?php echo site_url('ledger/search_details'); ?>" method="post">
                        <input type="hidden" name="fromdate" value="">
                        <input type="hidden" name="todate" value="">
                        <input type="hidden" name="acc" value="">
                        <input type="hidden" name="subacc" value="">
                        <input type="hidden" name="generate_pdf" value="generate_pdf">
                        <input type="submit" class="btn btn-green" value="PDF">
                    </form>-->
                </div>
            </div>
        </div>
        <div>
        </div>
        <!-- end: DYNAMIC TABLE PANEL --> 
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/print.js"></script>
<!-- end: PAGE HEADER --> 
<script>

    function load_sub_account() {
        $.ajax({
            type: "POST",
            data: {accid: $('#txt_account').val()},
            url: "<?php echo site_url('ledger/sub_accounts'); ?>",
            success: function (data)
            {
                $('#h1').html(data);
            }
        });
    }

    function hiddenFunction() {
        lode_image_true();
        $.ajax({
            type: "POST",
            data:
            {
                fromdate: $('#txt_from').val(),
                todate: $('#txt_to').val(),
                acc: $('#txt_account').val(),
                subacc: $('#txt_sub_account').val(),
                comp_code: $("#company_code").val()
            },
            url: "<?php echo site_url('ledger/search_details'); ?>",
            success: function (data)
            {
                $('#output').html(data);
                if ($("#form_excel_pdf").length == 0) {
                    var pdf = '<form action="<?php echo site_url('ledger/search_details'); ?>" method="post" id="form_excel_pdf" name="form_excel_pdf" target="_blank">' +
                            '<input type="hidden" name="fromdate" value="">' +
                            '<input type="hidden" name="todate" value="">' +
                            '<input type="hidden" name="acc" value="">' +
                            '<input type="hidden" name="subacc" value="">' +
                            '<input type="hidden" name="comp_code" value="">' +
                            '<input type="hidden" name="generate_pdf" value="generate_pdf">' +
                            '<button title="Export to pdf" class="btn_pdf_excel export_pdf" onclick="document.form_excel_pdf.generate_pdf.value=\'generate_pdf\';this.form.target=\'_blank\';this.form.submit();"><i class="clip-file-pdf"></i></button>' +
                            '<button class="btn_pdf_excel export_excel" title="export to excel" onclick="document.form_excel_pdf.generate_pdf.value=\'generate_excel\';this.form.target=\'\';this.form.submit();"><i class="clip-file-excel"></i></button>' +
                            '</form>';
                    $(".panel-heading .panel-tools").append(pdf);
                }
//                $("#output").append(pdf);
                $("input[name=fromdate]").val($('#txt_from').val());
                $("input[name=todate]").val($('#txt_to').val());
                $("input[name=acc]").val($('#txt_account').val());
                $("input[name=subacc]").val($('#txt_sub_account').val());
                $("input[name=comp_code]").val($("#company_code").val());
            }
        });
    }

</script> 
<script>
    function status_data()
    {
        //alert('hai');
        $.ajax({
            type: "POST",
            data:
                    {
                        status: $('#txt_status').val()
                    },
            url: "<?php echo site_url('ledger/search_status'); ?>",
            success: function (data)
            {
                $('#stoutpt').html(data);
            }
        });
    }

</script>
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormElements.init();
    });
</script> 
