<?php
class Student extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
		$this->load->helper('date');
		$this->template->set_template('admin_template');
		$this->load->library('form_validation');
		$this->load->model('student_model');
	}
	
	function index()
	{
		$data['parent_account']=$this->student_model->selectAll('tbl_student');
		$data['course']=$this->student_model->sel_course('tbl_account');
		$data['status']=$this->student_model->select_status('tbl_status');
		$data['district']=$this->student_model->select_district('tbl_districts');
		$data['msg']="";
		
		$this->form_validation->set_rules('txt_stud_name','Student_name','required');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$layout = array('page' => 'form_student_reg','title'=>'Student','data'=>$data);	
			render_template($layout);
		}
		else
		{
			
			   $stud_name= $this->input->post('txt_stud_name');
			   $address1= $this->input->post('txt_address1');
			   $address2= $this->input->post('txt_address2');
			   $address3= $this->input->post('txt_address3');
			   $contact= $this->input->post('txt_contact');
			   $contact2= $this->input->post('txt_contact2');
			   $pinnum= $this->input->post('txt_pinnum');
			   $district= $this->input->post('txt_district');
			   $email= $this->input->post('txt_email');
			   $gender= $this->input->post('rad_gender');
		       $stud_dob= $this->input->post('txt_stud_dobdate');
			   $course= $this->input->post('txt_stud_course');
			   $status= $this->input->post('status');
			   $reg_date= $this->input->post('txt_stud_regdate');
			   $time1 = strtotime($reg_date);
		       $reg_date1=date("Y-m-d", $time1);
			   
	           $due_date= $this->input->post('txt_stud_duedate');
			   $time2 = strtotime($due_date);
		       $d1=date("Y-m-d", $time2);
			   
	           $fee_amount= $this->input->post('txt_feeamt');
			   $ad_amount= $this->input->post('txt_advance');
			   $remark= $this->input->post('txt_remark');
			   
			   $course1= $this->input->post('txt_course1');
	           $college1= $this->input->post('txt_college1');
			   $year1= $this->input->post('txt_year1');
			   $mark1= $this->input->post('txt_marks1');
			   $course2= $this->input->post('txt_course2');
	           $college2= $this->input->post('txt_college2');
			   $year2= $this->input->post('txt_year2');
			   $mark2= $this->input->post('txt_marks2');
			   $course3= $this->input->post('txt_course3');
	           $college3= $this->input->post('txt_college3');
			   $year3= $this->input->post('txt_year3');
			   $mark3= $this->input->post('txt_marks3');
			   
			   $entry_date=date('Y-m-d');
			   
			   $query=$this->db->query("SELECT ACC_NAME FROM tbl_account where ACC_ID=$course ");
		       $row = $query->row_array();
		       $course_name=$row['ACC_NAME'];
			   $remarks=$course_name." Course Fee for"." ".$stud_name;      
			 
			   $dat = array(
				   'NAME'=>$stud_name,
				   'ADDRESS1'=>$address1,
				   'ADDRESS2'=>$address2,
				   'ADDRESS3'=>$address3,
				   'DISTRICT'=>$district,
				   'PIN_NUM'=>$pinnum,
				   'CONTACT_NO'=>$contact,
				   'CONTACT_NO2'=>$contact2,
				   'STUD_EMAIL'=> $email,
				   'GENDER'=>$gender,
				   'STUDENT_DOB'=>$stud_dob,
				   'COURSE'=>$course,
				   'STATUS'=>$status,
				   'REG_DATE'=>$reg_date1,
				   'DUE_DATE'=>$d1,
				   'FEE_AMOUNT'=>$fee_amount,
				   'ADVANCE_AMT'=>$ad_amount,   
				   'COURSE_NAME'=>$course1,
				   'COLLEGE_NAME'=>$college1,
				   'YEAR'=>$year1,
				   'MARKS'=>$mark1,   
				   'COURSE_NAME1'=>$course2,
				   'COLLEGE_NAME1'=>$college2,
				   'YEAR1'=>$year2,
				   'MARKS1'=>$mark2,
				   'COURSE_NAME2'=>$course3,
				   'COLLEGE_NAME2'=>$college3,
				   'YEAR2'=>$year3,
				   'MARKS2'=>$mark3,
				   'REMARK'=>$remark,
			       'CREATED_DATE'=>$entry_date);
			    $this->student_model->stud_insert('tbl_student',$dat);
			    $stud_id=$this->db->insert_id();
			       
			 $query=$this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 1000)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='SAL'");  
				 
					   $row = $query->row_array();
                        $book_num=$row['BOOK_NUMBER'];
						
				  $trn_data=array('FIN_YEAR_ID'=>2,
				                 'ACC_ID'=>31,
								 'DATE_OF_TRANSACTION'=>$reg_date1,
								 'CREDIT'=>$fee_amount,
								 'REMARKS'=>$remarks,
								/* 'TRANS_TYPE'=>'cash',*/
								 'DEL_FLAG'=>1,
								 'BOOK_NUMBER'=>$book_num,
								 'BOOK_NAME'=>'SAL',
								 'SRC_ID'=>$stud_id,
								 'SUB_ACC'=>$course);
				$trn_data1=array('FIN_YEAR_ID'=>2,
				                 'ACC_ID'=>38,
								 'DATE_OF_TRANSACTION'=>$reg_date1,
								 'DEBIT'=>$fee_amount,
								 'REMARKS'=>$remarks,
								/* TRANS_TYPE'=>'cash',*/
								 'DEL_FLAG'=>1,
								 'BOOK_NUMBER'=>$book_num,
								 'BOOK_NAME'=>'SAL',
								 'SRC_ID'=>$stud_id,
								 'SUB_ACC'=>$course);
								 
		     $this->student_model->stud_insert('tbl_transaction',$trn_data);
			 $this->student_model->stud_insert('tbl_transaction',$trn_data1);
			 
			  $query=$this->db->query("SELECT IFNULL(MAX(PAY_NUMBER), 1000)+1 AS PAY_NUMBER FROM tbl_payment WHERE TYPE='STD' ");
					   $row = $query->row_array();
                       $pay_num=$row['PAY_NUMBER'];
				       
					    if($ad_amount!="")
						{
							$pay_data=array('PAY_NUMBER'=>$pay_num,
											 'STUDENT_ID'=>$stud_id,
											 'AMOUNT'=>$ad_amount,
											 'TRANSACTION_TYPE'=>'cash',
											 'ENTRY_DATE'=>$entry_date,
											 'PAYMENT_DATE'=>$reg_date1,
											 'REMARKS'=>'ADVANCE',
											 'TYPE'=>'STD',
											 'FIN_YEAR_ID'=>2);  
		$this->student_model->stud_insert('tbl_payment',$pay_data); 
				$last_ins_payid=$this->db->insert_id();			
			$query=$this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 1000)+1 AS BOOK_NUMBER
