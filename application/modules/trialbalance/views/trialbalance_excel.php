<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            table, td {
                border:thin solid black
            }
            table {
                border-collapse:collapse
            }
        </style>
    </head>
    <body> 
        <?php
        $disf_date = date('d-M-Y', strtotime($from_date));
        $dist_date = date('d-M-Y', strtotime($next_date));
        ?>
        <table border="1" class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
            <tr>
                <td colspan="2"><img id='logo_image' src='https://softloom.com/wp-content/uploads/2017/06/logo.png' alt='Softloom ITSolution'></td>
                <td colspan="2">
                    <p>
                        Softloom it solutions,<br>
                        Ist Floor, HA Tower,<br>
                        Providence Road,<br>
                        Kacheripady, Kochi, Ernakulam,<br>
                        Kerala 682018 <br>
                    </p>
                </td>
            </tr>
            <tr><td colspan="4" style="text-align: center;font-weight: 700">Trial Balance</td></tr>
            <tr>
<!--                <td colspan="2"></td>
                <td>From: <?php echo $frm ?></td>
                <td>To: <?php echo $to ?></td>
                <td colspan="2"></td>-->
                <td colspan="4" style="text-align: center;">From: <?php echo $disf_date ?>&nbsp;&nbsp;To: <?php echo $dist_date ?></td>
            </tr>	
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
                    <!-- <td><b><?php echo $total_opening; ?></b></td>
                    <td><b><?php echo $total_credit; ?></b></td>
                    <td><b><?php echo $total_debit; ?></b></td> -->
                    <td><b><?php echo abs($new2_total); ?></b></td>
                    <td><b><?php echo $new1_total; ?></b></td>
                </tr>
                <?php
                //$trial_balance=$op_sum+$credit_sum-$debit_sum;
                ?>
            </tbody>
        </table>
    </body>
</html>