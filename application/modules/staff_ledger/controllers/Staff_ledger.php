<?php
class Staff_ledger extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','template'));
		$this->template->set_template('admin_template');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->model('staffledger_model');
	}
	
	function index()
	{
		
		$data['cond']=$this->staffledger_model->selectAll('tbl_account');
		$this->form_validation->set_rules('txt_from','From Date','required');
		if ($this->form_validation->run() == FALSE)
		{
			
		$layout = array('page' => 'form_staff_ledger','title'=>'Staff Finance','data'=>$data);
		render_template($layout);
		}
		
	}
	
	  function details_staff()
		{
		    $this->form_validation->set_rules('txt_date','Date','required');
		    if ($this->form_validation->run() == FALSE)
			{
			 $data['staff_list']=$this->staffledger_model->staff_details('tbl_account');
			 $data['msg']="";
			 $layout = array('page' =>'form_staff','data'=>$data);
	         render_template($layout);	
			}
			else
			{
				$n=$this->input->post('Num');
				if($n==0)
				{
				 $data['staff_list']=$this->staffledger_model->staff_details('tbl_account');
			 	$data['msg']="";
			 	$layout = array('page' =>'form_staff','data'=>$data);
	         	render_template($layout);	
				}
				
				$temp_voc_num=$this->input->post('temp_voc_num');
				if($temp_voc_num!="")
				{
			$this->db->query("update tbl_transaction set DEL_FLAG=0 where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='SLA'");
				$book_num=$temp_voc_num;
			
				}
				else
				{
$query=$this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='SLA' ");
		   		$row = $query->row_array();
		   	    $book_num=$row['BOOK_NUMBER'];
			}
				for($i=1;$i<$n;$i++)
				 {
				 
				  //$book_num=$this->input->post('txt_buk_num');
				  $voucher_date=$this->input->post('txt_date');
				  $voucher_date = strtotime($voucher_date);
				  $voucher_date=date("Y-m-d", $voucher_date);
				  $staffid=$this->input->post('txt_staffid'.$i);
				  $staffname=$this->input->post('txt_staffname'.$i);
				  $salary=$this->input->post('txt_salary'.$i);
				  $remarks="Salary - ".$staffname;
				 $data=array('FIN_YEAR_ID'=>'2',
							'ACC_ID'=>42,
							'DATE_OF_TRANSACTION'=>$voucher_date,
							'CREDIT'=>$salary,
							'REMARKS'=>$remarks,
							'BOOK_NUMBER'=>$book_num,
							'BOOK_NAME'=>'SLA',
							'SUB_ACC'=>$staffid);
				$data2=array('FIN_YEAR_ID'=>'2',
							'ACC_ID'=>99,
							'DATE_OF_TRANSACTION'=>$voucher_date,
							'DEBIT'=>$salary,
							'REMARKS'=>$remarks,
							'BOOK_NUMBER'=>$book_num,
							'BOOK_NAME'=>'SLA');
							
				$this->staffledger_model->insert_data('tbl_transaction',$data);
				$this->staffledger_model->insert_data('tbl_transaction',$data2);
				}
			 $data['staff_list']=$this->staffledger_model->staff_details('tbl_account');
			 $data['msg']='Salary added successfully';
			 $layout = array('page' =>'form_staff','data'=>$data);
	         render_template($layout);
				
			}
		}
		function details_staff_edit()
		{
			
		    $buk_num=$this->input->post('voc_no');
			$data['vno']= $this->staffledger_model->select_info('tbl_transaction',$buk_num);
			//$this->load->view('form_displayData',$data);
		   $this->load->view('form_edit_data',$data);
		}
		function search_details()
		{
			$from_date=$this->input->post('fromdate');
			$to_date=$this->input->post('todate');
			$acc=$this->input->post('acc');
			$from_date = strtotime($from_date);
		    $from=date("Y-m-d",$from_date);
            $to_date = strtotime($to_date);
            $to=date("Y-m-d", $to_date);
			if($acc!="" && $from!="" && $to!="")
			{
		 $data['sel']=$this->staffledger_model->multi_search($acc,$from,$to);
		 $this->load->view('form_ledger_list',$data);
			}
		}
		
		function del_data()
		{
			
		 //$buk_num=$this->input->post('txt_buk_num');
		 $buk_num= $this->uri->segment(3);
		 $data=array('DEL_FLAG'=>'0');
		 $this->staffledger_model->delete_data('tbl_transaction',$data,$buk_num);
		     $data['staff_list']=$this->staffledger_model->staff_details('tbl_account');
			 $data['msg']='';
			 $layout = array('page' =>'form_staff','data'=>$data);
	         render_template($layout);
		}
		
	
}
?>