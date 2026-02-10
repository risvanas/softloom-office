<?php
class Training_refund extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
		$this->template->set_template('admin_template');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->model('trainingrefund_model');
	}
	
	function index()
	{
		$menu_id=43;
         $this->load->library('../controllers/permition_checker');
	    $data['parent_account']=$this->trainingrefund_model->selectAll('tbl_account');
	    $data['r']=$this->trainingrefund_model->select_st_name('tbl_student');
	    $data['s']=$this->trainingrefund_model->select_acc_type('tbl_account');
		$data['msg']="";
		$data['errmsg']="";
		$this->form_validation->set_rules('txt_payment_date','Payment Date','required');
		
		if ($this->form_validation->run() == FALSE)
		{
			 $this->permition_checker->permition_viewprocess($menu_id);
			$layout = array('page' => 'form_training_refund','title'=>'Training Refund','data'=>$data);	
		    render_template($layout);	
			
		}
		else
		{
			$this->permition_checker->permition_addprocess($menu_id);
			 //$pay_date=$this->input->post('txt_payment_date');
			 //$this->load->library('../controllers/lockdate');
    		// $this->lockdate->index($pay_date);
			 $sess_array=$this->session->userdata('logged_in');
				 $year_code=$sess_array['accounting_year'];
		  $query=$this->db->query("SELECT IFNULL(MAX(PAY_NUMBER), 1000)+1 AS PAY_NUMBER
FROM tbl_payment WHERE TYPE='PAYRFD' ");
		
		$row = $query->row_array();
        $pay_num=$row['PAY_NUMBER'];
		
		$name=$this->input->post('txt_stud_name');
		$course=$this->input->post('txt_course');
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
		$bank_id=$this->input->post('sel_bank'); 
		$entry_date=date('Y-m-d');
		$sess_array=$this->session->userdata('logged_in');
			   $create_by=$sess_array['user_id'];
			   $this->load->library('../controllers/lockdate');
			   $location_details=$this->lockdate->location_details();
			   $create_on=gmdate("Y-m-d H:i:s");
		//$query=$this->db->query("SELECT NAME FROM tbl_student where STUDENT_ID=$name ");
		//$row = $query->row_array();
		$this->load->library('../controllers/lockdate');
    		 $this->lockdate->index($pay_date);
			 $check_status=$this->lockdate->check_date($pay_date);
			 $message_display=$this->lockdate->message_val($pay_date,$check_status);
			 if($check_status == 'true')
			 {
				$data['errmsg']=$message_display;
				 $data['msg']='';
		  $layout = array('page' =>'form_training_refund','title'=>'Training Refund','data'=>$data);	
		  render_template($layout);	
    			return FALSE;
			 }
		$stud_name=$this->input->post('lbl_stud_name');
		 
		  $pay_data=array('PAY_NUMBER'=>$pay_num,
		  'STUDENT_ID'=>$name,
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
		  'REMARKS'=>'REFUND', 
		  'TYPE'=>'PAYRFD',
		  'FIN_YEAR_ID'=>2,
		  'ACC_YEAR_CODE'=>$year_code,
		  'CREATED_BY'=>$create_by,
								'CREATED_ON'=>$create_on,
								'LOCATION_DETAILS'=>$location_details);
		  $this->trainingrefund_model->trans_ins('tbl_payment',$pay_data);
		  $pay_id=$this->db->insert_id();
		
		$query=$this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 1000)+1 AS BOOK_NUMBER
FROM tbl_transaction WHERE BOOK_NAME='RFD'");  
				 
		$row = $query->row_array();
					   
		  if($trans_type=="cash")
		  {
                $book_num=$row['BOOK_NUMBER'];
			    $remarks="Cash Refund"." ". $stud_name ." " ."(Course Fee)";
			    $ceredt_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>38,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'DEBIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'RFD',
					 'SRC_ID'=>$name,
					 'SUB_ACC'=>$course,
					 'PAYMENT_ID'=>$pay_id,
		            'ACC_YEAR_CODE'=>$year_code,
					'CREATED_BY'=>$create_by,
								'CREATED_ON'=>$create_on,
								'LOCATION_DETAILS'=>$location_details); 
					
				$debit_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>39,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'CREDIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'RFD',
					 'SRC_ID'=>$name,
					 'PAYMENT_ID'=>$pay_id,
		            'ACC_YEAR_CODE'=>$year_code,
					'CREATED_BY'=>$create_by,
								'CREATED_ON'=>$create_on,
								'LOCATION_DETAILS'=>$location_details); 
					
					  $this->trainingrefund_model->trans_ins('tbl_transaction',$ceredt_data);
					  $this->trainingrefund_model->trans_ins('tbl_transaction',$debit_data);
			  
		  }
		  
		  if($trans_type=="bank")
		  {
			  
			    $book_num=$row['BOOK_NUMBER'];
		        
			    $remarks=$stud_name ." " ."(Fee Refund) ".$chq_no;
			    $ceredt_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>38,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'DEBIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'RFD',
					 'SRC_ID'=>$name,
					 'SUB_ACC'=>$course,
					 'PAYMENT_ID'=>$pay_id,
		            'ACC_YEAR_CODE'=>$year_code,
					'CREATED_BY'=>$create_by,
								'CREATED_ON'=>$create_on,
								'LOCATION_DETAILS'=>$location_details); 
					
				$debit_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>$bank_id,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'CREDIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'RFD',
					 'SRC_ID'=>$name,
					 'PAYMENT_ID'=>$pay_id,
		            'ACC_YEAR_CODE'=>$year_code,
					'CREATED_BY'=>$create_by,
								'CREATED_ON'=>$create_on,
								'LOCATION_DETAILS'=>$location_details); 
		        	  $this->trainingrefund_model->trans_ins('tbl_transaction',$ceredt_data);
					  $this->trainingrefund_model->trans_ins('tbl_transaction',$debit_data);
		  }
		 
		
		   $data['msg']='Refund added successfully';
		   $data['errmsg']="";
		  $layout = array('page' =>'form_training_refund','title'=>'Training Refund','data'=>$data);	
		  render_template($layout);	 
		}
	}
	
	function bank_details()
		{
			
		    $type=$this->input->post('type');
		    if($type=='bank')
		   {
			  
			   $res['bank']=$this->trainingrefund_model->select_acc_code('tbl_account');
			   $this->load->view('form_bank_details',$res);
		   }
		
		}
		
		function payment_stud_details()
		{
			
			$sid=$this->input->post('sname');
			$data['res']=$this->trainingrefund_model->stud_details('tbl_payment',$sid);
			$this->load->view('form_stud_details',$data);
			
		}
		
		
		function student_details()
		{
		    $sid=$this->input->post('sname');
			$data['rs']=$this->trainingrefund_model->select_course('tbl_student',$sid);
			$data['res']=$this->trainingrefund_model->stud_details('tbl_transaction',$sid);
			
			$this->load->view('form_stud_details',$data);
			
		}
		
		function student_names()
		{
		    $cname=$this->input->post('cname');
			$data['name']=$this->trainingrefund_model->select_stud_name('tbl_student',$cname);
			$this->load->view('form_stud_name',$data);
		}
	
	function fee_edit()
	{
	    echo $id = $this->uri->segment(3);
		$data['fee_edit']=$this->trainingrefund_model->fee_edit_data('tbl_payment',$id);
		$data['parent_account']=$this->trainingrefund_model->selectAll('tbl_account');
		$data['trans_edit']=$this->trainingrefund_model->select_data('tbl_transaction',$id);
		$layout = array('page' => 'form_fee_edit','data'=>$data);
		render_template($layout);	

	}
	
		function fee_update()
				{
					$sess_array=$this->session->userdata('logged_in');
				 $year_code=$sess_array['accounting_year'];
			 $pay_date=$this->input->post('txt_payment_date');
			 $this->load->library('../controllers/lockdate');
    		 $this->lockdate->index($pay_date);
			 $check_status=$this->lockdate->check_date($pay_date);
			  $message_display=$this->lockdate->message_val($pay_date,$check_status);
			 if($check_status == 'true')
			 {
				 $data['parent_account']=$this->trainingrefund_model->selectAll('tbl_account');
	     $data['r']=$this->trainingrefund_model->select_st_name('tbl_student');
	     $data['s']=$this->trainingrefund_model->select_acc_type('tbl_account');
		 $data['msg']='';
		 $data['errmsg']=$message_display;
		 $layout = array('page' =>'form_training_refund','title'=>'Training Refund','data'=>$data);	
		 render_template($layout);	 
    			return FALSE;
			 }
			 
		 $book_num=$this->input->post('hdd_book_num');
		$query2=$this->db->query("select ACC_YEAR_CODE from tbl_transaction where PAYMENT_ID=$book_num AND BOOK_NAME='RFD' AND DEL_FLAG=1");
               	$val2=$query2->row_array();
                $acc_year=$val2['ACC_YEAR_CODE']; 
                if($year_code == $acc_year)	
				{
					$data['parent_account']=$this->trainingrefund_model->selectAll('tbl_account');
	     $data['r']=$this->trainingrefund_model->select_st_name('tbl_student');
	     $data['s']=$this->trainingrefund_model->select_acc_type('tbl_account');
		 $data['msg']='';
		 $data['errmsg']="Accounting Year Do not Match";
		 $layout = array('page' =>'form_training_refund','title'=>'Training Refund','data'=>$data);	
		 render_template($layout);	 
    			return FALSE;
				}
	  	$stud_id=$this->input->post('hdd_src_id');
	    $course=$this->input->post('hdd_sub_acc');
	    $pay_id=$this->input->post('txt_pay_id');
	    $pay_number=$this->input->post('txt_pay_number');
		$stud_name=$this->input->post('txt_stud_name');
		//$pay_date=$this->input->post('txt_payment_date');
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
		if($pay_id=="")
		{
		 $data['parent_account']=$this->trainingrefund_model->selectAll('tbl_account');
	     $data['r']=$this->trainingrefund_model->select_st_name('tbl_student');
	     $data['s']=$this->trainingrefund_model->select_acc_type('tbl_account');
		 $data['msg']='';
		 $data['errmsg']="";
		 $layout = array('page' =>'form_training_refund','title'=>'Training Refund','data'=>$data);	
		 render_template($layout);	 
		}
		$sess_array=$this->session->userdata('logged_in');
			   $modified_by=$sess_array['user_id'];
			   $this->load->library('../controllers/lockdate');
			   $location_details=$this->lockdate->location_details();
			   $modified_on=gmdate("Y-m-d H:i:s");
		if($pay_id !="")
		{
		$this->db->query("update tbl_payment set DEL_FLAG=0,MODIFIED_BY=$modified_by,MODIFIED_ON='$modified_on',LOCATION_DETAILS='$location_details' where TYPE='PAYRFD' AND PAY_ID=".$pay_id );
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
		  'REMARKS'=>'REFUND',  
		  'TYPE'=>'PAYRFD',
		  'FIN_YEAR_ID'=>2,
		  'ACC_YEAR_CODE'=>$year_code,
		  'MODIFIED_BY'=>$modified_by,
								'MODIFIED_ON'=>$modified_on,
								'LOCATION_DETAILS'=>$location_details);
	    $this->trainingrefund_model->trans_ins('tbl_payment',$pay_update);
	    $ins_pay_id=$this->db->insert_id();
		$this->db->query("update tbl_transaction set DEL_FLAG=0,MODIFIED_BY=$modified_by,MODIFIED_ON='$modified_on',LOCATION_DETAILS='$location_details' where PAYMENT_ID=$pay_id AND BOOK_NAME='RFD'");
		 
		if($trans_type=="cash")
		  {
			   $remarks="Cash Refund"." ". $stud_name ." " ."(Course Fee)";
			    $ceredt_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>38,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'DEBIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'RFD',
					 'SRC_ID'=>$stud_id,
					 'SUB_ACC'=>$course,
					 'PAYMENT_ID'=>$ins_pay_id,
		            'ACC_YEAR_CODE'=>$year_code,
					'MODIFIED_BY'=>$modified_by,
								'MODIFIED_ON'=>$modified_on,
								'LOCATION_DETAILS'=>$location_details); 
					
				$debit_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>39,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'CREDIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'RFD',
					 'SRC_ID'=>$stud_id,
					 'PAYMENT_ID'=>$ins_pay_id,
		            'ACC_YEAR_CODE'=>$year_code,
					'MODIFIED_BY'=>$modified_by,
								'MODIFIED_ON'=>$modified_on,
								'LOCATION_DETAILS'=>$location_details); 
					  $this->trainingrefund_model->trans_ins('tbl_transaction',$ceredt_data);
					  $this->trainingrefund_model->trans_ins('tbl_transaction',$debit_data);
		  }
		  
		  if($trans_type=="bank")
		  {
							
				
			    $remarks=$stud_name ." " ."(Fee Refund) ".$chq_no;
			    $ceredt_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>38,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'DEBIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'RFD',
					 'SRC_ID'=>$stud_id,
					 'SUB_ACC'=>$course,
					 'PAYMENT_ID'=>$ins_pay_id,
		            'ACC_YEAR_CODE'=>$year_code,
					'MODIFIED_BY'=>$modified_by,
								'MODIFIED_ON'=>$modified_on,
								'LOCATION_DETAILS'=>$location_details); 
					
				$debit_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>$bank,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'CREDIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'TRANS_TYPE'=>$trans_type,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'RFD',
					 'SRC_ID'=>$stud_id,
					 'PAYMENT_ID'=>$ins_pay_id,
		            'ACC_YEAR_CODE'=>$year_code,
					'MODIFIED_BY'=>$modified_by,
								'MODIFIED_ON'=>$modified_on,
								'LOCATION_DETAILS'=>$location_details); 
		        	  $this->trainingrefund_model->trans_ins('tbl_transaction',$ceredt_data);
					  $this->trainingrefund_model->trans_ins('tbl_transaction',$debit_data);
		  }
		  
		
	 	 $data['parent_account']=$this->trainingrefund_model->selectAll('tbl_account');
	     $data['r']=$this->trainingrefund_model->select_st_name('tbl_student');
	     $data['s']=$this->trainingrefund_model->select_acc_type('tbl_account');
		 $data['msg']='Refund added successfully';
		 $data['errmsg']="";
		 $layout = array('page' =>'form_training_refund','title'=>'Training Refund','data'=>$data);	
		 render_template($layout);	 
   
	}
	
	
	}
	
	function fee_delete()
	{
		$sess_array=$this->session->userdata('logged_in');
				  $year_code=$sess_array['accounting_year'];
		 $id = $this->uri->segment(3);
		$query2=$this->db->query("select ACC_YEAR_CODE,DATE_OF_TRANSACTION from tbl_transaction where PAYMENT_ID=$id AND BOOK_NAME='RFD' AND DEL_FLAG=1");
               	$val2=$query2->row_array();
                $acc_year=$val2['ACC_YEAR_CODE']; 
				$this->load->library('../controllers/lockdate');
				 $voucher_date=$val2['DATE_OF_TRANSACTION'];
			 $check_status=$this->lockdate->check_date($voucher_date);
			 $message_display=$this->lockdate->message_val($voucher_date,$check_status);
                if($year_code == $acc_year && $check_status == 'false')	
				{
					$sess_array=$this->session->userdata('logged_in');
			   $deleted_by=$sess_array['user_id'];
			   $this->load->library('../controllers/lockdate');
			   $location_details=$this->lockdate->location_details();
			   $deleted_on=gmdate("Y-m-d H:i:s");
		$data=array('DEL_FLAG'=>'0',
		             'DELETED_BY'=>$deleted_by,
					'DELETED_ON'=>$deleted_on,
					'LOCATION_DETAILS'=>$location_details);
		$this->trainingrefund_model->delete_data('tbl_payment',$data,$id);
		$this->trainingrefund_model->delete_data1('tbl_transaction',$data,$id);
		
		$data['parent_account']=$this->trainingrefund_model->selectAll('tbl_account');
	     $data['r']=$this->trainingrefund_model->select_st_name('tbl_student');
	     $data['s']=$this->trainingrefund_model->select_acc_type('tbl_account');
		 $data['msg']='Delete successfully';
		 $data['errmsg']="";
		 $layout = array('page' =>'form_training_refund','title'=>'Training Refund','data'=>$data);	
		 render_template($layout);	 
				}
				else
				{
					$data['parent_account']=$this->trainingrefund_model->selectAll('tbl_account');
	     $data['r']=$this->trainingrefund_model->select_st_name('tbl_student');
	     $data['s']=$this->trainingrefund_model->select_acc_type('tbl_account');
		 $data['msg']='';
		 $data['errmsg']=$message_display;
		 $layout = array('page' =>'form_training_refund','title'=>'Training Refund','data'=>$data);	
		 render_template($layout);	 
    			return FALSE;
				}
		
	}
	
	
}
?>