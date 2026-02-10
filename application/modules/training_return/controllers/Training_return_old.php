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
		
		 if($temp_voc_num!="")
		 {
			  $book_num=$temp_voc_num;
			 $name=$this->input->post('temp_name'); 
			 $this->db->query("update tbl_transaction set DEL_FLAG=0 where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='SALRTN'");
			
		 }
		 else
		 {
		 
		$query=$this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 1000)+1 AS BOOK_NUMBER
FROM tbl_transaction WHERE BOOK_NAME='SALRTN'");  
				 
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
					 'DISCONTINUE_DATE'=>$pay_date
		            ); 
					
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
					 'DISCONTINUE_DATE'=>$pay_date
		            ); 
					
					  $this->training_model->trans_ins('tbl_transaction',$ceredt_data);
					  $this->training_model->trans_ins('tbl_transaction',$debit_data);
			  
		
		  $this->db->query("UPDATE tbl_student SET STATUS='$status' where DEL_FLAG='1' AND STUDENT_ID='$name'");   
		  $data['msg']='Payment added successfully';
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
		echo $id = $this->uri->segment(3);
		$data=array('DEL_FLAG'=>'0');
		//$this->training_model->delete_data('tbl_payment',$data,$id);
		$this->training_model->delete_data1('tbl_transaction',$data,$id);
		
		$data['parent_account']=$this->training_model->selectAll('tbl_account');
	     $data['r']=$this->training_model->select_st_name('tbl_student');
	     $data['s']=$this->training_model->select_acc_type('tbl_account');
		 $data['msg']='Delete successfully';
		 $layout = array('page' =>'form_training_return','title'=>'Training Return','data'=>$data);	
		 render_template($layout);	 
		
	}
	
		function delete_data()
	     {
		//echo "Hai";
		echo $buk_num= $this->uri->segment(3);
		$data=array('DEL_FLAG'=>'0');
		$this->training_model->del_data('tbl_transaction',$data,$buk_num);
		
		$data['parent_account']=$this->training_model->selectAll('tbl_account');
	    $data['r']=$this->training_model->select_st_name('tbl_student');
	    $data['s']=$this->training_model->select_acc_type('tbl_account');
		$data['status']=$this->training_model->select_status('tbl_status');
		$data['msg']=" Delete successfully";
			$data['errmsg']="";	 
				//redirect(base_url()); 
				$layout=array('page'=>'form_training_return','title'=>'Training Return','data'=>$data);
				render_template($layout);
    			return FALSE;
		
		
	}
}
?>