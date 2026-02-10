<div class="row" style="padding-top:20px;" >
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default" style="min-height:555px;">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Recurring Invoice List
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> 
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> 
                    <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> 
<!--                    <form action="<?php // echo site_url('spare/mult_search');        ?>" method="post" id="form_excel_pdf" name="form_excel_pdf" target="_blank"> 
                        <input type="hidden" name="type" id="type" value="toner_rep">
                        <input type="hidden" name="ins_statu" id="ins_statu" value="">
                        <input type="hidden" name="fromdate" id="fromdate" value="">
                        <input type="hidden" name="todate" id="todate" value="">
                        <input type="hidden" name="call_statu" id="call_statu" value="">
                        <input type="hidden" name="generate_pdf" value="generate_pdf">
                        <button title="Export to pdf" class="btn_pdf_excel export_pdf" onclick="document.form_excel_pdf.generate_pdf.value = 'generate_pdf';this.form.target = '_blank';this.form.submit();"><i class="clip-file-pdf"></i></button>
                        <button class="btn_pdf_excel export_excel" title="export to excel" onclick="document.form_excel_pdf.generate_pdf.value = 'generate_excel';this.form.target = '';this.form.submit();"><i class="clip-file-excel"></i></button>
                    </form>-->
                </div>
            </div>

            <div class="panel-body" >
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"> Date</label>
                            <span class="input-icon input-icon-right">
                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_from" name="txt_from" value="">
                                <i class="icon-calendar"></i> 
                            </span> 
                        </div>
                    </div>
                    <!--                    <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label"> To date</label>
                                                <span class="input-icon input-icon-right">
                                                    <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_to" name="txt_to" value="">
                                                    <i class="icon-calendar"></i> 
                                                </span> 
                                            </div>
                                        </div>-->
                    <div class="col-md-2">
                        <div class="form-group"> <br>
                            <button type="button" class="btn btn-green btn-block" onclick="search_data()">search</button>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-scroll ps-container" >
                            <div id="output" class="">
                                <table class="table table-striped table-bordered table-hover table-full-width" style="margin-top: 10px;">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Customer</th>
                                            <th>Next Invoice Date</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sn_count = 1;
                                        foreach ($cond->result() as $key => $value) {
                                            ?>
                                            <tr>
                                                <td><?php echo $sn_count ?></td>
                                                <td><?php echo $value->ACC_NAME ?></td>
                                                <td>
                                                    <?php
                                                    $next_inv_date = $value->NEXT_INVOICE_DATE;
                                                    $next_inv_date = strtotime($next_inv_date);
                                                    echo $next_inv_date = date("d-m-Y", $next_inv_date);
                                                    ?>
                                                </td>
                                                <td><?php echo $value->INVOICE_RECURRING_COMMENT ?></td>
                                            </tr>
                                            <?php
                                            $sn_count++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end: DYNAMIC TABLE PANEL --> 
    </div>
</div>

<!-- end: PAGE HEADER --> 

<script>
    function search_data()
    {
        console.log($('#sort_by').val())
        $.ajax({
            type: "POST",
            data:
            {
                calc: $('#txt_from').val(),
                type: 'recurring'
//                todate: $('#txt_to').val(),
//                staff: $('#search_staff').val()
            },
            url: "<?php echo site_url('invoice/mult_search'); ?>",
            success: function (data)
            {
                $('#output').html(data);
//                $("#ins_statu").val($('#search_ins_status').val())
//                $("#call_statu").val($('#search_call_status').val())
//                $("#fromdate").val($('#txt_from').val())
//                $("#todate").val($('#txt_to').val())
//                $("#sort_by").val($('#order_by').val())
//                $("#per_page").val($('#search_status').val())
//                $("#cur_page").val($('#search_status').val())
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
