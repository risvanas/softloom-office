<?php
class Feecollection extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
		$this->template->set_template('admin_template');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->model('fee_model');
	}
	
	function index()
	{
		
	    $data['parent_account']=$this->fee_model->selectAll('tbl_account');
	    $data['r']=$this->fee_model->select_st_name('tbl_student');
	    $data['s']=$this->fee_model->select_acc_type('tbl_account');
		$data['msg']="";
		$this->form_validation->set_rules('txt_payment_date','Payment Date','required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$layout = array('page' => 'form_fee_collection','title'=>'Feecollection','data'=>$data);	
		    render_template($layout);	
			
		}
		else
		{
			 $pay_date=$this->input->post('txt_payment_date');
			 $this->load->library('../controllers/lockdate');
    		 $this->lockdate->index($pay_date);
			 
		  $query=$this->db->query("SELECT IFNULL(MAX(PAY_NUMBER), 1000)+1 AS PAY_NUMBER
FROM tbl_payment WHERE TYPE='STD' ");
		
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
		//$query=$this->db->query("SELECT NAME FROM tbl_student where STUDENT_ID=$name ");
		//$row = $query->row_array();
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
		  'REMARKS'=>'ADVANCE',
		  'TYPE'=>'STD',
		  'FIN_YEAR_ID'=>2);
		  $this->fee_model->trans_ins('tbl_payment',$pay_data);
		$pay_id=$this->db->insert_id();
		
		$query=$this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 1000)+1 AS BOOK_NUMBER
FROM tbl_transaction WHERE BOOK_NAME='PAY'");  
				 
		$row = $query->row_array();
					   
		  if($trans_type=="cash")
		  {
                $book_num=$row['BOOK_NUMBER'];
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
					 'SRC_ID'=>$name,
					 'SUB_ACC'=>$course,
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
					 'BOOK_NAME'=>'PAY',
					 'SRC_ID'=>$name,
					 'PAYMENT_ID'=>$pay_id
		            ); 
					
					  $this->fee_model->trans_ins('tbl_transaction',$ceredt_data);
					  $this->fee_model->trans_ins('tbl_transaction',$debit_data);
			  
		  }
		  
		  if($trans_type=="bank")
		  {
			    $book_num=$row['BOOK_NUMBER'];
		         //$query=$this->db->query("SELECT ACC_ID FROM tbl_account where ACC_CODE=$bank");  
				//$row = $query->row_array();
				//$bank_accid=$row['ACC_ID'];
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
					 'SRC_ID'=>$name,
					 'SUB_ACC'=>$course,
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
					 'BOOK_NAME'=>'PAY',
					 'SRC_ID'=>$name,
					 'PAYMENT_ID'=>$pay_id
		            ); 
		        	  $this->fee_model->trans_ins('tbl_transaction',$ceredt_data);
					  $this->fee_model->trans_ins('tbl_transaction',$debit_data);
		  }
		 
		  $this->db->query("UPDATE tbl_student SET `DUE_DATE`='$due_date' where DEL_FLAG='1' AND STUDENT_ID='$name'");  
		  $data['msg']='Payment added successfully';
		 $layout = array('page' =>'form_fee_collection','title'=>'Feecollection','data'=>$data);	
		 render_template($layout);	 
		}
	}
	
	function bank_details()
		{
			
		    $type=$this->input->post('type');
		    if($type=='bank')
		   {
			  
			   $res['bank']=$this->fee_model->select_acc_code('tbl_account');
			   $this->load->view('form_bank_details',$res);
		   }
		
		}
		
		function payment_stud_details()
		{
			
			$sid=$this->input->post('sname');
			$data['res']=$this->fee_model->stud_details('tbl_payment',$sid);
			$this->load->view('form_stud_details',$data);
			
		}
		
		
		function student_details()
		{
		    $sid=$this->input->post('sname');
			
			$data['rs']=$this->fee_model->select_course('tbl_student',$sid);
			$data['res']=$this->fee_model->stud_details('tbl_payment',$sid);
			$this->load->view('form_stud_details',$data);
			
		}
		
		function student_names()
		{
		    $cname=$this->input->post('cname');
			$this->load->model('fee_model');
			$data['name']=$this->fee_model->select_stud_name('tbl_student',$cname);
			$this->load->view('form_stud_name',$data);
		}
	
	function fee_edit()
	{
	    echo $id = $this->uri->segment(3);
		$data['fee_edit']=$this->fee_model->fee_edit_data('tbl_payment',$id);
		$data['parent_account']=$this->fee_model->selectAll('tbl_account');
		$data['trans_edit']=$this->fee_model->select_data('tbl_transaction',$id);
		$layout = array('page' => 'form_fee_edit','data'=>$data);
		render_template($layout);	

	}
	function fee_update()
	{
	    
		
			 $pay_date=$this->input->post('txt_payment_date');
			 $this->load->library('../controllers/lockdate');
    		 $this->lockdate->index($pay_date);
			 
		$book_num=$this->input->post('hdd_book_num');
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
		 $data['parent_account']=$this->fee_model->selectAll('tbl_account');
	     $data['r']=$this->fee_model->select_st_name('tbl_student');
	     $data['s']=$this->fee_model->select_acc_type('tbl_account');
		 $data['msg']='';
		 $layout = array('page' =>'form_fee_collection','title'=>'Feecollection','data'=>$data);	
		 render_template($layout);	 
		}
		if($pay_id !="")
		{
		$this->db->query("update tbl_payment set DEL_FLAG=0 where TYPE='STD' AND PAY_ID=".$pay_id );
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
	    $this->fee_model->trans_ins('tbl_payment',$pay_update);
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
					  $this->fee_model->trans_ins('tbl_transaction',$ceredt_data);
					  $this->fee_model->trans_ins('tbl_transaction',$debit_data);
		  }
		  
		  if($trans_type=="bank")
		  {
							
				//$query=$this->db->query("SELECT ACC_ID FROM tbl_account where ACC_CODE=$bank");  
				//$row = $query->row_array();
				//$bank_accid=$row['ACC_ID'];
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
					 'ACC_ID'=>$bank,
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
		  
	 	 $data['parent_account']=$this->fee_model->selectAll('tbl_account');
	     $data['r']=$this->fee_model->select_st_name('tbl_student');
	     $data['s']=$this->fee_model->select_acc_type('tbl_account');
		 $data['msg']='Payment added successfully';
		 $layout = array('page' =>'form_fee_collection','title'=>'Feecollection','data'=>$data);	
		 render_template($layout);	 
   
	}
	}
	
	function fee_delete()
	{
		echo $id = $this->uri->segment(3);
		$data=array('DEL_FLAG'=>'0');
		$this->fee_model->delete_data('tbl_payment',$data,$id);
		$this->fee_model->delete_data1('tbl_transaction',$data,$id);
		
		$data['parent_account']=$this->fee_model->selectAll('tbl_account');
	     $data['r']=$this->fee_model->select_st_name('tbl_student');
	     $data['s']=$this->fee_model->select_acc_type('tbl_account');
		 $data['msg']='Delete successfully';
		 $layout = array('page' =>'form_fee_collection','title'=>'Feecollection','data'=>$data);	
		 render_template($layout);	 
		
	}
	function coursecompletion()
	{
		$this->form_validation->set_rules('txt_completed_date','Completed Date','required');
		echo $student_id=$this->uri->segment(3);
		if ($this->form_validation->run() == FALSE)
		{
			echo $student_id=$this->uri->segment(3);
			
			 $data['parent_account']=$this->fee_model->selectAll('tbl_account');
			 $data['student_account']=$this->fee_model->course_com_student('tbl_student',$student_id);
			 $layout = array('page' =>'form_course_completion','title'=>'Course Completion','data'=>$data);	
		     render_template($layout);	
		}
		else
		{
			echo $stud_id=$this->input->post('hdd_stud_name');
			echo "<br>";
		 	echo $course_id=$this->input->post('hdd_course');
			echo "<br>";
			 $completed_date=$this->input->post('txt_completed_date');
			 $completed_date = strtotime($completed_date);
			 $completed_date=date("Y-m-d",$completed_date);
			 $this->db->query("update tbl_student set COMPLETED_DATE='$completed_date',STATUS='8' where STUDENT_ID='$stud_id' AND COURSE='$course_id'");  
		//header("location:student/student_list");
		redirect('http://wesmosis.softloom.com/student/student_list');
		}
	}
	
	function completion_details()
		{
		    $sid=$this->input->post('sname');
			$data['stud']=$this->fee_model->select_course('tbl_student',$sid);
			$data['res']=$this->fee_model->stud_details('tbl_payment',$sid);
			$this->load->view('form_completion_details',$data);
		}
}
?>