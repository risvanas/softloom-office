<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Invoice </title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/semantic.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>" media="all" />
    </head>
    <body>
        <?php
        foreach ($vno->result() as $row) {
            $invoice_id = $row->INVOICE_ID;
            $cust_id = $row->CUSTOMER_ID;
            $query = $this->db->query("SELECT * FROM tbl_account WHERE ACC_MODE='CUSTOMER' AND DEL_FLAG='1' AND ACC_ID='$cust_id'");
            $res = $query->row_array();
            $customer_name = $res['ACC_NAME'];
            $address_one = $res['ADDRESS_ONE'];
            $address_two = $res['ADDRESS_TWO'];
            $phone = $res['PHONE'];
            $acc_email = $res['ACC_EMAIL'];

            $total_price = $row->TOTAL_PRICE;
            $paid_price = $row->PAID_PRICE;
            $due_amt = $total_price - $paid_price;
            ?>
            <!-- <div class="ui button aligned center teal" id="create_pdf" >Download</div> -->
            <!--<label id="create_pdf" style="position:absolute;  bottom: 98%;right: -20%;">Download</label>-->
            <img src="<?php echo base_url('assets/css/downloadarrow.jpg'); ?>" id="create_pdf" style="position:absolute;  bottom: 96%;right: -20%;width:70px;height:40px;"  > 
            <form  action="<?php echo site_url('invoice/print_invoice'); ?>/<?php echo $encrypted_data;?> " method="post" id="form_excel_pdf" name="form_excel_pdf" target="_blank">
                <input type="hidden" name="generate_pdf" value="generate_pdf">
                <button title="Export to pdf" class="btn_pdf_excel export_pdf" style="display: none;"><i class="clip-file-pdf"></i></button>
            </form>
            <img src="<?php echo base_url('assets/css/print_icon1.gif'); ?>" id="print" style="position:absolute;  bottom: 96%;right: -30%;width:70px;height:40px;" onclick="printDiv('myform')" >	
            <br/><br/>

            <form class="ui form" id="myform">
                <header class="clearfix">
                    <div id="logo">
                        <img src="<?php echo base_url('assets/images/logo1.png'); ?>">
                    </div>
                    <div id="company">

                        <h2 class="name">Softloom It Solutions</h2>
                        <div>1st Floor, H.A Tower,</div>
                        <div>Providence Road, Kochi-682018,</div>
                        <div>Ernakulam, Kerala, India</div>
                        <div>+91 484 239 6771, +91808 932 1695, +91 889 115 0704</div>
                        <div><a href="mailto:company@example.com">info@softloom.com</a></div>
                    </div>
                    </div>
                </header>
                <main>
                    <div id="details" class="clearfix">
                        <div id="client">
                            <div class="to">INVOICE TO:</div>
                            <h2 class="name"><?php echo $customer_name; ?></h2>
                            <div class="address"><?php echo $address_one; ?></div>
                            <div class="address"><?php echo $address_two; ?></div>
                            <div class="address">Mobile: <?php echo $phone; ?></div>
                            <div class="email">Email: <?php echo $acc_email; ?></div>
                        </div>
                        <div id="invoice">
                            <h1>INVOICE <?php echo $book_num = $row->BOOK_NUMBER; ?></h1>
                            <div class="date">Date of Invoice: <?php
        $invoice_date = $row->INVOICE_DATE;
        $invoice_date = strtotime($invoice_date);
        echo $invoice_date = date("F d,Y", $invoice_date);
            ?></div>
                            <div class="date">Amount Due: <?php echo $due_amt; ?></div>
                        </div>
                    </div>
                    <div id="mynewdiv" style="min-height:620px";>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th class="no">#</th>
                                    <th class="desc">DESCRIPTION</th>
                                    <th class="unit">UNIT PRICE</th>
                                    <th class="qty">QUANTITY</th>
                                    <th class="total">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                $sub_total = 0;
                                $details = $this->db->query("SELECT * FROM tbl_invoicedetails WHERE INVOICE_ID='$invoice_id' AND DEL_FLAG='1'");
                                foreach ($details->result() as $items) {

                                    $unit_cost = $items->UNIT_COST;
                                    $quantity = $items->QUANTITY;
                                    $price = $unit_cost * $quantity;
                                    ?>
                                    <tr>
                                        <td class="no">0<?php echo $count; ?></td>
                                        <td class="desc"><h3><?php echo $items->ITEM; ?></h3><?php echo $items->DESCRIPTION; ?></td>
                                        <td class="unit"><?php echo $items->UNIT_COST; ?></td>
                                        <td class="qty"><?php echo $items->QUANTITY; ?></td>
                                        <td class="total"><?php echo $unit_total = $price; ?></td>
                                    </tr>
                                    <?php
                                    $sub_total += $unit_total;
                                    $count++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">SUBTOTAL</td>
                                    <td><?php echo $sub_total; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">AMOUNT PAID</td>
                                    <td><?php echo $paid_price; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">BALANCE DUE</td>
                                    <td><?php echo $due_amt; ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php
                }
                ?>



                <div id="notices">
                    <div>NOTICE:</div>
                    <div class="notice"><b>Bank Details </b><br/>
                        Softloom IT Solutions, Federal Bank
                        , Ernakulam / North branch
                        ,

                        A/C no: 10040200041162,<br/>
                        IFS Code: FDRL0001004
                    </div>
                </div>
            </main>


        </form>

        <!-- scripts -->
        <script src="<?php echo base_url('assets/css/jquery.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/css/html2canvas.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/css/jspdf.min.js'); ?>"></script>
        <script>
            (function () {
                var
                        form = $('.form'),
                        cache_width = form.width(),
                        a4 = [595.28, 841.89];  // for a4 size paper width and height

                $('#create_pdf').on('click', function () {
                    //$('body').scrollTop(0);
//                    createPDF();
                    $("#form_excel_pdf").submit();
                });

//create pdf
                function createPDF() {
                    getCanvas().then(function (canvas) {
                        var
                                img = canvas.toDataURL("image/png"),
                                doc = new jsPDF({
                                    unit: 'px',
                                    format: 'a4'
                                });
                        doc.addImage(img, 'JPEG', 20, 20);
                        doc.save('<?php echo "invoice" . $book_num; ?>.pdf');
                        form.width(cache_width);
                    });
                }

// create canvas object
                function getCanvas() {
                    form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');
                    return html2canvas(form, {
                        imageTimeout: 2000,
                        removeContainer: true
                    });
                }

            }());
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

    </body>
</html>