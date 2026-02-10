<div class="row" style="padding-top:20px;" >
    <div class="col-md-12">
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default" style="min-height:555px;">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Income and Expenditure
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
                                    <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" name="date" id="date"/>
                                    <i class="icon-calendar"></i> </span> </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label"> To Date</label>
                                <span class="input-icon input-icon-right">
                                    <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_to" name="txt_to"/>
                                    <i class="icon-calendar"></i> </span> </div>
                        </div>     
                        <div class="col-md-4">
                            <div class="form-group"> <br/>
                                <button type="button" class="btn btn-green" onclick="disp_table()">search</button>
                                <input type="button" name="btn_print" id="btn_print" value="PRINT" onclick="printDiv('table')" class="btn btn-green"  >
                            </div>
                        </div>

                    </div>
                    <div>

                        <div id="table">
                        </div> 

                    </div>

                    <!-- end: DYNAMIC TABLE PANEL --> 
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: PAGE HEADER --> 




<form action="" method="post">
    <p>&nbsp;</p>
    <span class="input-icon input-icon-right">

        <i class="icon-calendar"></i> </span>


</form>

<script>

    jQuery(document).ready(function () {
        Main.init();
        FormElements.init();

    });



</script>
<script>
    function disp_table()
    {
        //alert('hai');
        $.ajax({
            type: "POST",
            data: {date: $('#date').val(), to_date: $('#txt_to').val()},
            url: "<?php echo site_url('income_expenditure/calculation') ?>",
            success: function (data)
            {
                //alert('hello');
                $('#table').html(data);
            }
        });

    }

</script>
<script>
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
                "<html><head><title></title></head><body>" +
                divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;


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