<?php
class Ledger extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','template'));
		$this->template->set_template('admin_template');
		$this->load->library('form_validation');
		$this->load->model('finance_model');
	}
	
	function index()
	{
		$menu_id=36;
         $this->load->library('../controllers/permition_checker');
    		 $this->permition_checker->permition_viewprocess($menu_id);
		$this->load->model('finance_model');
		$data['cond']=$this->finance_model->selectAll('tbl_account');	
		$data['sub_acc']=$this->finance_model->select_sub_acc('tbl_account');	
		$layout = array('page' => 'form_studledger','title'=>'Finance','data'=>$data);
		render_template($layout);
	}
	
	 
		function sub_accounts()
		{
			 $accid=$this->input->post('accid');
			 $data['acc_name']=$this->finance_model->select_acc_name('tbl_account',$accid);
			 $this->load->view('form_acc_name',$data);
		
		}
		function search_details()
		{
			
			//echo $calc=$this->input->post('calc');
			$from_date=$this->input->post('fromdate');
			$to_date=$this->input->post('todate');
			$acc=$this->input->post('acc');
			$subacc=$this->input->post('subacc');
			$data['acc']=$acc;
			$data['sub']=$subacc;
			$data['frm']=$from_date;
			$data['to']=$to_date;
		    //$rdate=substr($calc,0,10);
			$from_date = strtotime($from_date);
		    $from=date("Y-m-d",$from_date);
			//echo "<br>";
			//$ddate=substr($calc,12);
            $to_date = strtotime($to_date);
            $to=date("Y-m-d", $to_date);
			
			if($acc !="" && $subacc=="")
			{
				$openings=$this->db->query("SELECT IFNULL( SUM( DEBIT ) , 0 ) - IFNULL( SUM( CREDIT ) , 0 ) AS opening
			  	FROM tbl_transaction
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  '$acc'
			  	AND tbl_transaction.DATE_OF_TRANSACTION < '$from' "); 
				$balance=$this->db->query("SELECT OPENING_BALANCE AS balance FROM tbl_account WHERE tbl_account.DEL_FLAG='1' AND tbl_account.ACC_ID='$acc'");
				
				$opening=$openings->row_array();
				$balance1=$balance->row_array();
				$opening['opening'];
				$balance1['balance'];
				$data['opening_balance'] =  $balance1['balance'] + $opening['opening'] ;
			}
			if($acc !="" && $subacc!="")
			{
				$openings=$this->db->query("SELECT IFNULL( SUM( DEBIT ) , 0 ) - IFNULL( SUM( CREDIT ) , 0 ) AS opening
			  	FROM tbl_transaction
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  '$acc'
				AND tbl_transaction.SUB_ACC =  '$subacc'
			  	AND tbl_transaction.DATE_OF_TRANSACTION < '$from' "); 
				//$balance=$this->db->query("SELECT OPENING_BALANCE AS balance FROM tbl_account WHERE tbl_account.DEL_FLAG='1' AND tbl_account.ACC_ID='$acc'");
				
				$opening=$openings->row_array();
				//$balance1=$balance->row_array();
				$opening['opening'];
				//$balance1['balance'];
				$data['opening_balance'] =  $opening['opening'] ;
			}

		 $data['sel']=$this->finance_model->multi_search($acc,$subacc,$from,$to);
		 $this->load->view('form_ledger_list',$data);
			
		}
		
	function view_details()
	{
		$book_num = $this->uri->segment(3);
		$book_name = $this->uri->segment(4);
		if($book_name == 'PV')
		 {
		$data['voucher_details']=$this->db->query("select tbl_user.FIRST_NAME as n1,tbl_user.LAST_NAME as n2,tbl_transaction.*,modified.FIRST_NAME as name1,modified.LAST_NAME as name2,tbl_account.ACC_NAME as acc,tbl_account.ACC_CODE as code,tbl_sub.ACC_NAME as sub from tbl_transaction join tbl_account on tbl_transaction.ACC_ID = tbl_account.ACC_ID left join tbl_account as tbl_sub on tbl_transaction.SUB_ACC=tbl_sub.ACC_ID left join tbl_user on tbl_transaction.CREATED_BY = tbl_user.USER_ID left join tbl_user as modified on tbl_transaction.MODIFIED_BY=modified.USER_ID where BOOK_NUMBER=$book_num AND BOOK_NAME='$book_name' AND tbl_transaction.DEL_FLAG=1 AND tbl_transaction.DEBIT IS NOT NULL");
		$data['msg']='';
		$data['errmsg']='';
		$layout = array('page' => 'form_voucher_details','title'=>'Finance','data'=>$data);
		render_template($layout);
		 }
		 elseif($book_name=='PAYD')
		 {
			 $data['c_details']=$this->db->query("select tbl_payment.*,tbl_account.ACC_NAME as acc_name,tbl_user.FIRST_NAME as n1,tbl_user.LAST_NAME as n2,modified.FIRST_NAME as name1,modified.LAST_NAME as name2 from tbl_payment join tbl_account on tbl_payment.STUDENT_ID=tbl_account.ACC_ID left join tbl_user on tbl_payment.CREATED_BY = tbl_user.USER_ID left join tbl_user as modified on tbl_payment.MODIFIED_BY=modified.USER_ID where tbl_payment.DEL_FLAG=1 and tbl_payment.PAY_NUMBER=$book_num and tbl_payment.TYPE='CUSTOMER'");
			 $data['msg']='';
		$data['errmsg']='';
		$layout = array('page' => 'form_customer_details','title'=>'Finance','data'=>$data);
		render_template($layout);
			
		 }
		 elseif($book_name == 'PAY')
		 {
			 $data['fee_details']=$this->db->query("select tbl_student.NAME as name,tbl_student.COURSE as course,tbl_payment.*,tbl_account.ACC_NAME as acc_name,tbl_user.FIRST_NAME as n1,tbl_user.LAST_NAME as n2,modified.FIRST_NAME as name1,modified.LAST_NAME as name2 from tbl_payment join tbl_student on tbl_student.STUDENT_ID=tbl_payment.STUDENT_ID join tbl_account on tbl_student.course = tbl_account.ACC_ID left join tbl_user on tbl_payment.CREATED_BY = tbl_user.USER_ID left join tbl_user as modified on tbl_payment.MODIFIED_BY=modified.USER_ID where tbl_payment.PAY_NUMBER=$book_num and tbl_payment.DEL_FLAG=1 and tbl_payment.TYPE='STD'");
			  $data['msg']='';
		$data['errmsg']='';
		$layout = array('page' => 'form_fee_details','title'=>'Finance','data'=>$data);
		render_template($layout);
		 }
		 elseif($book_name == 'BV')
		 {
			 $data['bank_voucher']=$this->db->query("select tbl_user.FIRST_NAME as n1,tbl_user.LAST_NAME as n2,modified.FIRST_NAME as name1,modified.LAST_NAME as name2,tbl_transaction.*,tbl_account.ACC_NAME as acc_name,tbl_account.ACC_CODE,tbl_subacc.ACC_NAME as subacc_name from tbl_transaction join tbl_account on tbl_transaction.ACC_ID = tbl_account.ACC_ID left join tbl_account as tbl_subacc on tbl_transaction.SUB_ACC=tbl_subacc.ACC_ID left join tbl_user on tbl_transaction.CREATED_BY = tbl_user.USER_ID left join tbl_user as modified on tbl_transaction.MODIFIED_BY=modified.USER_ID where tbl_transaction.BOOK_NAME='BV' and tbl_transaction.BOOK_NUMBER=$book_num and DEBIT IS NOT NULL and tbl_transaction.DEL_FLAG=1");
			 $data['msg']='';
		$data['errmsg']='';
		$layout = array('page' => 'form_bankvoucher_details','title'=>'Finance','data'=>$data);
		render_template($layout);
		 }
		 elseif($book_name == 'CR')
		 {
			 $data['reciept']=$this->db->query("select tbl_user.FIRST_NAME as n1,tbl_user.LAST_NAME as n2,tbl_transaction.*,modified.FIRST_NAME as name1,modified.LAST_NAME as name2,tbl_transaction.*,tbl_account.ACC_NAME as ac_name,tbl_subacc.ACC_NAME as sub_name,tbl_account.ACC_CODE as ac_code from tbl_transaction join tbl_account on tbl_transaction.ACC_ID = tbl_account.ACC_ID left join tbl_account as tbl_subacc on tbl_transaction.SUB_ACC=tbl_subacc.ACC_ID left join tbl_user on tbl_transaction.CREATED_BY = tbl_user.USER_ID left join tbl_user as modified on tbl_transaction.MODIFIED_BY=modified.USER_ID where BOOK_NAME='CR' and BOOK_NUMBER=$book_num and CREDIT IS NOT NULL and tbl_transaction.DEL_FLAG=1");
			 $data['msg']='';
		$data['errmsg']='';
		$layout = array('page' => 'form_reciept_details','title'=>'Finance','data'=>$data);
		render_template($layout);
		 }
		 elseif($book_name == 'RFD')
		 {
			 $data['refund']=$this->db->query("select tbl_user.FIRST_NAME as n1,tbl_user.LAST_NAME as n2,modified.FIRST_NAME as name1,modified.LAST_NAME as name2,tbl_payment.*,tbl_student.NAME as st_name,tbl_account.ACC_NAME as st_course from tbl_payment join tbl_student on tbl_payment.STUDENT_ID=tbl_student.STUDENT_ID join tbl_account on tbl_student.COURSE = tbl_account.ACC_ID left join tbl_user on tbl_payment.CREATED_BY = tbl_user.USER_ID left join tbl_user as modified on tbl_payment.MODIFIED_BY=modified.USER_ID where tbl_payment.PAY_NUMBER=$book_num and tbl_payment.DEL_FLAG=1");
			  $data['msg']='';
		$data['errmsg']='';
		$layout = array('page' => 'form_refund_details','title'=>'Finance','data'=>$data);
		render_template($layout);
		 }
		 elseif($book_name == 'INVOE')
		 {
		$data_id=$this->uri->segment(3);
		$data['vno']= $this->finance_model->invoice_edit($book_num);
		$data['sub_acc_list']= $this->finance_model->select_invo_acc('tbl_account');
			$data['cust']=$this->finance_model->select_customer('tbl_account');
			$data['msg']='';
			$data['errmsg']="";
			$layout=array('page'=>'form_invoice_edit','title'=>'Invoice','data'=>$data);
			render_template($layout);
		 }
		 elseif($book_name == 'SLA')
		 {
			 $data['salary']=$this->db->query("select tbl_transaction.*,tbl_account.ACC_NAME as st_name from tbl_transaction join tbl_account on tbl_transaction.SUB_ACC = tbl_account.ACC_ID where tbl_transaction.BOOK_NAME='SLA' and tbl_transaction.BOOK_NUMBER=$book_num and tbl_transaction.DEL_FLAG=1 and tbl_transaction.ACC_ID=42");
			 $data['msg']='';
		$data['errmsg']='';
		$layout = array('page' => 'form_salary_details','title'=>'Finance','data'=>$data);
		render_template($layout);
		 }
		 elseif($book_name == 'DRTN')
		 {
			 $cancel_book_no=$this->uri->segment(3);
		$data['cancel_details']=$this->db->query("select tbl_invoice_cancelation.*,tbl_invoice.BOOK_NUMBER as b_no from tbl_invoice_cancelation join tbl_invoice on tbl_invoice_cancelation.INVOICE_ID=tbl_invoice.INVOICE_ID where tbl_invoice_cancelation.DEL_FLAG=1 and tbl_invoice_cancelation.BOOK_NUM=$cancel_book_no");
		
		$val=$data['cancel_details']->row_array();
		
		 $book_num=$val['b_no'];
		$data['vno']= $this->finance_model->invoice_edit2($book_num);
		$data['msg']='';
		$data['errmsg']='';
		$layout = array('page' => 'form_cancelation_edit','title'=>'Finance','data'=>$data);
		render_template($layout);
		 }
		/* foreach($query->result() as $row)
		{
			echo $row->FIN_YEAR_ID."<br/>";
			echo $row->DATE_OF_TRANSACTION."<br/>";
			echo $row->DEBIT."<br/>";
			echo $row->TRANS_TYPE."<br>";
			echo $row->acc."</br>";
			echo $row->sub."<br/>";
			echo $row->FIRST_NAME.' '.$row->LAST_NAME."<br/>";
			echo $row->CREATED_ON;
			echo $row->MODIFIED_ON;
		} */
	}	
  function search_status()
  {
	  $status=$this->input->post('status');
	  $data['sub_status']=$this->finance_model->search_status_subaccount('tbl_account',$status);
	  $this->load->view('form_search_status',$data);
	  
  }  
	
}
?>