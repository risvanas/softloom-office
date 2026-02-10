<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/invoice/css/style.css' />
<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>invoice/css/print.css' media="print" />

<div class="row" style="padding-top:20px;">
    <div class="col-sm-12"> 
        <!-- start: INLINE TABS PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="icon-reorder"></i> Dashboard
                <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> 
                    <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
            </div>
            <form  role="form" id="form" method="post" action="<?php echo site_url('invoice/invoice_update'); ?>" onsubmit="ins_data();">
                <div class="panel-body">
                    <h2><i class="icon-group teal"></i> Invoice</h2>
                    <div><hr /></div>
                    <?php
                    foreach ($vno->result() as $row) {
                        $invoice_id = $row->INVOICE_ID;
                        $cust_id = $row->CUSTOMER_ID;
                        $query = $this->db->query("SELECT * FROM tbl_account WHERE ACC_MODE='CUSTOMER' AND DEL_FLAG='1' AND ACC_ID='$cust_id'");
                        $res = $query->row_array();
                        $customer_name = $res['ACC_NAME'];
                        $total_price = $row->TOTAL_PRICE;
                        $paid_price = $row->PAID_PRICE;
                        $due_amt = $total_price - $paid_price;
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="hidden" name="hdd_invo_id" id="hdd_invo_id" Class="form-control" value="<?php echo $invoice_id; ?>"/>
                                            <label class="control-label"> Book Number </label>
                                            <div class="input-group">
                                                <input autocomplete="off" type="text" name="txt_buk_num" id="txt_buk_num" Class="form-control" value="<?php echo $row->BOOK_NUMBER; ?>" readonly="readonly"/>
                                                <input type="hidden" name="hdd_buk_num" id="hdd_buk_num" Class="form-control" value="<?php echo $row->BOOK_NUMBER; ?>">
                                                <input type="hidden" name="temp_voc_num" id="temp_voc_num" Class="form-control"/>
                                                <span class="input-group-btn"> <a data-toggle="modal" class="demo btn btn-dark-beige" > GO </a> </span></div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label"> Invoice Date <span class="symbol required"> </span> </label>
                                            <span class="input-icon input-icon-right">
                                                <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_invoice_date" name="txt_invoice_date" value="<?php
                                                $invoice_date = $row->INVOICE_DATE;
                                                $invoice_date = strtotime($invoice_date);
                                                echo $invoice_date = date("d-m-Y", $invoice_date);
                                                ?>" readonly/>
                                                <i class="icon-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" id="h1">
                                            <label class="control-label">Customer Name <span class="symbol required"> </span> </label>
                                            <select class="form-control" id="txt_cust_name" name="txt_cust_name" onchange="load_customer_name()" readonly>
                                                <option value="">Select</option>
                                                <?php foreach ($cust->result() as $cst) { ?>
                                                    <option value="<?php echo $cst->ACC_ID ?>"<?php if ($cst->ACC_ID == $cust_id) echo "selected"; ?> ><?php echo $cst->ACC_NAME ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Description <span class="symbol required"> </span></label>
                                            <textarea class="form-control" name="txt_des" readonly><?php echo $row->DESCRIPTION; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="out_put">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="page-wrap">
                                    <table id="items" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Description</th>
                                                <th>Unit Cost</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>

                                        <?php
                                        $details = $this->db->query("SELECT * FROM tbl_invoicedetails WHERE INVOICE_ID='$invoice_id' AND DEL_FLAG='1'");
                                        foreach ($details->result() as $items) {

                                            $unit_cost = $items->UNIT_COST;
                                            $quantity = $items->QUANTITY;
                                            $price = $unit_cost * $quantity;
                                            ?>
                                            <tr class="item-row">
                                                <td class="item-name"><div class="delete-wpr"><textarea id="item[]" name="item[]" readonly><?php echo $items->ITEM; ?></textarea></div></td>
                                                <td class="description"><textarea name="description[]" readonly><?php echo $items->DESCRIPTION; ?></textarea></td>
                                                <td><textarea class="cost" name="cost[]" readonly><?php echo $items->UNIT_COST; ?></textarea></td>
                                                <td><textarea class="qty" name="qty[]" readonly><?php echo $items->QUANTITY; ?></textarea></td>
                                                <td><textarea class="price" name="price" readonly><?php echo $price; ?></textarea></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="2" class="blank"></td>
                                            <td colspan="2" class="total-line">Subtotal</td>
                                            <td class="total-value"><textarea id="subtotal" name="subtotal" readonly><?php echo $row->TOTAL_PRICE; ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="blank"></td>
                                            <td colspan="2" class="total-line">Total</td>
                                            <td class="total-value"><textarea id="total" name="total" readonly><?php echo $row->TOTAL_PRICE; ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="blank"></td>
                                            <td colspan="2" class="total-line">Amount Paid</td>
                                            <td class="total-value"><textarea id="paid" name="paid" readonly="readonly"><?php echo $row->PAID_PRICE; ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="blank"></td>
                                            <td colspan="2" class="total-line balance">Balance Due</td>
                                            <td class="total-value balance"><div class="due"><?php echo $due_amt; ?></div></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div> <span class="symbol required"></span> Required Fields
                                <hr />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 pull-right">
                            <a href="<?php echo site_url('invoice/invoice_list'); ?>" target="_blank"><button class="btn btn-dark-beige btn-block" type="button" id="sub_reg" name="sub_reg">Edit &nbsp;<i class="icon-circle-arrow-right"></i> </button></a>
                        </div>
                        <div> </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- end: INLINE TABS PANEL --> 
    </div>
</div>
<div id="output1"> </div>
<script>
<?php if ($msg != "") { ?>

        function ins_data()
        {
            document.getElementById('sub_reg').disabled = false;
        }


<?php } ?>
</script>

<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/form-validation/form_invoice.js"></script> 
<script>

    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        UIModals.init();
        FormElements.init();

    });
</script>

<script language="javascript" type="text/javascript">
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

    document.getElementById("bttdelete").style.display = "none";
    document.getElementById("voc_num").style.display = "none";
    function addaccount(acc_code, acc_name, acc_id)
    {
        var tbl = document.getElementById("tblstr");

        //alert(batch_id="##"+course_name)
        var Numx = document.getElementById('Num').value;
        appendRow();
        //alert("d"+Numx);
        Numx = (Number(Numx) + 1);
        document.getElementById("Num").value = Numx;
        document.getElementById("item" + Numx).value = acc_code;
        document.getElementById("description" + Numx).value = acc_name;
        document.getElementById("account_id" + Numx).value = acc_id;
        hiddenFunction();
    }

    function hiddenFunction()
    {
        var count = document.getElementById("Num").value;
        if (Number(count) <= 2)
        {
            document.getElementById('table_batch').style.display = 'none';
        } else
        {
            document.getElementById('table_batch').style.display = 'block';
        }

    }

    $(window).load(function ()
    {
        hiddenFunction();

    });

    function loadData()
    {
        //alert("hai");
        $.ajax({
            type: "POST",
            data: {name: $('#con').val()},
            url: "<?php echo site_url('invoice/account_list'); ?>",
            success: function (data)
            {
                $('#output').html(data);
            }
        });
    }

    function displaydata()
    {
//        alert("hai");
        $.ajax({
            type: "POST",
            data: {voc_no: $('#txt_buk_num').val()},
            url: "<?php echo site_url('invoice/invoice_details'); ?>",
            success: function (data)
            {
                $('#output1').html(data);
            }
        });

    }

    function load_customer_name()
    {

        $.ajax({
            type: "POST",
            data: {cust_id: $('#txt_cust_name').val()},
            url: "<?php echo site_url('invoice/customer_details'); ?>",
            success: function (data)
            {
                $('#out_put').html(data);
            }
        });

    }
    load_customer_name();

    function ins_data()
    {
        document.getElementById('sub_reg').disabled = true;
    }

</script>