<html>
    <head>
        <style>
            body{
                font-size: 10px;
            }
            @page {
                margin: 160px 50px 75px 80px;
            }
            #header {
                position: fixed;
                left: 0px;
                top: -160px;
                right: 0px; 
                height: 40px; 
                text-align: center;
            }
            h2.name {
                font-size: 13px; 
                /*                font-weight: normal;*/
                margin: 0;
                text-transform: uppercase;
            }
            #footer {
                position: fixed; 
                left: 0px;
                bottom: -75px;
                right: 0px;
                height: 40px;
            }
            #footer .pattern td {
                height: 20px;
                width: 10%;
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
                border-collapse: collapse;
            }
            #content table tr th,#content table tr td{
                border: 1px solid #ddd;
                padding: 10px;
            }
            hr {
                border: 0px;
                border-top: 1px solid #ccc;
            }
            #sample_1{
                width: calc(100% - 80px);
            }
            #content h1 {
                text-align: center;
                margin-top: 0;
            }
            table#from_to{
                margin: auto;
                margin-bottom: 15px;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <?php
        $disf_date = date('d-M-Y', strtotime($from_date));
        $dist_date = date('d-M-Y', strtotime($next_date));
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
                        <?php echo "<p style='margin: 0;padding: 0'>" .$company_details->ADDRESS1 . ",<br>" .
                        $company_details->ADDRESS2 . ",<br>" .
                        $company_details->ADDRESS3 . "-" . $company_details->PIN_CODE . ", " . $company_details->STATE . "<br>" .
                        $company_details->PHONE_NO . ", " . $company_details->MOBILE_NO1 . "<br>" .
                        $company_details->EMAIL . ", " . $company_details->EMAIL1 . "</p>";
                        echo ($company_details->GSTNO) ? "<p style='margin: 0;'>GSTIN: " . $company_details->GSTNO . "</p>" : ""; ?>
                        </p>
                    </td>
                </tr>
            </table>
            <hr>
        </div>
        <div id="footer">
            <table class="table">
                <tr>
                    <td colspan="5" class="bottom">Trial Balance</td>
                    <td colspan="5" class="page">Page </td>
                </tr>
                <tr class="pattern">
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
<!--            <p class="bottom">softloom it solns</p>
            <p class="page">Page </p>-->
        </div>
        <div id="content">
            <h1>Trial Balance</h1>
            <table id="from_to">
                <tr>
                    <td>From: <?php echo $disf_date ?></td>
                    <td>To: <?php echo $dist_date ?></td>
                </tr>
            </table>
            <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1"  style="width: 100%;">
                <thead>
                    <tr>
                        <th>sl no</th>
                        <th>Account Name</th>
                   <!-- <th>Opening Balance</th>
                    <th>Credit</th>
                    <th>Debit</th> -->
                        <th>Credit</th>
                        <th>Debit</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $credit_sum = 0;
                    $debit_sum = 0;
                    $op_sum = 0;
                    $spec_credit = 0;
                    $spec_debit = 0;
                    $total_opening = 0;
                    $total_credit = 0;
                    $total_debit = 0;
                    $new1_total = 0;
                    $new2_total = 0;
                    foreach ($data_pass->result() as $res) {
                        $acc_id = $res->ACC_ID;
                        $acc_name = $res->ACC_NAME . " " . "[" . $res->p_name . "]";
                        $op_balance = $res->OPENING_BALANCE;
                        $open_sql = "SELECT IFNULL( SUM( DEBIT ) , 0 ) - IFNULL( SUM( CREDIT ) , 0 ) AS opening
			  	FROM tbl_transaction 
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  '$acc_id'
			  	AND tbl_transaction.DATE_OF_TRANSACTION < '$from_date' ";

                        if ($company_code != "") {
                            $open_sql .= "and COMPANY=$company_code";
                        }
                        $query = $this->db->query($open_sql);
                        //$row = $query->row_array();
                        //$spec_credit=$res->Column1 ;
                        //$spec_debit=$res->Column2;
                        //$value  =  $spec_debit  -  $spec_credit;
                        $open = $query->row_array();
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>

                            <td>
                                <?php
                                $encrypted_data1 = $res->ACC_ID;
                                $encrypted_data1 = $this->encryption->encrypt($encrypted_data1);
                                $encrypted_data1 = str_replace("/", "~", $encrypted_data1);
                                $encrypted_data1 = str_replace("=", "-", $encrypted_data1);
                                $encrypted_data1 = str_replace("+", ".", $encrypted_data1);
                                $encrypted_data2 = $from_date;
                                $encrypted_data2 = $this->encryption->encrypt($encrypted_data2);
                                $encrypted_data2 = str_replace("/", "~", $encrypted_data2);
                                $encrypted_data2 = str_replace("=", "-", $encrypted_data2);
                                $encrypted_data2 = str_replace("+", ".", $encrypted_data2);
                                $encrypted_data3 = $next_date;
                                $encrypted_data3 = $this->encryption->encrypt($encrypted_data3);
                                $encrypted_data3 = str_replace("/", "~", $encrypted_data3);
                                $encrypted_data3 = str_replace("=", "-", $encrypted_data3);
                                $encrypted_data3 = str_replace("+", ".", $encrypted_data3);
                                echo $acc_name;
                                ?>
                            </td>
                   <!-- <td> --> <?php
                            $openings = $open['opening']; //+$op_balance
                            $total_opening += $openings;
                            if ($openings > 0) {
                                //echo $openings. " Db. ";
                            }
                            if ($openings < 0) {
                                //echo abs($openings). " Cr. "; 
                            }
                            if ($openings == 0) {
                                //echo $openings;
                            }
                            ?> <!-- </td> -->
                            <?php
                            $query1 = $this->db->query("SELECT SUM( DEBIT ) as debit,SUM( CREDIT ) AS credit
			  	FROM tbl_transaction
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  '$acc_id'
			  	AND tbl_transaction.DATE_OF_TRANSACTION >= '$from_date' and tbl_transaction.DATE_OF_TRANSACTION <= '$next_date'");
                            $debit_credit = $query1->row_array();
                            ?>
                    <!-- <td> --> <?php
                            $my_debit = $debit_credit['credit'];
                            /* if($value<0)
                              {echo abs($value) ;} */
                            ?>
                            <!-- </td> -->

                            <!-- <td> --> <?php
                            $my_credit = $debit_credit['debit'];
                            /* if($value>0)
                              {echo $value ;} */
                            ?>
                            <!-- </td> -->


                            <?php
                            $i++;

                            $total_credit += $my_credit;
                            $total_debit += $my_debit;

                            /* $debit_sum=$debit_sum+$res->Column1;
                              $credit_sum=$credit_sum+$res->Column2;
                              $op_sum=$op_sum+$res->op; */
                            $new_total = ($openings + $my_credit) - $my_debit;
                            if ($new_total >= 0) {
                                ?>
                                <td></td>
                                <td><?php echo $new1 = $new_total; ?></td>

                                <?php
                                $new2 = 0;
                            } else {
                                ?>
                                <td><?php echo abs($new2 = $new_total); ?></td>
                                <td></td>
                                <?php
                                $new1 = 0;
                            }
                            $new1_total += $new1;
                            $new2_total += $new2;
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td colspan="2" align="center">Total</td>
                        <!-- <td><b><?php //echo $total_opening;      ?></b></td>
                        <td><b><?php // echo $total_credit;      ?></b></td>
                        <td><b><?php //echo $total_debit;      ?></b></td> -->
                        <td><b><?php echo abs($new2_total); ?></b></td>
                        <td><b><?php echo $new1_total; ?></b></td>
                    </tr>
                    <?php
                    //$trial_balance=$op_sum+$credit_sum-$debit_sum;
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>