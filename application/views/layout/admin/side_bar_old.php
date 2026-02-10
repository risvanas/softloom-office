<ul class="main-navigation-menu">
  <li class="active open"> <a href="<?php echo site_url('dashboard'); ?>"><i class="clip-home-3"></i> <span class="title"> Dashboard </span><span class="selected"></span> </a> </li>
  <li> <a href="javascript:void(0)"><i class="clip-cog-2"></i> <span class="title">Master </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
    <ul class="sub-menu">
      <li> <a href="<?php echo site_url('account'); ?>"> <span class="title"> New Account </span> </a> </li>
     <li><a href="<?php echo site_url('account/mainaccount_list');?>"> <span class="title">Account List </span> </a> </li>
      <li> <a href="<?php echo site_url('account/subaccount');?>"> <span class="title"> Sub Account </span> </a> </li>
    <li><a href="<?php echo site_url('account/subaccount_list');?>"><span class="title"> Sub Account List </span></a></li>
       <li> <a href="<?php echo site_url('account/staff_register');?>"><span class="title"> New Saff </span> </a> </li>
        <li> <a href="<?php echo site_url('account/staff_list');?>"><span class="title"> Saff list </span> </a> </li>
      <li><a href="<?php echo site_url('account/customer_register');?>"><span class="title"> New Customer </span></a></li>
      <li><a href="<?php echo site_url('account/customer_list');?>"><span class="title"> Customer List</span></a></li>
	  <li><a href="<?php echo site_url('accounting_year/new_accounting_year');?>"><span class="title"> Accounting Year</span></a></li>
	  <li><a href="<?php echo site_url('accounting_year/account_year_list');?>"><span class="title"> Accounting Year List</span></a></li>
    </ul>
  </li>
  <li> <a href="javascript:void(0)"><i class="clip-grid-6"></i> <span class="title"> Business </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
    <ul class="sub-menu">
      <li> <a href="<?php echo site_url('student'); ?>"> <span class="title">New Student</span> </a> </li>
      <li> <a href="<?php echo site_url('student/student_list');?>"> <span class="title"> Student List </span> </a> </li>
       <li> <a href="<?php echo site_url('feecollection/coursecompletion');?>"> <span class="title">Course Completion </span> </a> </li>
      <li> <a href="<?php echo site_url('service/index'); ?>"> <span class="title">New Domain/Server</span> </a> </li>
      <li> <a href="<?php echo site_url('service/service_list');?>"> <span class="title">Service List</span> </a> </li>
       <li> <a href="<?php echo site_url('lockdate');?>"> <span class="title">Lock Date</span> </a> </li>
        
    </ul>
  </li>
  
  
  <li> <a href="javascript:void(0)"><i class="clip-grid-6"></i> <span class="title"> Finance  </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
    <ul class="sub-menu">
     <li> <a href="<?php echo site_url('voucher'); ?>"> <span class="title">Payment Voucher</span> </a> </li>
      <li> <a href="<?php echo site_url('receipt'); ?>"> <span class="title">Cash Receipt</span> </a> </li>
       <li> <a href="<?php echo site_url('bank_voucher'); ?>"> <span class="title">Bank Voucher</span> </a> </li>
        <li> <a href="<?php echo site_url('feecollection'); ?>"> <span class="title"> Fee Collection </span> </a> </li>
       <li><a href="<?php echo site_url('customer_payment');?>"><span class="title"> Customer Payment</span> </a> </li>
      <li> <a href="<?php echo site_url('day_book'); ?>"> <span class="title">Day Book</span> </a> </li>
       <li> <a href="<?php echo site_url('invoice'); ?>"> <span class="title">Invoice</span> </a> </li>
      <li> <a href="<?php echo site_url('ledger'); ?>"> <span class="title">Ledger</span> </a> </li>
      <li> <a href="<?php echo site_url('salary_posting'); ?>"> <span class="title">Salary Posting</span> </a> </li>
       <li> <a href="<?php echo site_url('student_payment'); ?>"> <span class="title">Student Payment</span> </a> </li>
        <li> <a href="<?php echo site_url('trialbalance'); ?>"> <span class="title">Trial Balance</span> </a> </li>
         <li> <a href="<?php echo site_url('profit_and_loss'); ?>"> <span class="title">Profit And Loss Account</span> </a> </li>
          <li> <a href="<?php echo site_url('balance_sheet'); ?>"> <span class="title">Balance Sheet</span> </a> </li>
           <li> <a href="<?php echo site_url('training_return'); ?>"> <span class="title">Training Return</span> </a> </li>
            <li> <a href="<?php echo site_url('training_refund'); ?>"> <span class="title">Training Refund</span> </a> </li>
             <li> <a href="<?php echo site_url('invoice/invoice_list'); ?>"> <span class="title">Invoice List</span> </a> </li>
			 <li> <a href="<?php echo site_url('income_and_expenditure'); ?>"> <span class="title">Income and Expenditure</span> </a> </li>
			<!-- <li> <a href="<?php echo site_url('graph'); ?>"> <span class="title">Graph</span> </a> </li>-->
    </ul>
  </li>
  
  
  
 <li> <a href="javascript:void(0)"><i class="clip-grid-6"></i> <span class="title"> Enquiry  </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
    <ul class="sub-menu">
     <li> <a href="<?php echo site_url('enquiry'); ?>"> <span class="title"> New Enquiry</span> </a> </li>
       <li> <a href="<?php echo site_url('enquiry/enquiry_details'); ?>"> <span class="title">Enquiry List</span> </a> </li>
       <li> <a href="<?php echo site_url('followup/followup_details'); ?>"> <span class="title">Follow Up</span> </a> </li>
       
     </ul>
 </li>
 <li> <a href="javascript:void(0)"><i class="clip-grid-6"></i> <span class="title"> InfoGraphics  </span><i class="icon-arrow"></i> <span class="selected"></span> </a>
 <ul class="sub-menu">
  <li> <a href="<?php echo site_url('graph'); ?>"> <span class="title">Sales</span> </a> </li>
 <li> <a href="<?php echo site_url('graph/payment_graph'); ?>"> <span class="title">Payments</span> </a> </li>
 <li> <a href="<?php echo site_url('graph/income_expenditure_graph'); ?>"> <span class="title">Income and Expenditure</span> </a> </li>
 </li>
</ul>

