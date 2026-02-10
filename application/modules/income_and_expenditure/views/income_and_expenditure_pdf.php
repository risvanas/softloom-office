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
            #content h1 {
                text-align: center;
                margin-top: 0;
            }
            table#from_to{
                margin: auto;
                margin-bottom: 15px;
                margin-top: 10px;
            }
/*            #sample_1 .label-success {
                background-color: #5cb85c;
            }
            #sample_1 .label {
                display: inline;
                font-weight: bold;
                line-height: 1;
                color: #fff;
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                border-radius: .25em;
                padding: 0.4em 0.6em !important;
                padding: 5px;
            }*/
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
            <table class="table">
                <tr>
                    <td colspan="5" class="bottom">Income and Expenditure</td>
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
            <h1>Income and Expenditure</h1>
            <table id="from_to">
                <tr>
                    <td>From: <?php echo $frm ?></td>
                    <td>To: <?php echo $to ?></td>
                </tr>
            </table>
            <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                <thead>
                    <tr>
                        <th>sl no</th>
                        <th>Account</th>
                        <th>Debit</th>
                        <th>Credit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $income_sum = 0;
                    $expence_sum = 0;
                    foreach ($data_pass->result() as $row) {
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <?php
                            //$val1=$row->expen - $row->income;
                            if ($row->acc_type >= 'INCOME') {
                                $val = "INCOME";
                                $income_sum += $row->income;
                                ?>
                                <td><?php echo $row->a_name . '[' . $row->acc_type . ']'; ?></td>
                                <td><?php echo $row->income; ?></td>
                                <td></td>
                                <?php
                            } elseif ($row->acc_type >= 'EXPENSES') {
                                $val = "EXPENSES";
                                $expence_sum += $row->expen;
                                ?>
                                <td><?php echo $row->a_name . '[' . $row->acc_type . ']'; ?></td>
                                <td></td>
                                <td><?php echo $row->expen; ?></td>
                    <!--<td><?php echo $row->income; ?></td>-->
                                <?php
                            }
                            $diffrence = $income_sum - $expence_sum;
                            ?>
                        </tr>
                        <?php
                        $count++;
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td><b>Total</b></td>
                        <td><b><?php echo $income_sum; ?></b></td>
                        <td><b><?php echo $expence_sum; ?></b></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="2">
                            <?php
                            if ($diffrence >= 0) {
                                ?>
                                <span class="label label-success"><?php echo $diffrence; ?></span>
                                <?php
                            } else {
                                ?>
                                <span class="label label-danger"><?php echo $diffrence; ?></span>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>