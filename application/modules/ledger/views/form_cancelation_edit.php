<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/invoice/css/style.css' />
<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>invoice/css/print.css' media="print" />
<div class="row" style="padding-top:20px;">  
    <div class="col-sm-12">   

        <!-- start: INLINE TABS PANEL -->   
        <div class="panel panel-default">         
            <div class="panel-heading"> 
                <i class="icon-reorder"></i> Invoice      
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> 
                    <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a>
                    <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a>
                </div>     
            </div>     
            <form  role="form" id="form" method="post" action="<?php echo site_url('invoice_cancelation/add_cancelation'); ?>" onsubmit="ins_data();">   
                <div class="panel-body">    
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>"> 
                        <button class="close" data-dismiss="alert"> × </button>   
                        <i class="icon-ok-sign"></i> <?php echo $msg; ?> 
                    </div>       
                    <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>">
                        <i class="icon-remove"></i> <?php echo $errmsg; ?> 
                    </div>              
                    <h2><i class="icon-group teal"></i> Invoice Cancelation</h2> 
                    <div><hr /></div>  
                    <?php
                    foreach ($cancel_details->result() as $row) {
                        $cancel_no = $row->BOOK_NUM;

                        $cancel_date = $row->CANCELATION_DATE;
                        if ($cancel_date != "") {
                            $cancel_date = strtotime($cancel_date);
                            $cancel_date = date('d-m-Y', $cancel_date);
                        } $cancel_amount = $row->CANCEL_AMOUNT;
                        $can_remarks = $row->DESCRIPTION;
                    }
                    ?>          
                    <div class="row">  
                        <div class="col-sm-6">     
                            <div class="row">     
                                <div class="col-md-4">   
                                    <div class="form-group">    
                                        <label class="control-label"> Cancelation Number </label>   
                                        <div class="input-group">      
                                            <input autocomplete="off" type="text" name="txt_buk_num" id="txt_buk_num" Class="form-control" value="<?php echo $cancel_no; ?>" readonly="readonly"/>  
                                            <input type="hidden" name="temp_cancel_num" id="temp_cancel_num" Class="form-control" value="<?php echo $cancel_no; ?>"/>  
                                        </div>          
                                    </div>  
                                </div>            
                                <div class="col-md-8">       
                                    <div class="form-group"> 
                                        <label class="control-label"> Cancelation Date <span class="symbol required"> </span></label>    
                                        <span class="input-icon input-icon-right">    
                                            <input autocomplete="off" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="txt_cancel_date" name="txt_cancel_date" value="<?php echo $cancel_date; ?>" readonly="readonly"/>
                                            <i class="icon-calendar"></i>
                                        </span> 
                                    </div> 
                                </div>            
                            </div>  
                            <div class="row"> 
                                <div class="col-md-12">  
                                    <div class="form-group" id="h1">         
                                        <label class="control-label">Cancelation Amount <span class="symbol required"> </span></label>
                                        <input autocomplete="off" type="text" name="txt_can_amount" id="txt_can_amount" Class="form-control" value="<?php echo $cancel_amount; ?>" readonly="readonly"/>            
                                    </div>   
                                </div>         
                                <div class="col-sm-12">  
                                    <div class="form-group">           
                                        <label class="control-label">Remarks <span class="symbol required"> </span></label>
                                        <textarea class="form-control" name="txt_descri" id="txt_descri" readonly="readonly"><?php echo $can_remarks; ?></textarea>      
                                    </div> 
                                </div>           
                            </div>         
                        </div>                 
                        <input type="hidden" id="txt_validation" name="txt_validation"/>   

                        <div class="col-sm-6">
                            <div id="output"> 
                                <div class="panel-body">        
                                    <h2><i class="icon-group teal"></i> Invoice Details</h2>          
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
                                            <div class="col-sm-12">  
                                                <div class="row">


                                                    <div class="col-md-4"> 
                                                        <div class="form-group"> 
                                                            <input type="hidden" name="hdd_invo_id" id="hdd_invo_id" Class="form-control" value="<?php echo $invoice_id; ?>"/>
                                                            <label class="control-label"> Book Number : <?php echo $row->BOOK_NUMBER; ?></label>  
                                                        </div>                       
                                                    </div>                  
                                                    <div class="col-md-8">    
                                                        <div class="form-group">        
                                                            <label class="control-label"> Invoice Date : <?php
                                                                $invoice_date = $row->INVOICE_DATE;
                                                                $invoice_date = strtotime($invoice_date);
                                                                echo $invoice_date = date("d-m-Y", $invoice_date);
                                                                ?>
                                                            </label>            
                                                        </div>      
                                                    </div>   
                                                </div>  
                                                <div class="row">     
                                                    <div class="col-md-12">
                                                        <div class="form-group" id="h1">
                                                            <label class="control-label">Customer Name : <?php echo $customer_name; ?></label> 
                                                        </div>   
                                                    </div>
                                                    <div class="col-sm-12">  
                                                        <div class="form-group">  
                                                            <label class="control-label">Description : <?php echo $row->DESCRIPTION; ?></label>  
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
                                                        <th>Item</th>
                                                        <th>Description</th>
                                                        <th>Unit Cost</th> 
                                                        <th>Quantity</th>
                                                        <th>Price</th> 
                                                        </thead> 
                                                        <?php
                                                        $details = $this->db->query("SELECT * FROM tbl_invoicedetails WHERE INVOICE_ID='$invoice_id' AND DEL_FLAG='1'");
                                                        foreach ($details->result() as $items) {
                                                            $unit_cost = $items->UNIT_COST;
                                                            $quantity = $items->QUANTITY;
                                                            $price = $unit_cost * $quantity;
                                                            ?>   

                                                            <tr class="item-row">
                                                                <td class="item-name"><?php echo $items->ITEM; ?></td> 
                                                                <td class="description"><?php echo $items->DESCRIPTION; ?></td> 
                                                                <td><?php echo $items->UNIT_COST; ?></td>   
                                                                <td><?php echo $items->QUANTITY; ?></td> 
                                                                <td><?php echo $price; ?></td>    
                                                            </tr>    
                                                        <?php } ?>
<!--                                                        <tr id="hiderow"> 
                                                            <td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>  
                                                        </tr> -->
                                                        <tr> 
                                                            <td colspan="2" class="blank"></td>
                                                            <td colspan="2" class="total-line">Subtotal</td> 
                                                            <td class="total-value"><?php echo $row->TOTAL_PRICE; ?></td>  
                                                        </tr>
                                                        <tr>   
                                                            <td colspan="2" class="blank"></td> 
                                                            <td colspan="2" class="total-line">Total</td>
                                                            <td class="total-value"><?php echo $ttl_price = $row->TOTAL_PRICE; ?></td>
                                                        </tr> 
                                                        <tr> 
                                                            <td colspan="2" class="blank"></td>  
                                                            <td colspan="2" class="total-line">Amount Paid</td>  
                                                            <td class="total-value"><?php echo $row->PAID_PRICE; ?></td> 
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
                                    <?php } ?>
                                    <input type="hidden" id="txt_total" name="txt_total" value="<?php echo $ttl_price; ?>"/>
                                </div>
                            </div>
                            <script>
                                document.getElementById('txt_validation').value = 'y';
                            </script>               
                        </div>         
                    </div>         
                    <div class="row">    
                        <div class="col-sm-12">  
                            <div id="page-wrap"> 
                            </div>    
                        </div>  
                    </div>  
                </div>  
        </div>    
        <!-- end: INLINE TABS PANEL --> 
    </div>

</div>