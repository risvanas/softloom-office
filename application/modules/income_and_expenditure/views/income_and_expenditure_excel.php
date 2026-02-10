
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
        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
            <tr>
                <td colspan="2"><img id='logo_image' src='https://softloom.com/wp-content/uploads/2017/06/logo.png' alt='Softloom ITSolution' style="width: 100%"></td>
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
            <tr><td colspan="4" style="text-align: center;font-weight: 700">Income and Expenditure</td></tr>
            <tr>
                <td colspan="4" style="text-align: center;">From: <?php echo $frm ?>&nbsp;&nbsp;To: <?php echo $to ?></td>
            </tr>	
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
                        <?php } elseif ($row->acc_type >= 'EXPENSES') {
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
                    } ?>
                <tr>
                    <td></td>
                    <td><b>Total</b></td>
                    <td><b><?php echo $income_sum; ?></b></td>
                    <td><b><?php echo $expence_sum; ?></b></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="2" style="text-align: left">
                        <?php if ($diffrence >= 0) { ?>
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
    </body>
</html>