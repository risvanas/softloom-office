<div class="row" style="padding-top:20px;" >
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default" style="min-height:555px;">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>Income and Expenditure
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
            </div>

            <!-- end: PAGE TITLE & BREADCRUMB -->

            <div class="col-md-12">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h1>Income and Expenditure <small></small></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label"> From Date</label>
                                <span class="input-icon input-icon-right">
                                    <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="from_date" id=			"from_date"   />
                                    <i class="icon-calendar"></i> </span> </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label"> To Date</label>
                                <span class="input-icon input-icon-right">
                                    <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="to_date" name="to_date"/>
                                    <i class="icon-calendar"></i> </span> </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group"> <br/>
                                <button type="button" class="btn btn-green" onclick="disp_table()">search</button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div id="table"> </div>

                        <!-- end: DYNAMIC TABLE PANEL --> 
                    </div>
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
        $.ajax({
            type: "POST",
            data: {from_date: $('#from_date').val(), to_date: $('#to_date').val()},
            url: "<?php echo site_url('income_and_expenditure/calculation') ?>",
            success: function (data)
            {
                $('#table').html(data);
            }
        });

    }

</script> 