FROM tbl_transaction WHERE BOOK_NAME='PAY' ");  
					  
					   $row = $query->row_array();
                      $book_num=$row['BOOK_NUMBER'];
					   
				$trn_data2=array('FIN_YEAR_ID'=>2,
				                 'ACC_ID'=>39,
								 'DATE_OF_TRANSACTION'=>$reg_date1,
								 'DEBIT'=>$ad_amount,
								 'REMARKS'=>$remarks,
								/* 'TRANS_TYPE'=>'cash',*/
								 'DEL_FLAG'=>1,
								 'BOOK_NUMBER'=>$book_num,
								 'BOOK_NAME'=>'PAY',
								 /*'SRC_ID'=>$stud_id,
								 'SUB_ACC'=>$course,*/
								 'PAYMENT_ID'=>$last_ins_payid );
								
				$trn_data3=array('FIN_YEAR_ID'=>2,
				                 'ACC_ID'=>38,
								 'DATE_OF_TRANSACTION'=>$reg_date1,
								 'CREDIT'=>$ad_amount,
								 'REMARKS'=>$remarks,
							/*	 'TRANS_TYPE'=>'cash',*/
								 'DEL_FLAG'=>1,
								 'BOOK_NUMBER'=>$book_num,
								 'BOOK_NAME'=>'PAY',
								 'SRC_ID'=>$stud_id,
								 'SUB_ACC'=>$course,
								 'PAYMENT_ID'=>$last_ins_payid); 
								 
						 $this->student_model->stud_insert('tbl_transaction',$trn_data2);
						 $this->student_model->stud_insert('tbl_transaction',$trn_data3);
						}
					$data['msg']='New student added successfully';
					$layout = array('page' => 'form_student_reg','title'=>'New Student','data'=>$data);	
			        render_template($layout);

		}
	}
	
	function student_list()
	{
		
		$data['status']=$this->student_model->select_status('tbl_status');
		$data['course']=$this->student_model->sel_course('tbl_account');
		$data['course_list']=$this->student_model->join_course_list('tbl_student');
		$layout = array('page' => 'form_studentlist','title'=>'Student List', 'data'=>$data);
	    render_template($layout);	
		
	}
	
		function student_edit()
	    {
	    $id = $this->uri->segment(3);
		$this->load->model('student_model');
		$data['student_edit']=$this->student_model->edit('tbl_student',$id);
		$data['parent_account']=$this->student_model->selectAll('tbl_student');
		$data['dis']=$this->student_model->select_district('tbl_districts');
		$data['res']=$this->student_model->sel_course('tbl_account');
		$data['stat']=$this->student_model->select_status('tbl_status');
		$layout = array('page' => 'form_student_edit','data'=>$data);
		render_template($layout);	
		
	   }
	   function student_update()
	   {
		   
		   $this->form_validation->set_rules('txt_stud_name','Student_name','required');
		
		   if ($this->form_validation->run() != FALSE)
				{
		       $id=$this->input->post('txt_id');
			   $stud_name= $this->input->post('txt_stud_name');
			   $address1= $this->input->post('txt_address1');
			   $address2= $this->input->post('txt_address2');
			   $address3= $this->input->post('txt_address3');
			   $contact= $this->input->post('txt_contact');
			   $contact2= $this->input->post('txt_contact2');
			   $district= $this->input->post('txt_district');
			   $pinnum= $this->input->post('txt_pinnum');
			   $email= $this->input->post('txt_email');
			   $gender= $this->input->post('rad_gender');
		       $stud_dob= $this->input->post('txt_stud_dobdate');
			   $course= $this->input->post('txt_acc_name');
			   $hdd_course= $this->input->post('hidden_acc_name');
			   $status= $this->input->post('status');
			   $reg_date= $this->input->post('txt_stud_regdate');
			   $time1 = strtotime($reg_date);
			   $reg_date1=date("Y-m-d", $time1);
			   
			   $hdd_reg_date= $this->input->post('hdd_stud_regdate');
			   $time1 = strtotime($hdd_reg_date);
			   $hdd_reg_date1=date("Y-m-d", $time1);
			   
			   $entry_date=date("Y-m-d");
			   
	           $due_date= $this->input->post('txt_stud_duedate');
			    $time2 = strtotime($due_date);
		       $due_date1=date("Y-m-d", $time2);
	           $fee_amount= $this->input->post('txt_feeamt');
			   $hdd_fee_amount= $this->input->post('hidden_stud_feeamt');
			   
			   $ad_amount= $this->input->post('txt_advance');
			   $hdd_ad_amount= $this->input->post('hidden_advance_amt');
			   
			   $remark= $this->input->post('txt_remark');
			   
			   $course1= $this->input->post('txt_course1');
	           $college1= $this->input->post('txt_college1');
			   $year1= $this->input->post('txt_year1');
			   $mark1= $this->input->post('txt_marks1');
			   $course2= $this->input->post('txt_course2');
	           $college2= $this->input->post('txt_college2');
			   $year2= $this->input->post('txt_year2');
			   $mark2= $this->input->post('txt_marks2');
			   $course3= $this->input->post('txt_course3');
	           $college3= $this->input->post('txt_college3');
			   $year3= $this->input->post('txt_year3');
			   $mark3= $this->input->post('txt_marks3');
			   
			   $dat = array(
			   'NAME'=>$stud_name,
			   
			   'ADDRESS1'=>$address1,
			   'ADDRESS2'=>$address2,
			   'ADDRESS3'=>$address3,
			   'DISTRICT'=>$district,
			   'PIN_NUM'=>$pinnum,
			   'CONTACT_NO'=>$contact,
			   'CONTACT_NO2'=>$contact2,
			   'STUD_EMAIL'=> $email,
			   'GENDER'=>$gender,
               'STUDENT_DOB'=>$stud_dob,
               'COURSE'=>$course,
			   'STATUS'=>$status,
			   
			   'REG_DATE'=>$reg_date1,
			   'DUE_DATE'=> $due_date1,
			   'FEE_AMOUNT'=>$fee_amount,
			   'ADVANCE_AMT'=>$ad_amount,
			   
			   
			   'COURSE_NAME'=>$course1,
			   'COLLEGE_NAME'=>$college1,
			   'YEAR'=>$year1,
			   'MARKS'=>$mark1,
			   	   
			   'COURSE_NAME1'=>$course2,
			   'COLLEGE_NAME1'=>$college2,
			   'YEAR1'=>$year2,
			   'MARKS1'=>$mark2,
			   
			   'COURSE_NAME2'=>$course3,
			   'COLLEGE_NAME2'=>$college3,
			   'YEAR2'=>$year3,
			   'MARKS2'=>$mark3,
			   'REMARK'=>$remark
			   );
			   
			   $this->load->model('student_model');	
	           $this->student_model->stud_update('tbl_student',$dat,$id);
			   
			   if($hdd_fee_amount!=$fee_amount ||  $hdd_course!= $course || $hdd_reg_date!=$reg_date)
			   {
				  $query=$this->db->query("select *from tbl_transaction where SRC_ID=$id AND BOOK_NAME='SAL' ");
				  if ($query->num_rows() > 0)
                          {
                           $row = $query->row_array();
                           $book_num=$row['BOOK_NUMBER'];
						   
						   
						   $this->db->query("update tbl_transaction set DEL_FLAG=0 where SRC_ID=$id AND BOOK_NAME='SAL'");

			   $query=$this->db->query("SELECT ACC_NAME FROM tbl_account where ACC_ID=$course ");
		       $row = $query->row_array();
		       $course_name=$row['ACC_NAME'];
			   $remarks=$course_name." Course Fee for"." ".$stud_name;  
						   
						   
						   
						    $trn_data=array('FIN_YEAR_ID'=>2,
				                 'ACC_ID'=>31,
								 'DATE_OF_TRANSACTION'=>$reg_date1,
								 'CREDIT'=>$fee_amount,
								 'REMARKS'=>$remarks,
								
								 'DEL_FLAG'=>1,
								 'BOOK_NUMBER'=>$book_num,
								 'BOOK_NAME'=>'SAL',
								 'SRC_ID'=>$id,
								 'SUB_ACC'=>$course);
				$trn_data1=array('FIN_YEAR_ID'=>2,
				                 'ACC_ID'=>38,
								 'DATE_OF_TRANSACTION'=>$reg_date1,
								 'DEBIT'=>$fee_amount,
								 'REMARKS'=>$remarks,
								
								 'DEL_FLAG'=>1,
								 'BOOK_NUMBER'=>$book_num,
								 'BOOK_NAME'=>'SAL',
								 'SRC_ID'=>$id,
								 'SUB_ACC'=>$course);
								 
			 $this->student_model->stud_insert('tbl_transaction',$trn_data);
			 $this->student_model->stud_insert('tbl_transaction',$trn_data1);
						 
				   }
				  else
				  {
		 $query=$this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 1000)+1 AS BOOK_NUMBER
FROM tbl_transaction WHERE BOOK_NAME='SAL'");  
					   $row = $query->row_array();
                      $book_num=$row['BOOK_NUMBER'];
					   
					    $trn_data=array('FIN_YEAR_ID'=>2,
				                 'ACC_ID'=>31,
								 'DATE_OF_TRANSACTION'=>$reg_date1,
								 'CREDIT'=>$fee_amount,
								 'REMARKS'=>$remarks,
								
								 'DEL_FLAG'=>1,
								 'BOOK_NUMBER'=>$book_num,
								 'BOOK_NAME'=>'SAL',
								 'SRC_ID'=>$id,
								 'SUB_ACC'=>$course);
				$trn_data1=array('FIN_YEAR_ID'=>2,
				                 'ACC_ID'=>38,
								 'DATE_OF_TRANSACTION'=>$reg_date1,
								 'DEBIT'=>$fee_amount,
								 'REMARKS'=>$remarks,
								
								 'DEL_FLAG'=>1,
								 'BOOK_NUMBER'=>$book_num,
								 'BOOK_NAME'=>'SAL',
								 'SRC_ID'=>$id,
								 'SUB_ACC'=>$course);
								 
			 $this->student_model->stud_insert('tbl_transaction',$trn_data);
			 $this->student_model->stud_insert('tbl_transaction',$trn_data1);
				        
				  }
			   }
		}
			  
			 //PaymentAmount_updateCode
			   
            $this->student_list();
	   }
	
	function student_delete()
	{
		$id = $this->uri->segment(3);
		$dat =array('DEL_FLAG'=>'0');
		$this->load->model('student_model');	
		$this->student_model->delete('tbl_student',$id,$dat);	
		$this->student_list();

	}
	
	
			function mult_search()
		{
			    $calc=$this->input->post('calc');
			    $dtype=$this->input->post('dat');
	            echo $course=$this->input->post('course');
	            $stat=$this->input->post('stat');
			    $key_words=$this->input->post('key_words');
			    $rdate=substr($calc,0,10);
			    $time1 = strtotime($rdate);
		        $from=date("Y-m-d", $time1);
				
			    $ddate=substr($calc,12);
                $time2 = strtotime($ddate);
                $to=date("Y-m-d", $time2);
		      
		
		       $this->load->model('Student_model');
			   $data['s']= $this->Student_model->multipe_select($from,$to,$dtype,$course,$stat,$key_words);
			   $this->load->view('form_search_data',$data);
		
		}
	   
		////$data['search']=$this->Student_model-> sample('tbl_student',$sname,$cname,$stat);
	}
?>