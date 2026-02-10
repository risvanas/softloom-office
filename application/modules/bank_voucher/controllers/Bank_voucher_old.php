<?php
class Bank_voucher extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','template'));
		$this->template->set_template('admin_template');
		$this->load->library('form_validation');
		$this->load->model('bank_model');
		
	}
	
	function index()
	{
		$data['bank']=$this->bank_model->select_acc_code('tbl_account');
		$this->form_validation->set_rules('txt_receipt_date','receipt date','required');
		if($this->form_validation->run()!=TRUE)
		{
			$data['sub_acc_list']= $this->bank_model->select_sub_acc('tbl_account');
			$data['msg']="";
			$data['errmsg']="";
			$layout=array('page'=>'form_bank_voucher','title'=>'Bank Voucher','data'=>$data);
			render_template($layout);
		}
		else
		{
			 $receipt_date=$this->input->post('txt_receipt_date');
			 $this->load->library('../controllers/lockdate');
    		 $this->lockdate->index($receipt_date);
			 
			$n=$this->input->post('Num');
			if ($n == '2') 
			{
				$data['sub_acc_list']= $this->bank_model->select_sub_acc('tbl_account');
				$data['msg']="";
				$data['errmsg']="You have some form errors. Please check below.";
				$layout=array('page'=>'form_bank_voucher','title'=>'Bank Voucher','data'=>$data);
				render_template($layout);
    			return FALSE;
  			}
			
			$temp_voc_num=$this->input->post('temp_voc_num');
		    $bank_id=$this->input->post('sel_bank');
			$trans_type=$this->input->post('txt_trans_type');
			
			for($i=3;$i<=$n;$i++)
				{
					 $amt=$this->input->post('amount'.$i);
					 if($amt==0 || $amt=="")
					 {
						$data['bank']=$this->bank_model->select_acc_code('tbl_account');
						$data['sub_acc_list']= $this->bank_model->select_sub_acc('tbl_account');
						$data['msg']="";
						$data['errmsg']="Amount is Not Valid";
						$layout=array('page'=>'form_bank_voucher','title'=>'Bank Voucher','data'=>$data);
						render_template($layout);
    					return FALSE; 
					 }
				}
			
			if($temp_voc_num!="")
			{
			$this->db->query("update tbl_transaction set DEL_FLAG=0 where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='BV' AND DEL_FLAG=1");
			$book_num=$temp_voc_num;
			}
			else
			{
				$query=$this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='BV' ");
		   		$row = $query->row_array();
		   	    $book_num=$row['BOOK_NUMBER'];
			}
				
				for($i=3;$i<=$n;$i++)
				{
				 $acc_id=$this->input->post('acc_id'.$i);
				 $sub_acc_id=$this->input->post('sub_acc'.$i);
				 $amt=$this->input->post('amount'.$i);
				 $rem=$this->input->post('remarks'.$i);
				 $course_name=$this->input->post('acc_name'.$i);
				 $rvno=$this->input->post('txt_ref_voucher_no');
				 $receipt_date=$this->input->post('txt_receipt_date');
				 $receipt_date = strtotime($receipt_date);
				 $receipt_date=date("Y-m-d", $receipt_date);
				 $query=$this->db->query("SELECT ACC_NAME FROM tbl_account WHERE ACC_ID='$sub_acc_id' ");
		   		 $res = $query->row_array();
		   	     $sub_name=$res['ACC_NAME'];
				 
				 if($sub_name!="")
				 {
				 $sub_acc_description=" - ".$sub_name;
				 }
				 else
				 {
					  $sub_acc_description="";
				 }
				 if($rem!="")
				 {
				 $description=" / ".$rem;
				 }
				 else
				 {
					 $description="";
				 }
				 
				 //$remark="To Cash Payment - ".$course_name." ".$rem." ".$sub_acc_description;
				
				if($trans_type=="Deposit")
			        {
						$remark_cashac="Payment From  ".$course_name;
						$remark="Payment From  ".$course_name.$sub_acc_description.$description;
				
				$data=array('FIN_YEAR_ID'=>'2',
							'ACC_ID'=>$acc_id,
							'DATE_OF_TRANSACTION'=>$receipt_date,
							'CREDIT'=>$amt,
							'REMARKS'=>$remark,
							'DESCRIPTION'=>$rem,
							'TRANS_TYPE'=>$trans_type,
							'BOOK_NUMBER'=>$book_num,
							'BOOK_NAME'=>'BV',
							'REF_VOUCHERNO'=> $rvno,
							'SUB_ACC'=>$sub_acc_id);

				$data2=array('FIN_YEAR_ID'=>'2',
							'ACC_ID'=>$bank_id,
							'DATE_OF_TRANSACTION'=>$receipt_date,
							'DEBIT'=>$amt,
							'REMARKS'=>$remark,
							'DESCRIPTION'=>$rem,
							'TRANS_TYPE'=>$trans_type,
							'BOOK_NUMBER'=>$book_num,
							'BOOK_NAME'=>'BV',
							'REF_VOUCHERNO'=>$rvno);
					}
					else
					{
						$remark_cashac="Payment To  ".$course_name;
						$remarks="Payment To  ".$course_name.$sub_acc_description.$description;
						
						$data=array('FIN_YEAR_ID'=>'2',
							'ACC_ID'=>$acc_id,
							'DATE_OF_TRANSACTION'=>$receipt_date,
							'DEBIT'=>$amt,
							'REMARKS'=>$remarks,
							'DESCRIPTION'=>$rem,
							'TRANS_TYPE'=>$trans_type,
							'BOOK_NUMBER'=>$book_num,
							'BOOK_NAME'=>'BV',
							'REF_VOUCHERNO'=> $rvno,
							'SUB_ACC'=>$sub_acc_id);

				$data2=array('FIN_YEAR_ID'=>'2',
							'ACC_ID'=>$bank_id,
							'DATE_OF_TRANSACTION'=>$receipt_date,
							'CREDIT'=>$amt,
							'REMARKS'=>$remarks,
							'DESCRIPTION'=>$rem,
							'TRANS_TYPE'=>$trans_type,
							'BOOK_NUMBER'=>$book_num,
							'BOOK_NAME'=>'BV',
							'REF_VOUCHERNO'=>$rvno);
						
					}
						
				$this->bank_model->insert_data('tbl_transaction',$data);
				$this->bank_model->insert_data('tbl_transaction',$data2);
				}
				
				$data['bank']=$this->bank_model->select_acc_code('tbl_account');
			    $data['sub_acc_list']= $this->bank_model->select_sub_acc('tbl_account');
			    $data['msg']='bank voucher added successfully';
			    $data['errmsg']="";
			    $layout=array('page'=>'form_bank_voucher','title'=>'Bank Voucher','data'=>$data);
				render_template($layout);
				
	  }
	}
	
	function account_list()
	{
		$acc_name=$this->input->post('name');
		$data['cond']=$this->bank_model->select_All('tbl_account',$acc_name);
		$this->load->view('form_acclist',$data);
	}

	function add_list()
	{
		$acc_name=$this->input->post('name');
		$data['cond']=$this->bank_model->select_All('tbl_account',$acc_name);
		$this->load->view( 'form_acclist',$data);
	}

	function select_data()
	{
		
		$buk_num=$this->input->post('voc_no');
		$data['vno']= $this->bank_model->select_info('tbl_transaction',$buk_num);
		$this->load->view('form_displayData',$data);
	}

	function del_data()
	{
		 $buk_num=$this->input->post('txt_buk_num');
		 $data=array('DEL_FLAG'=>'0');
		 $this->bank_model->delete_data1('tbl_transaction',$data,$buk_num);
	}
    function delete_data()
	{
		$buk_num= $this->uri->segment(3);
		$data=array('DEL_FLAG'=>'0');
		$this->bank_model->delete_data1('tbl_transaction',$data,$buk_num);
		
		$data['bank']=$this->bank_model->select_acc_code('tbl_account');
		$data['sub_acc_list']= $this->bank_model->select_sub_acc('tbl_account');
			$data['msg']="bank voucher Delete successfully";
			$data['errmsg']="";
			$layout=array('page'=>'form_bank_voucher','title'=>'Bank Voucher','data'=>$data);
			render_template($layout);
	}
	
}

?>