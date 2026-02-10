<div class="row" style="padding-top:20px;" >
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default" style="min-height:555px;">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Day book
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> 
                    <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
            </div>
            <!-- end: PAGE TITLE & BREADCRUMB -->
            <div class="panel-body">
                <h2><i class="icon-edit-sign teal"></i>&nbsp Day book </h2>
                <hr />
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> From Date</label>
                            <span class="input-icon input-icon-right">
                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_from" name="txt_from" value="<?php echo date('d-m-Y'); ?>"/>
                                <i class="icon-calendar"></i> </span> </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> To Date</label>
                            <span class="input-icon input-icon-right">
                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_to" name="txt_to" value="<?php echo date('d-m-Y'); ?>"/>
                                <i class="icon-calendar"></i> </span> </div>
                    </div>
                    <div class="col-sm-4" style="padding-top: 20px;">
                        <input type="button" name="btn_show_day_book" id="btn_show_day_book"  onclick="show_day_book()" value="SHOW" class="btn btn-dark-beige" >
                        <input type="button" name="btn_print" id="btn_print" value="PRINT" onclick="printDiv('output', 'Day Book')" class="btn btn-dark-beige"  >
                    </div>
                </div>
            </div>
            <div id="output"> </div>

        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/enquiry.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/print.js"></script>
<script>
                            function show_day_book()
                            {
                                lode_image_true();
                                $.ajax({
                                    type: "POST",
                                    data:
                                            {
                                                fromdate: $('#txt_from').val(),
                                                todate: $('#txt_to').val()

                                            },
                                    url: "<?php echo site_url('day_book/diff_date'); ?>",
                                    success: function (data)
                                    {
                                        $('#output').html(data);
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
