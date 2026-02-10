<?php
class Customer_payment extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
		$this->template->set_template('admin_template');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->model('customerfee_model');
	}
	
	function index()
	{
		
	    $data['cust']=$this->customerfee_model->select_customer('tbl_account');
		$data['msg']="";
		$this->form_validation->set_rules('txt_payment_date','Payment Date','required');
		if ($this->form_validation->run() == FALSE)
		{
			$layout = array('page' =>'form_fee_collection','title'=>'Customer Feecollection','data'=>$data);	
		    render_template($layout);	
			
		}
		else
		{
		
		$cust_id=$this->input->post('txt_cust_name');
		$pay_date=$this->input->post('txt_payment_date');
		$pay_date = strtotime($pay_date);
		$pay_date=date("Y-m-d",$pay_date);
		$due_date=$this->input->post('txt_due_date');
		$due_date = strtotime($due_date);
		$due_date=date("Y-m-d", $due_date);
		$amt=$this->input->post('txt_amount');
		$trans_type=$this->input->post('txt_trans_type');
		$chq_no=$this->input->post('txt_cheque_no');
		$chq_date=$this->input->post('txt_cheque_date');
		$chq_date = strtotime($chq_date);
		$chq_date=date("Y-m-d", $chq_date);
		$accnt_no=$this->input->post('txt_accnt_no');
		$bank=$this->input->post('txt_trans_type'); 
		$bank_id=$this->input->post('sel_bank'); 
		$entry_date=date('Y-m-d');
		$cust_name=$this->input->post('lbl_cust_name');
		//echo $book_number=$this->input->post('txt_buk_num');
		$temp_voc_num=$this->input->post('temp_voc_num');
		
		if($temp_voc_num!="")
			{
			$this->db->query("update tbl_payment set DEL_FLAG=0 where PAY_NUMBER=$temp_voc_num AND TYPE='CUSTOMER'");
			$pay_num=$temp_voc_num;
		$this->db->query("update tbl_transaction set DEL_FLAG=0 where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='PAYD'");
			$book_num=$temp_voc_num;
			}
			else
			{
		$query=$this->db->query("SELECT IFNULL(MAX(PAY_NUMBER), 1000)+1 AS PAY_NUMBER FROM tbl_payment WHERE TYPE='CUSTOMER' ");
		$row = $query->row_array();
        $pay_num=$row['PAY_NUMBER'];
		
		$query=$this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 1000)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='PAYD'");  
				 
		$res = $query->row_array();
        $book_num=$res['BOOK_NUMBER'];
			}
		
		  $pay_data=array('PAY_NUMBER'=>$pay_num,
		  'STUDENT_ID'=>$cust_id,
		  'DEL_FLAG'=>1,
		  'AMOUNT'=>$amt,
		  'TRANSACTION_TYPE'=>$trans_type,
		  'ENTRY_DATE'=> $entry_date,
		  'PAYMENT_DATE'=>$pay_date,
		  'DUE_DATE'=>$due_date,
		  'CHEQUE_NUMBER'=>$chq_no,
		  'CHEQUE_DATE'=>$chq_date,
		  'ACCOUNT_NUMBER'=>$accnt_no,
		  'BANK'=>$bank_id,
		  'REMARKS'=>'ADVANCE',
		  'TYPE'=>'CUSTOMER',
		  'FIN_YEAR_ID'=>2);
		  $this->customerfee_model->trans_ins('tbl_payment',$pay_data);
		  
		  $pay_id=$this->db->insert_id();
		  
		 /* if($temp_voc_num!="")
			{
		$this->db->query("update tbl_transaction set DEL_FLAG=0 where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='PAYD'");
			$book_num=$temp_voc_num;
			}
			else
			{
		$query=$this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 1000)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='PAYD'");  
				 
		$row = $query->row_array();
        $book_num=$row['BOOK_NUMBER'];
			}*/
		  
		 
		
		  if($trans_type=="cash")
		  {
               // $book_num=$row['BOOK_NUMBER'];
			    $remarks="Cash from"." ". $cust_name ." " ."(Customer Payment)";
			    $ceredt_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>47,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'CREDIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'PAYD',
					 'SUB_ACC'=>$cust_id,
					 'PAYMENT_ID'=>$pay_id
		            ); 
				$debit_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>39,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'DEBIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'PAYD',
					 'SUB_ACC'=>$cust_id,
					 'PAYMENT_ID'=>$pay_id
		            ); 
					  $this->customerfee_model->trans_ins('tbl_transaction',$ceredt_data);
					  $this->customerfee_model->trans_ins('tbl_transaction',$debit_data);
		  }
		  if($trans_type=="bank")
		  {
			    //$book_num=$row['BOOK_NUMBER'];
				$remarks=$cust_name ." " ."(Customer Payment) ".$chq_no;
			    $ceredt_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>47,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'CREDIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'PAYD',
					 'SUB_ACC'=>$cust_id,
					 'PAYMENT_ID'=>$pay_id
		            ); 
					
				$debit_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>$bank_id,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'DEBIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'PAYD',
					 'SUB_ACC'=>$cust_id,
					 'PAYMENT_ID'=>$pay_id
		            ); 
		        	  $this->customerfee_model->trans_ins('tbl_transaction',$ceredt_data);
					  $this->customerfee_model->trans_ins('tbl_transaction',$debit_data);
		  }
		 $data['msg']='Payment added successfully';
		 $layout = array('page' =>'form_fee_collection','title'=>'Customer Feecollection','data'=>$data);	
		 render_template($layout);	 
		}
		
	
	}
	function bank_details()
		{
			
		    $type=$this->input->post('type');
		    if($type=='bank')
		   {
			  
			   $res['bank']=$this->customerfee_model->select_acc_code('tbl_account');
			   $this->load->view('form_bank_details',$res);
		   }
		
		}
		
		function customer_details()
		{
			 echo $id=$this->input->post('type'); 
			 $data['details']=$this->customerfee_model->select_cust_details('tbl_account',$id);
			 $this->load->view('form_customer_details',$data);
		}
		
		function select_data()
		{
		//echo "Hai";
		$buk_num=$this->input->post('voc_no');
		$data['vno']= $this->customerfee_model->select_info('tbl_payment',$buk_num);
		$this->load->view('form_displaydata',$data);
		}
		
		function payment_stud_details()
		{
			
			$sid=$this->input->post('sname');
			$data['res']=$this->customerfee_model->stud_details('tbl_payment',$sid);
			$this->load->view('form_stud_details',$data);
			
		}
		
		
	function fee_edit()
	{
	    $id = $this->uri->segment(3);
		$data['fee_edit']=$this->customerfee_model->fee_edit_data('tbl_payment',$id);
		$data['parent_account']=$this->customerfee_model->selectAll('tbl_account');
		$data['trans_edit']=$this->customerfee_model->select_data('tbl_transaction',$id);
		$layout = array('page' => 'form_fee_edit','data'=>$data);
		render_template($layout);	

	}
	function fee_update()
	{
	    $book_num=$this->input->post('hdd_book_num');
	   // $name=$this->input->post('hdd_src_id');
	    $course=$this->input->post('hdd_sub_acc');
	    $pay_id=$this->input->post('txt_pay_id');
	    $pay_number=$this->input->post('txt_pay_number');
	    $stud_id=$this->input->post('txt_student_id');
		$stud_name=$this->input->post('txt_stud_name');
		$pay_date=$this->input->post('txt_payment_date');
		$pay_date = strtotime($pay_date);
		$pay_date=date("Y-m-d",$pay_date);
		 $hdd_due_date=$this->input->post('hdd_due_date');
		$due_date=$this->input->post('txt_due_date');
		$due_date = strtotime($due_date);
		 $due_date=date("Y-m-d", $due_date);
		$amt=$this->input->post('txt_amount');
		$trans_type=$this->input->post('txt_trans_type');
		$chq_no=$this->input->post('txt_cheque_no');
		$chq_date=$this->input->post('txt_cheque_date');
		$chq_date = strtotime($chq_date);
		$chq_date=date("Y-m-d", $chq_date);
		$accnt_no=$this->input->post('txt_accnt_no');
		$bank=$this->input->post('sel_bank');
		
		 
		$entry_date=date('Y-m-d');
		$this->db->query("update tbl_payment set DEL_FLAG=0 where PAY_ID=".$pay_id);
		$pay_update=array('PAY_NUMBER'=>$pay_number,
		  'STUDENT_ID'=>$stud_id,
		  'DEL_FLAG'=>1,
		  'AMOUNT'=>$amt,
		  'TRANSACTION_TYPE'=>$trans_type,
		  'ENTRY_DATE'=> $entry_date,
		  'PAYMENT_DATE'=>$pay_date,
		  'DUE_DATE'=>$due_date,
		  'CHEQUE_NUMBER'=>$chq_no,
		  'CHEQUE_DATE'=>$chq_date,
		  'ACCOUNT_NUMBER'=>$accnt_no,
		  'BANK'=>$bank,
		  'REMARKS'=>'ADVANCE',
		  'TYPE'=>'STD',
		  'FIN_YEAR_ID'=>2);
	    $this->customerfee_model->trans_ins('tbl_payment',$pay_update);
	    $ins_pay_id=$this->db->insert_id();
		$this->db->query("update tbl_transaction set DEL_FLAG=0 where PAYMENT_ID=$pay_id AND BOOK_NAME='PAY'");
		 
		if($trans_type=="cash")
		  {
			   $remarks="Cash from"." ". $stud_name ." " ."(Course Fee)";
			    $ceredt_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>38,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'CREDIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'PAY',
					 'SRC_ID'=>$stud_id,
					 'SUB_ACC'=>$course,
					 'PAYMENT_ID'=>$ins_pay_id
		            ); 
					
				$debit_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>39,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'DEBIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'PAY',
					 'SRC_ID'=>$stud_id,
					 'SUB_ACC'=>$course,
					 'PAYMENT_ID'=>$ins_pay_id
		            ); 
					  $this->customerfee_model->trans_ins('tbl_transaction',$ceredt_data);
					  $this->customerfee_model->trans_ins('tbl_transaction',$debit_data);
		  }
		  
		  if($trans_type=="bank")
		  {
							
				$query=$this->db->query("SELECT ACC_ID FROM tbl_account where ACC_CODE=$bank");  
				$row = $query->row_array();
				$bank_accid=$row['ACC_ID'];
			    $remarks=$stud_name ." " ."(Course Fee) ".$chq_no;
			    $ceredt_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>38,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'CREDIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'PAY',
					 'SRC_ID'=>$stud_id,
					 'SUB_ACC'=>$course,
					 'PAYMENT_ID'=>$ins_pay_id
		            ); 
					
				$debit_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>$bank_accid,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'DEBIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'PAY',
					 'SRC_ID'=>$stud_id,
					 'SUB_ACC'=>$course,
					 'PAYMENT_ID'=>$ins_pay_id
		            ); 
		        	  $this->fee_model->trans_ins('tbl_transaction',$ceredt_data);
					  $this->fee_model->trans_ins('tbl_transaction',$debit_data);
		  }
		  
		if($hdd_due_date!=$due_date)
		  {
			$this->db->query("update tbl_student set DUE_DATE='$due_date' where STUDENT_ID='$stud_id'");  
		  }
	//$layout = array('page' =>'form_fee_collection','title'=>'Feecollection');	
   // render_template($layout);	
    $this->index();
	}
	
	
	
}
?>