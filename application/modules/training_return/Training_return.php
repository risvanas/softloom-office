<?php
class Training_return extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
		$this->template->set_template('admin_template');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->model('training_model');
	}
	
	function index()
	{
		
	    $data['parent_account']=$this->training_model->selectAll('tbl_account');
	    $data['r']=$this->training_model->select_st_name('tbl_student');
	    $data['s']=$this->training_model->select_acc_type('tbl_account');
		$data['status']=$this->training_model->select_status('tbl_status');
		$data['msg']="";
		$data['errmsg']="";
		//$this->form_validation->set_rules('txt_payment_date','Payment Date','required');
		$this->form_validation->set_rules('lbl_stud_name','Student Name','required');
		if ($this->form_validation->run() == FALSE)
		{
			$layout = array('page' => 'form_training_return','title'=>'Training Return','data'=>$data);	
		    render_template($layout);	
			
		}
		else
		{
			//$pay_date=$this->input->post('txt_payment_date');
			 //$this->load->library('../controllers/lockdate');
    		 //$this->lockdate->index($pay_date);
			 
		 $sess_array=$this->session->userdata('logged_in');
				 $year_code=$sess_array['accounting_year'];
		$name=$this->input->post('txt_stud_name');
		$course=$this->input->post('txt_course');
		$pay_date=$this->input->post('txt_payment_date');
		$pay_date = strtotime($pay_date);
		$pay_date=date("Y-m-d",$pay_date);
		$due_date=$this->input->post('txt_due_date');
		$due_date = strtotime($due_date);
		$due_date=date("Y-m-d", $due_date);
		$amt=$this->input->post('txt_amount');
		$status=$this->input->post('status'); 
		$entry_date=date('Y-m-d');
		$stud_name=$this->input->post('lbl_stud_name');
		$temp_voc_num=$this->input->post('temp_voc_num');
		$course_name=$this->input->post('lbl_course_name');
		$this->load->library('../controllers/lockdate');
    		 $this->lockdate->index($pay_date);
			 $check_status=$this->lockdate->check_date($pay_date);
			 $message_display=$this->lockdate->message_val($pay_date,$check_status);
			 if($check_status == 'true')
			 {  
		      $data['msg']='';
		      $data['errmsg']=$message_display;
		       $layout = array('page' =>'form_training_return','title'=>'Training Return','data'=>$data);	
		       render_template($layout);	
			   return FALSE;
			 }
		 if($temp_voc_num!="")
		 {
			 $query2=$this->db->query("select ACC_YEAR_CODE from tbl_transaction where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='SALRTN' AND DEL_FLAG=1");
               	$val2=$query2->row_array();
                $acc_year=$val2['ACC_YEAR_CODE']; 
                if($year_code == $acc_year)	
				{
			  $book_num=$temp_voc_num;
			 $name=$this->input->post('temp_name'); 
			 $sess_array=$this->session->userdata('logged_in');
			   $modified_by=$sess_array['user_id'];
			   $this->load->library('../controllers/lockdate');
			   $location_details=$this->lockdate->location_details();
			   $modified_on=gmdate("Y-m-d H:i:s");
			 $this->db->query("update tbl_transaction set DEL_FLAG=0,MODIFIED_BY=$modified_by,MODIFIED_ON='$modified_on',LOCATION_DETAILS='$location_details' where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='SALRTN'");
				}
				else
				{   
		      $data['msg']='';
		      $data['errmsg']="Accounting Year Do not Match";
		       $layout = array('page' =>'form_training_return','title'=>'Training Return','data'=>$data);	
		       render_template($layout);	
			   return FALSE;
				}
		 }
		 else
		 {
		 
		$query=$this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 1000)+1 AS BOOK_NUMBER
FROM tbl_transaction WHERE BOOK_NAME='SALRTN'");  
				 $sess_array=$this->session->userdata('logged_in');
			   $create_by=$sess_array['user_id'];
			   $this->load->library('../controllers/lockdate');
			   $location_details=$this->lockdate->location_details();
			   $create_on=gmdate("Y-m-d H:i:s");
		        $row = $query->row_array();
                $book_num=$row['BOOK_NUMBER'];
		 }
		 
			    $remarks=$course_name." Course Cancel "." - ". $stud_name ;
			    $ceredt_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>38,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'CREDIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'SALRTN',
					 'SRC_ID'=>$name,
					 'SUB_ACC'=>$course,
					 'DISCONTINUE_DATE'=>$pay_date,
		            'ACC_YEAR_CODE'=>$year_code,
					'CREATED_BY'=>$create_by,
								'CREATED_ON'=>$create_on,
								'LOCATION_DETAILS'=>$location_details); 
					
				$debit_data=array('FIN_YEAR_ID'=>2,
					 'ACC_ID'=>107,
					 'DATE_OF_TRANSACTION'=>$pay_date,
					 'DEBIT'=>$amt,
					 'REMARKS'=>$remarks,
					 'DEL_FLAG'=>1,
					 'BOOK_NUMBER'=>$book_num,
					 'BOOK_NAME'=>'SALRTN',
					 'SRC_ID'=>$name,
					 'SUB_ACC'=>$course,
					 'DISCONTINUE_DATE'=>$pay_date,
		            'ACC_YEAR_CODE'=>$year_code,
					'CREATED_BY'=>$create_by,
								'CREATED_ON'=>$create_on,
								'LOCATION_DETAILS'=>$location_details); 
					
					  $this->training_model->trans_ins('tbl_transaction',$ceredt_data);
					  $this->training_model->trans_ins('tbl_transaction',$debit_data);
			  
		
		  $this->db->query("UPDATE tbl_student SET STATUS='$status' where DEL_FLAG='1' AND STUDENT_ID='$name'");   
		  $data['msg']='Payment added successfully';
		  $data['errmsg']="";
		  $layout = array('page' =>'form_training_return','title'=>'Training Return','data'=>$data);	
		  render_template($layout);	 
		}
	}
	
	
		
		function payment_stud_details()
		{
			
			$sid=$this->input->post('sname');
			$data['res']=$this->training_model->stud_details('tbl_payment',$sid);
			$this->load->view('form_stud_details',$data);
			
		}
		function select_data()
	{
		
		 $buk_num=$this->input->post('voc_no');
		 $data['vno']= $this->training_model->select_info('tbl_transaction',$buk_num);
		 $this->load->view('form_displayData',$data);
	}

		
		function student_details()
		{
		    $sid=$this->input->post('sname');
			$data['rs']=$this->training_model->select_course('tbl_student',$sid);
			$data['res']=$this->training_model->stud_details('tbl_transaction',$sid);
			$this->load->view('form_stud_details',$data);
			
		}
		
		function student_names()
		{
		    $cname=$this->input->post('cname');
			$data['name']=$this->training_model->select_stud_name('tbl_student',$cname);
			$this->load->view('form_stud_name',$data);
		}
	
	
	
	function fee_delete()
	{
		$sess_array=$this->session->userdata('logged_in');
				 $year_code=$sess_array['accounting_year'];
		 $id = $this->uri->segment(3);
		$query2=$this->db->query("select ACC_YEAR_CODE,DATE_OF_TRANSACTION from tbl_transaction where BOOK_NUMBER=$id AND BOOK_NAME='SALRTN' AND DEL_FLAG=1");
               	$val2=$query2->row_array();
                $acc_year=$val2['ACC_YEAR_CODE']; 
				$this->load->library('../controllers/lockdate');
				$voucher_date=$val2['DATE_OF_TRANSACTION'];
			 $check_status=$this->lockdate->check_date($voucher_date);
			 $message_display=$this->lockdate->message_val($voucher_date,$check_status);
			 if($message_display == '')
			 {
				 $message_display='Accounting Year Do not match';
			 }
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
		//$this->training_model->delete_data('tbl_payment',$data,$id);
		$this->training_model->delete_data1('tbl_transaction',$data,$id);
		
		$data['parent_account']=$this->training_model->selectAll('tbl_account');
	     $data['r']=$this->training_model->select_st_name('tbl_student');
	     $data['s']=$this->training_model->select_acc_type('tbl_account');
		 $data['msg']='Delete successfully';
		 $data['errmsg']="";
		 $layout = array('page' =>'form_training_return','title'=>'Training Return','data'=>$data);	
		 render_template($layout);	 
		}
				else
				{
					$data['parent_account']=$this->training_model->selectAll('tbl_account');
	    $data['r']=$this->training_model->select_st_name('tbl_student');
	    $data['s']=$this->training_model->select_acc_type('tbl_account');
		$data['status']=$this->training_model->select_status('tbl_status');
					$data['msg']='';
		      $data['errmsg']=$message_display;
		       $layout = array('page' =>'form_training_return','title'=>'Training Return','data'=>$data);	
		       render_template($layout);	
			   return FALSE;
				}
	}
	
		function delete_data()
	     {
			 $sess_array=$this->session->userdata('logged_in');
				 $year_code=$sess_array['accounting_year'];
		 echo $buk_num= $this->uri->segment(3);
		$query2=$this->db->query("select ACC_YEAR_CODE,DATE_OF_TRANSACTION from tbl_transaction where BOOK_NUMBER=$buk_num AND BOOK_NAME='SALRTN' AND DEL_FLAG=1");
               	$val2=$query2->row_array();
                $acc_year=$val2['ACC_YEAR_CODE']; 
				$this->load->library('../controllers/lockdate');
				$voucher_date=$val2['DATE_OF_TRANSACTION'];
			 $check_status=$this->lockdate->check_date($voucher_date);
			 $message_display=$this->lockdate->message_val($voucher_date,$check_status);
			 if($message_display == '')
			 {
				 $message_display='Accounting Year Do not match';
			 }
                if($year_code == $acc_year && $check_status == 'false')	
				{
		//echo "Hai";
		$sess_array=$this->session->userdata('logged_in');
			   $deleted_by=$sess_array['user_id'];
			   $this->load->library('../controllers/lockdate');
			   $location_details=$this->lockdate->location_details();
			   $deleted_on=gmdate("Y-m-d H:i:s");
		$data=array('DEL_FLAG'=>'0',
		            'DELETED_BY'=>$deleted_by,
					'DELETED_ON'=>$deleted_on,
					'LOCATION_DETAILS'=>$location_details);
		$this->training_model->del_data('tbl_transaction',$data,$buk_num);
		
		$data['parent_account']=$this->training_model->selectAll('tbl_account');
	    $data['r']=$this->training_model->select_st_name('tbl_student');
	    $data['s']=$this->training_model->select_acc_type('tbl_account');
		$data['status']=$this->training_model->select_status('tbl_status');
		$data['msg']=" Delete successfully";
		$data['errmsg']="";
			$data['errmsg']="";	 
				//redirect(base_url()); 
				$layout=array('page'=>'form_training_return','title'=>'Training Return','data'=>$data);
				render_template($layout);
    			return FALSE;
				}
				else
				{
					$data['parent_account']=$this->training_model->selectAll('tbl_account');
	    $data['r']=$this->training_model->select_st_name('tbl_student');
	    $data['s']=$this->training_model->select_acc_type('tbl_account');
		$data['status']=$this->training_model->select_status('tbl_status');
					$data['msg']='';
		      $data['errmsg']=$message_display;
		       $layout = array('page' =>'form_training_return','title'=>'Training Return','data'=>$data);	
		       render_template($layout);	
			   return FALSE;
				}
		
		
	}
}
?>