<html>
    <head>
        <style>
            body{
                font-size: 10px;
            }
            @page {
                margin: 160px 50px 100px 80px;
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
                bottom: -100px;
                right: 0px;
                height: 40px;
            }
            table.table{
                width: 100%;
            }
            .page{
                text-align: right;
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
                        // echo ($company_details->GSTNO) ? "<p style='margin: 0;'>GSTIN: " . $company_details->GSTNO . "</p>" : ""; ?>
                        </p>
                    </td>
                </tr>
            </table>
            <hr>
        </div>
        <div id="footer">
            <table class="table">
                <tr>
                    <td class="bottom">Student List</td>
                    <td class="page">Page </td>
                </tr>
            </table>
        </div>
        <div id="content">
            <h1>Student List</h1>
			
            <table class="table table-striped table-bordered table-hover table-full-width" >
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
						<th style="min-width: 75px;">Last Payment Date</th>
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
                        <th style="min-width: 75px;"> Reg Date </th>
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
                        $query = $this->db->query("SELECT SUM(AMOUNT) AS AMOUNT,MAX(PAYMENT_DATE) AS LAST_PAYMENT FROM tbl_payment WHERE STUDENT_ID=$stud_id AND TYPE='STD' AND DEL_FLAG='1'");
                        $res = $query->row_array();
                        $totl_amt = $res['AMOUNT'];
                        $fee_amt = $row->FEE_AMOUNT;
						$last_payment=$res['LAST_PAYMENT'];
                        if($row->DISTRICT) {
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
                            <td>
                                <?php if ($fee_amt <= $totl_amt) { ?>
                                    <span class="badge badge-success"> <?php echo $sn_count; ?></span>
                                <?php } else { ?>
                                    <span class="badge"> <?php echo $sn_count; ?></span>
                                <?php } ?>
                            </td>
                            <td><?php echo $row->NAME; ?><?php echo "&nbsp;(SIS" . $row->STUDENT_ID . ")"; ?></td>
                            <td><?php echo $row->CONTACT_NO; ?></td>
                            <td><?php echo $address; ?></td>
                            <td><?php echo $row->STUD_EMAIL; ?></td>
                            <td style="width: 75px;"><?php echo $row->STUDENT_DOB; ?></td>
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
							<td style="width: 75px;"><?php $last_payment;
		                    $last_payment = strtotime($last_payment);
		                    echo  $last_payment=date("d-m-Y", $last_payment);?></td>
			   <?php  }  ?>
						   
                            <td><?php echo $row->FEE_AMOUNT; ?></td>
				   <?php
			               if($type == "rpt")
						   {?>
							 <td><?php echo $totl_amt;?></td>
							   <td><?php echo $due_amt=$fee_amt-$totl_amt;?></td>
					 <?php }
						  else 
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
        </div>
    </body>
</html>