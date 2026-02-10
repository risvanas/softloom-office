<div class="row" style="padding-top:20px;" >
    <div class="col-md-12">
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Staff Ledger
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
            </div>

            <!-- end: PAGE TITLE & BREADCRUMB -->

            <div class="col-md-12">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h2><small>Staff Ledger</small></h2>
                        </div>
                    </div>
                    <form  id="form" method="post" action="#">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label"> From Date</label>
                                    <span class="input-icon input-icon-right">
                                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_from" name="txt_from"/>
                                        <i class="icon-calendar"></i> </span> </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label"> To Date</label>
                                    <span class="input-icon input-icon-right">
                                        <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_to" name="txt_to"/>
                                        <i class="icon-calendar"></i> </span> </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label"> Account </label>
                                    <select class="form-control"  id="txt_account" name="txt_account" onchange="load_sub_account()">
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
                            </div>


                            <div class="col-md-2">
                                <div class="form-group"> <br/>
                                    <button type="button" class="btn btn-green" onclick="hiddenFunction()">search</button>
                                </div>
                            </div>
                        </div>
                        <div>

                            <div class="panel-body" >
                                <div id="output">


                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- end: DYNAMIC TABLE PANEL --> 
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/validation_ledger.js"></script> 
<!-- end: PAGE HEADER --> 
<script>


                                        function hiddenFunction()
                                        {
                                            //alert('hi');
                                            $.ajax({
                                                type: "POST",
                                                data:
                                                        {
                                                            fromdate: $('#txt_from').val(),
                                                            todate: $('#txt_to').val(),
                                                            acc: $('#txt_account').val(),

                                                        },
                                                url: "<?php echo site_url('staff_ledger/search_details'); ?>",
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
        FormElements.init();

    });

</script>