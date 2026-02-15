  <table class="table table-striped table-bordered table-hover table-full-width">
    <thead>
      <tr>
        <th colspan="8">From: <?php echo $frm ?> &nbsp;&nbsp;To: <?php echo $to ?></th>
      </tr>
      <tr>
        <th>Number</th>
        <th style="width: 80px">Date</th>
        <th>Name</th>
        <th>Invoice Type</th>
        <th>Amount</th>
        <th>Tax Amount</th>
        <th>Total Amount</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $tot_amt = $gst_amt = $sub_total = 0;
      foreach ($serch->result() as $row) {
      ?>
        <tr>
          <?php
          $from_date = date("y", strtotime($row->year_code_from));
          $to_date = date("y", strtotime($row->year_code_to));
          ?>
          <td><a href="<?php echo site_url('invoice/print_payment_report') . encrypt($row->PAY_ID) . "/" . $row->year_code_id; ?> " target="_blank">PAY<?php echo $row->PAY_NUMBER . "/" . $from_date . "-" . $to_date; ?></a></td>
          <td><?php echo date("d-m-Y", strtotime($row->PAYMENT_DATE)); ?></td>
          <td><?php echo $row->NAME; ?></td>
          <td><?php echo ucwords(strtolower(str_replace('_', ' ', $row->INVOICE_TYPE))); ?></td>
          <td>
            <?php echo $row->SUB_TOTAL_PRICE;
            $sub_total +=  $row->SUB_TOTAL_PRICE; ?>
          </td>
          <td>
            <?php echo $gst = $row->SGST_AMOUNT + $row->CGST_AMOUNT;
            $gst_amt += $gst; ?>
          </td>
          <td>
            <?php echo $row->AMOUNT;
            $tot_amt +=  $row->AMOUNT; ?>
          </td>
        </tr>
      <?php
      }
      ?>
      <tr>
        <td colspan="4" style="text-align: right;">Total</td>
        <td><?php echo $sub_total ?></td>
        <td><?php echo $gst_amt ?></td>
        <td><?php echo $tot_amt ?></td>
      </tr>
    </tbody>
  </table>