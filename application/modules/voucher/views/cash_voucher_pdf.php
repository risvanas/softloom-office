<html>
    <head>
        <title>Cash Voucher</title>
        <style>
            body{
                font-size: 12px;
            }
            @page {
                margin: 160px 50px 150px 80px;
            }
            #header {
                position: fixed;
                left: 0px;
                top: -160px;
                right: 0px; 
                height: 40px; 
                text-align: center;
            }
            #footer {
                position: fixed; 
                left: 0px;
                bottom: -150px;
                right: 0px;
                height: 150px;
            }
            .clear_fix {
                padding-bottom: 5px;
            }
            #footer table.footer_clr td{
                height: 30px;
                width: 10%;
            }
            .clearfix table{
                margin-bottom: 30px !important;
            }
            h2.name {
                font-size: 13px; 
                /*                font-weight: normal;*/
                margin: 0;
                text-transform: uppercase;
            }
            table.table{
                width: 100%;
                border-collapse: collapse;
            }
            .page{
                text-align: right;
                padding-bottom: 10px;
            }
            .address{
                width: auto;
            }
            #footer .page:after {
                content: counter(page);
            }
            #content table{
                /*border-collapse: collapse;*/
                line-height: 1.5;
            }
            #content table tr th,#content table tr td{
                /*border: 1px solid #ddd;*/
                padding: 10px;
                vertical-align: top;
            }
            hr {
                border: 0px;
                border-top: 1px solid #ccc;
            }
            #content h1 {
                margin-bottom: 20px;
                text-align: center;
                margin-top: 10px;

            }
        </style>
    </head>
    <body>
        <?php
        $str = array();
        $hundred = null;
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        ?>
        <div id="header">
            <table class="table">
                <tr>
                    <?php $company_details = $company->row(); 
                    $type = pathinfo(base_url() . $company_details->LOGO, PATHINFO_EXTENSION);
                    $data = file_get_contents(base_url() . $company_details->LOGO);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    ?>
                    <td class="bottom"><img id='logo_image' src='<?php echo $base64 ?>' alt='<?php echo $company_details->COMP_NAME ?>'></td>
                    <td class="address">
                        <p>
                        <h2 class="name" style="padding-top: 25px;"><?php echo $company_details->COMP_NAME ?></h2>
                        <?php
                        echo "<p style='margin: 0;'>" . $company_details->ADDRESS1 . ",<br>" .
                        $company_details->ADDRESS2 . ",<br>" .
                        $company_details->ADDRESS3 . "-" . $company_details->PIN_CODE . ", " . $company_details->STATE . "<br>" .
                        $company_details->PHONE_NO . ", " . $company_details->MOBILE_NO1 . "<br>" .
                        $company_details->EMAIL . ", " . $company_details->EMAIL1 . "</p>";
                        echo ($company_details->GSTNO) ? "<p style='margin: 0;'>GSTIN: " . $company_details->GSTNO . "</p>" : "";
                        ?>
                        </p>
                    </td>
                </tr>
            </table>
            <hr>
        </div>
        <div id="footer">
            <table style="">
                <tr>
                    <td style="padding: 0px 20px">
                        <div id="notices">
                            <div>Company's PAN &nbsp;:&nbsp; <b>ADFFS7647K</b></div>
                            <div style="padding-top: 10px">Declaration</div>
                            <div class="notice">We declare that  this voucher shows the actual price of the goods described and that all particulars are true and correct.</div>
                        </div>
                    </td>
                    <td style="padding: 0px 20px">
                        <div id="notices">
                            <div class="notice"><b>Bank Details </b><br/>
                                <table>
                                    <tr>
                                        <td>Bank Name</td>
                                        <td>:</td>
                                        <td><?php echo $company_details->BANK; ?></td>
                                    </tr>
                                    <tr>
                                        <td>A/c No.</td>
                                        <td>:</td>
                                        <td><?php echo $company_details->ACNT_NO; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Branch</td>
                                        <td>:</td>
                                        <td><?php echo $company_details->BANK_BRANCH; ?></td>
                                    </tr>
                                    <tr>
                                        <td>IFS Code</td>
                                        <td>:</td>
                                        <td><?php echo $company_details->IFSC_CODE; ?></td>
                                    </tr>
                                </table>                        
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center; border-top: 1px solid #AAAAAA;">This is a Computer Generated Voucher</td>
                </tr>
            </table>

            <div class="clear_fix">&nbsp;</div>
            <table class="table footer_clr">
                <tr>
                    <td></td>
                    <td style="background-color: #00aeef;"></td>
                    <td style="background-color: #00aeef;"></td>
                    <td style="background-color: #00aeef;"></td>
                    <td></td>
                    <td style="background-color: #b3d335"></td>
                    <td style="background-color: #b3d335"></td>
                    <td></td>
                    <td style="background-color: #00aeef"></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div id="content">
            <h1>Cash Voucher</h1>
            <table class="table">
                <?php
                $tot_amt = 0.00;
                $cnt = 1;
                $amt = 0;
                foreach ($vno->result() as $key => $value) {
                    ?>
                    <?php if ($cnt == 1) { ?>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2" style="text-align: right">No. : <b><?php echo $value->BOOK_NAME . $value->BOOK_NUMBER ?></b></td>
                        </tr>
                        <tr>
                            <?php $cash_to = $value->CASH_TO ? $value->CASH_TO : "....................................................."; ?>
                            <td colspan="2">To. : <b><?php echo $cash_to ?></b></td>
                            <td colspan="2" style="text-align: right">Date: <b><?php echo date('d-M-Y', strtotime($value->DATE_OF_TRANSACTION)); ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="border-top: 1px solid;border-bottom: 1px solid;">Description</td>
                            <td style="text-align: right;border-top: 1px solid;border-bottom: 1px solid;border-left: 1px solid;">Amount</td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td>
                            <?php
                            $query = $this->db->query("select ACC_NAME from tbl_account where ACC_ID=" . $value->ACC_ID);
                            $val = $query->row_array();
                            echo "<b>" . $val['ACC_NAME'];
                            if ($value->SUB_ACC != '' && $value->SUB_ACC != 0) {
                                $query1 = $this->db->query("select ACC_NAME from tbl_account where ACC_ID=" . $value->SUB_ACC);
                                $val1 = $query1->row_array();
                                echo " - " . $val1['ACC_NAME'];
                            }
                            echo "</b><br>" . $value->REMARKS;
                            ?>
                        </td>
                        <?php if ($value->CREDIT) { ?>
                            <td><?php echo number_format($value->CREDIT, 2) ?> Cr</td>
                            <td></td>
                            <?php
                            $tot_amt -= $value->CREDIT;
                            $amt = $value->CREDIT;
                            ?>
                        <?php } else if ($value->DEBIT) { ?>
                            <td></td>
                            <td><?php echo number_format($value->DEBIT, 2); ?> Dr</td>
                            <?php
                            $tot_amt += $value->DEBIT;
                            $amt = $value->DEBIT;
                            ?>
                        <?php } ?>
                        <td style="text-align: right;border-left: 1px solid;min-height: 500px;"><?php echo number_format($amt, 2); ?></td>
                    </tr>
                    <?php
                    $cnt++;
                }
                ?>
                <tr>
                    <td colspan="3" style="text-align: right;border-bottom: 1px solid;border-top: 1px solid"><b>Total</b></td>
                    <td style="text-align: right;border-left: 1px solid;border-bottom: 1px solid;border-top: 1px solid"><?php echo number_format($tot_amt, 2); ?></td>
                </tr>
                <tr>
                    <?php
                    $decimal = round($tot_amt - ($no = floor($tot_amt)), 2) * 100;
                    $hundred = null;
                    $digits_length = strlen($no);
                    $i = 0;
                    while ($i < $digits_length) {
                        $divider = ($i == 2) ? 10 : 100;
                        $tot_amt = floor($no % $divider);
                        $no = floor($no / $divider);
                        $i += $divider == 10 ? 1 : 2;
                        if ($tot_amt) {
                            $plural = (($counter = count($str)) && $tot_amt > 9) ? 's' : null;
                            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                            $str [] = ($tot_amt < 21) ? $words[$tot_amt] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($tot_amt / 10) * 10] . ' ' . $words[$tot_amt % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
                        } else
                            $str[] = null;
                    }
                    $Rupees = implode('', array_reverse($str));
                    $paise = ($decimal) ? "and " . ($words[$decimal / 10 * 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
                    $return = ($Rupees ? $Rupees : '');
                    $return .= ($paise ? $paise : "") . " Only";
                    $received_by = $value->CASH_RECEIVED_BY ? $value->CASH_RECEIVED_BY : ".....................................................";
                    ?>
                    <td colspan="4" style="padding-top: 20px"><?php echo "Cash Received by " . $received_by . "&nbsp; Rupees " . ucwords($return) ?></td>
                </tr>
            </table>
        </div>
    </body>
</html>