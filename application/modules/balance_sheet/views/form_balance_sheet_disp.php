<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>trial balance</title>
    </head>

    <body>
        <div class="row" style="padding-top:20px;" >
            <div class="col-md-12">
                <!-- start: DYNAMIC TABLE PANEL -->
                <div class="panel panel-default" style="min-height:555px;">
                    <div class="panel-heading"> <i class="icon-external-link-sign"></i> Balance Sheet
                        <div class="panel-tools"></div>
                        <!--<div class="panel-tools"><a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a></div>-->
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"> Select Date</label>
                                        <span class="input-icon input-icon-right">
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="date" id="date"  />
                                            <i class="icon-calendar"></i> </span> 
                                    </div>
                                </div>
                                <?php
                                    $sess_array = $this->session->userdata('logged_in');
                                    $user_type = $sess_array['user_type'];
                                    $company_code = $sess_array['comp_code'];
                                    if ($user_type == 'ADMIN') {
                                        ?>
                                        <div class="col-md-3">
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
                                        </div>
                                    <?php } else { ?>
                                        <input type="hidden" name="company_code" id="company_code" value="<?php echo $company_code ?>">
                                    <?php } ?>
                                    <div class="col-md-3">
                                        <div class="form-group"> <br/>
                                            <input type="button" value="Get Balance Sheet" onclick="disp_table()" class="btn btn-green btn-block"/>
                                            <!--<input type="button" name="btn_print" id="btn_print" value="PRINT" onclick="printDiv('table', 'Trial Balance')" class="btn btn-green"  >-->
                                        </div>
                                    </div>
                            </div>

                        </form>
                        <div id="table"></div>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormElements.init();

    });



</script>
<script>
    function disp_table()
    {
        $.ajax({
            type: "POST",
            data: {
                date: $('#date').val(),
                comp_code: $("#company_code").val()
            },
            url: "<?php echo site_url('balance_sheet/calculation') ?>",
            success: function (data)
            {
                $('#table').html(data);
            }
        });

    }

</script>
