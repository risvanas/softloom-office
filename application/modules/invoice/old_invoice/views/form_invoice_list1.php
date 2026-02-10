<div class="row" style="padding-top:20px;" >
    <div class="col-md-12"> 
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-external-link-sign"></i> Invoice List
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
            </div>

            <!-- end: PAGE TITLE & BREADCRUMB -->
            <div class="col-md-12">
                <h1>Invoice List<small></small></h1>
                <hr />
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Select Date</label>
                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-range" name="txt_calc" id="txt_calc" onblur="search_data()" onchange="search_data()" onkeyup="search_data()">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Choose Date </label>
                            <select class="form-control"  id="search_date" name="search_date" >
                                <option value="DUE_DATE" selected="selected">Due Date</option>
                                <option value="REG_DATE">Reg Date</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <label for="form-field-mask-1"> Key Words </label>
                        <div class="input-group">
                            <input autocomplete="off" type="text" class="form-control" placeholder="Search By name" name="txt_key_words" id="txt_key_words" onkeyup="search_data()">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" onclick="search_data()"> <i class="icon-search"></i> Go! </button>
                            </span> </div>
                    </div>         
                </div>
            </div>
            <div class="panel-body" >
                <div id="output">
                    <table class="table table-striped table-bordered table-hover table-full-width" >
                        <thead>
                            <tr>
                                <th> No</th>
                                <th> Customer Name </th>
                                <th>Book Number</th>
                                <th> Invoice Date </th>
                                <th> Total Price </th>

                                <th  style="width:110px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sn_count = 1;

                            foreach ($list->result() as $row) {
                                $cust_id = $row->CUSTOMER_ID;
                                $query = $this->db->query("SELECT ACC_NAME FROM tbl_account WHERE ACC_MODE='CUSTOMER' AND DEL_FLAG='1' AND ACC_ID='$cust_id'");
                                $res = $query->row_array();
                                $customer_name = $res['ACC_NAME'];
                                ?>
                                <tr>
                                    <td><?php echo $sn_count; ?></td>
                                    <td><?php echo $customer_name; ?></td>
                                    <td><?php echo $row->BOOK_NUMBER; ?></td>
                                    <td><?php echo $row->TOTAL_PRICE; ?></td>
                                    <td><?php
                                        $invoice_date = $row->INVOICE_DATE;
                                        $invoice_date = strtotime($invoice_date);
                                        echo $invoice_date = date("d-m-Y", $invoice_date);
                                        ?></td>




                                    <td class=""><div class="btn-group">
                                            <button type="button" class="btn btn-green" style="font-size: 12px !important; padding: 3px 7px;" onclick=""> <i class="icon-wrench"></i> Setting </button>
                                            <button  onclick=""  data-toggle="dropdown" class="btn btn-green dropdown-toggle" style="font-size: 12px !important; padding: 3px 7px;"> <span class="caret"></span> </button >
                                            <ul class="dropdown-menu" role="menu">

                                                <li> <a href="<?php echo site_url('invoice/print_invoice'); ?>/<?php echo $row->BOOK_NUMBER; ?> "> <i class="icon-pencil"></i> Print </a> </li>

                                            </ul>
                                        </div></td>
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

        <!-- end: DYNAMIC TABLE PANEL --> 
    </div>
</div>

<!-- end: PAGE HEADER --> 
<script>
    function search_data()
    {
        $.ajax({
            type: "POST",
            data:
                    {
                        calc: $('#txt_calc').val(),
                        dat: $('#search_date').val(),
                        key_words: $('#txt_key_words').val(),
                        course: $('#txt_search_course').val(),
                        stat: $('#search_status').val()

                    },
            url: "<?php echo site_url('student/mult_search'); ?>",
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
        FormElements.init();

    });

</script> 
