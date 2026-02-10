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
        <table class="table table-striped table-bordered table-hover table-full-width" >
            <tr>
			   
                <td colspan="6"><img id='logo_image' src='https://softloom.com/wp-content/uploads/2017/06/logo.png' alt='Softloom ITSolution'></td>
                <td colspan="<?php if ($type == "rpt") { echo "6"; } else {  echo "5"; } ?>"   >
                    <p>
                        Softloom it solutions,<br>
                        Ist Floor, HA Tower,<br>
                        Providence Road,<br>
                        Kacheripady, Kochi, Ernakulam,<br>
                        Kerala 682018 <br>
                    </p>
                </td>
            </tr>
            <tr><td colspan="<?php if($type == "rpt") { echo "12"; } else { echo "11"; } ?>" style="text-align: center;font-weight: 700">Student List</td></tr>
            <thead>
                <tr>
                    <th> No</th>
                    <th> Name </th>
                    <th> Contact No </th>
                    <th> Address </th>
                    <th> Email id </th>
                    <th> Date of birth </th>
                    <th> Course </th>
					<?php
			               if($type == "rpt")
						   {
			            ?>
						<th style="min-width: 75px;"> Reg Date </th>
						<th>Last Payment Date</th>
						   <?php } ?>
                        <th> Course Fee </th>
						<?php
			               if($type == "rpt")
						   {?>
							   <th>Paid Amount</th>
							   <th>Due Amount</th>
					 <?php }
						  else 
						  {
			              ?>
                    <th> Reg Date </th>
                    <th> Due Date </th>
                    <th> Status</th>
						  <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $sn_count = 1;
                $crnt_date = date('d-m-Y');
                foreach ($s->result() as $row) {
                    $stud_id = $row->STUDENT_ID;
                    $query = $this->db->query("SELECT SUM(AMOUNT) AS AMOUNT, MAX(PAYMENT_DATE) AS LAST_PAYMENT FROM tbl_payment WHERE STUDENT_ID=$stud_id AND TYPE='STD' AND DEL_FLAG='1'");
                    $res = $query->row_array();
                    $totl_amt = $res['AMOUNT'];
					$last_payment=$res['LAST_PAYMENT'];
                    $fee_amt = $row->FEE_AMOUNT;
                    if ($row->DISTRICT) {
                        $dis_query = $this->db->query("SELECT DISTRICT FROM tbl_districts WHERE DIS_ID=" . $row->DISTRICT);
                        $district = $dis_query->row_array();
                    }
                    $address = ($row->ADDRESS1) ? $row->ADDRESS1 : "";
                    $address .= ($row->ADDRESS2) ? ", " . $row->ADDRESS2 : "";
                    $address .= ($row->ADDRESS3) ? ", " . $row->ADDRESS3 : "";
                    $address .= ($row->DISTRICT) ? ", " . $district['DISTRICT'] : "";
                    $address .= ($row->PIN_NUM) ? ", " . $row->PIN_NUM : "";
                    ?>
                    <tr>
                        <td ><?php if ($fee_amt <= $totl_amt) {
                        ?>
                                <span class="badge badge-success"> <?php echo $sn_count; ?></span>
                                <?php
                            } else {
                                ?>
                                <span class="badge"> <?php echo $sn_count; ?></span>
                                <?php
                            }
                            ?></td>
                        <td><?php echo $row->NAME; ?><?php echo "&nbsp;(SIS" . $row->STUDENT_ID . ")"; ?></td>
                        <td><?php echo $row->CONTACT_NO; ?></td>
                        <td><?php echo $address; ?></td>
                        <td><?php echo $row->STUD_EMAIL; ?></td>
                        <td><?php echo $row->STUDENT_DOB; ?></td>
                        <td><?php echo $row->ACC_NAME; ?></td>
						
						<?php
			               if($type == "rpt")
						   {
							   
			            ?>
						<td style="width: 75px;"><?php
                                $reg_date = $row->REG_DATE;
                                $reg_date = strtotime($reg_date);
                                echo $reg_date = date("d-m-Y", $reg_date);
                                ?>
                            </td>
							<td><?php $last_payment;
		                    $last_payment = strtotime($last_payment);
		                    echo  $last_payment=date("d-m-Y", $last_payment);?></td>
							
			     <?php  }  ?>
						   
                            <td><?php echo $row->FEE_AMOUNT; ?></td>
				   <?php
			               if($type == "rpt")
						   {?>
							  <td><?php echo $totl_amt;?></td>
							   <td><?php echo $due_amt=$fee_amt-$totl_amt;?></td>
					 <?php } else 
						  {
			              ?>
							<td style="width: 75px;"><?php
                                $reg_date = $row->REG_DATE;
                                $reg_date = strtotime($reg_date);
                                echo $reg_date = date("d-m-Y", $reg_date);
                                ?>
                            </td>
                            <td style="width: 75px;"><?php
                                $due_date = $row->DUE_DATE;
                                $due_date = strtotime($due_date);
                                $due_date = date("d-m-Y", $due_date);
                                if ($crnt_date == $due_date)
                                    echo "<span class='label label-success'>$due_date</span>";
                                else if ($crnt_date < $due_date)
                                    echo "<span class='label label-warning' >$due_date</span>";
                                else if ($crnt_date > $due_date) {
                                    if ($due_date == '01-01-1970') {
                                        $due_date = "";
                                    }
                                    echo "<span class='label label-danger'>$due_date</span>";
                                }
                                ?>
                            </td>
                            <td><span class="label <?php echo $row->style_class; ?>" ><?php echo $row->status; ?></span></td>
						  <?php  }  ?>
                        </tr>
                        <?php
                        $sn_count++;
                    }
					?>
            </tbody>
        </table>
    </body>
</html>