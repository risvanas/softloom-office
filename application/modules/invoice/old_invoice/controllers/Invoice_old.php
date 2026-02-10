<?php
class Invoice extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
		$this->template->set_template('admin_template');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->model('invoice_model');
		$this->load->library('encryption');
		
	}
	
	
	function index()
	{
		$autoload['helper'] = array('security');
		$this->load->helper('security');
		$this->form_validation->set_rules('txt_invoice_date','Invoice date','required');
		if($this->form_validation->run()!=TRUE)
		{
			$data['sub_acc_list']= $this->invoice_model->select_sub_acc('tbl_account');
			$data['cust']=$this->invoice_model->select_customer('tbl_account');
			$data['msg']="";
			$data['errmsg']="";
			$layout=array('page'=>'form_invoice','title'=>'Invoice','data'=>$data);
			render_template($layout);
			//$this->load->view('form_invoice',$data);
		}
		else
		{
			// $invoice_date=$this->input->post('txt_invoice_date');
			 //$this->load->library('../controllers/lockdate');
    		 //$this->lockdate->index($invoice_date);
			
			
			
			
		$query=$this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 1000)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='INVOE'");
					  $row=$query->row_array(); 
					 $book_num=$row['BOOK_NUMBER']; 
		  //$book_num=$this->input->post('txt_buk_num');
		  $invoice_date=$this->input->post('txt_invoice_date');
		  $invoice_date = strtotime($invoice_date);
		  $invoice_date=date("Y-m-d",$invoice_date);
		  $cut_id=$this->input->post('txt_cust_name');
		  $total=$this->input->post('total');
		  $paid_amt=$this->input->post('paid');
		  $description=$this->input->post('txt_des');
		  $curnt_date=date('Y-m-d');
		  $cust_name=$this->input->post('lbl_cust_name');
		  
		  
		  $data=array('BOOK_NUMBER'=>$book_num,
			             'CUSTOMER_ID'=>$cut_id,
			 			 'BOOK_NAME'=>'INVO',
						 'INVOICE_DATE'=>$invoice_date,
						 'DESCRIPTION'=>$description,
						 'TOTAL_PRICE'=>$total,
						 'PAID_PRICE'=>$paid_amt,
						 'CURRENT_DATE'=>$curnt_date);
			$this->invoice_model->insert_data('tbl_invoice',$data);	
			$invo_id=$this->db->insert_id();
					 
		if (isset($_POST['item'])) 
		{
			for($i = 0; $i< count($_POST['item']); $i++)
			{
				echo $item=$_POST['item'][$i];
				echo $cost=$_POST['cost'][$i];
				echo $des=$_POST['description'][$i];
				echo $qty=$_POST['qty'][$i];
							 
			
			$data=array('ITEM'=>$item,
			             'DESCRIPTION'=>$des,
			 			 'UNIT_COST'=>$cost,
						 'QUANTITY'=>$qty,
						 'INVOICE_ID'=>$invo_id);
			$this->invoice_model->insert_data('tbl_invoicedetails',$data);	
			echo"<br>";
			
			}
		
			
		}
		 $remarks=$description." / ".$cust_name;  
		         $trn_data=array('FIN_YEAR_ID'=>2,
				                 'ACC_ID'=>108,
								 'DATE_OF_TRANSACTION'=>$invoice_date,
								 'CREDIT'=> $total,
								 'REMARKS'=>$remarks,
								 'DEL_FLAG'=>1,
								 'BOOK_NUMBER'=> $book_num,
								 'BOOK_NAME'=>'INVOE',
								 'SUB_ACC'=>$cut_id
								 );
				$trn_data1=array('FIN_YEAR_ID'=>2,
				                 'ACC_ID'=>47,
								 'DATE_OF_TRANSACTION'=> $invoice_date,
								 'DEBIT'=> $total,
								 'REMARKS'=>$remarks,
								 'DEL_FLAG'=>1,
								 'BOOK_NUMBER'=>$book_num,
								 'BOOK_NAME'=>'INVOE',
								 'SUB_ACC'=>$cut_id
								 );
								 
		   $this->invoice_model->insert_data('tbl_transaction',$trn_data);
		   $this->invoice_model->insert_data('tbl_transaction',$trn_data1);	
			
				
			$data['sub_acc_list']= $this->invoice_model->select_sub_acc('tbl_account');
			$data['cust']=$this->invoice_model->select_customer('tbl_account');
			$data['msg']='Invoice added successfully';
			$data['errmsg']="";
			$layout=array('page'=>'form_invoice','title'=>'Invoice','data'=>$data);
			render_template($layout);
			
		}
	}

		function invoice_list()
	{
		$data['list']= $this->invoice_model->invoice_list();
		$layout=array('page'=>'form_invoice_list','title'=>'Invoice','data'=>$data);
		render_template($layout);
		
	}
	
	function print_invoice()
	{
		$data_id=$this->uri->segment(3);
		$data_id = str_replace( "~", "/",  $data_id );
        $data_id = str_replace( "-", "=",  $data_id );
        $data_id = str_replace( ".", "+",  $data_id );
		$book_num= $this->encryption->decrypt($data_id);
		//$book_num= $this->uri->segment(3);
		$data['vno']= $this->invoice_model->invoice_edit($book_num);
		$this->load->view('form_print_invoice',$data);
	}
	
	
	function invoice_details()
	{
		 echo $book_num=$this->input->post('voc_no');
		 $data['vno']= $this->invoice_model->invoice_edit($book_num);
		 $this->load->view('form_acclist1',$data);
		 
	}
	
	function invoice_edit()
	{
		$data_id=$this->uri->segment(3);
		$data_id = str_replace( "~", "/",  $data_id );
        $data_id = str_replace( "-", "=",  $data_id );
        $data_id = str_replace( ".", "+",  $data_id );
		$book_num= $this->encryption->decrypt($data_id);
		//$book_num= $this->uri->segment(3);
		$data['vno']= $this->invoice_model->invoice_edit($book_num);
		$data['sub_acc_list']= $this->invoice_model->select_sub_acc('tbl_account');
			$data['cust']=$this->invoice_model->select_customer('tbl_account');
			$data['msg']='Invoice added successfully';
			$data['errmsg']="";
			$layout=array('page'=>'form_invoice_edit','title'=>'Invoice','data'=>$data);
			render_template($layout);
	}
	
	function account_list()
	{
		$acc_name=$this->input->post('name');
		
		$data['cond']=$this->invoice_model->select_All('invoice_account_herd',$acc_name);
		$this->load->view('form_acclist',$data);
	}

	function add_list()
	{
		$acc_name=$this->input->post('name');
		
		$data['cond']=$this->invoice_model->select_All('tbl_account',$acc_name);
		$this->load->view( 'form_acclist',$data);
	}
	function customer_details()
	{
		$cust_id=$this->input->post('cust_id');
		
		$data['customer']=$this->invoice_model->select_customer_details('tbl_account',$cust_id);
		$this->load->view( 'form_customer',$data);
		
	}
	
	function invoice_update()
	{
		  $invoice_id=$this->input->post('hdd_invo_id');
		  $book_num=$this->input->post('hdd_buk_num');
		  $invoice_date=$this->input->post('txt_invoice_date');
		  $invoice_date = strtotime($invoice_date);
	      $invoice_date=date("Y-m-d",$invoice_date);
		  $cut_id=$this->input->post('txt_cust_name');
		  $total=$this->input->post('total');
		  $paid_amt=$this->input->post('paid');
		  $description=$this->input->post('txt_des');
		  $cust_name=$this->input->post('lbl_cust_name');
		  $curnt_date=date('Y-m-d');
		  
		  $this->db->query("update tbl_invoice set DEL_FLAG=0 where INVOICE_ID='$invoice_id'");
		  $this->db->query("update tbl_invoicedetails set DEL_FLAG=0 where INVOICE_ID='$invoice_id'");
		   
		  $data=array('BOOK_NUMBER'=>$book_num,
			             'CUSTOMER_ID'=>$cut_id,
			 			 'BOOK_NAME'=>'INVO',
						 'INVOICE_DATE'=>$invoice_date,
						 'DESCRIPTION'=>$description,
						 'TOTAL_PRICE'=>$total,
						 'PAID_PRICE'=>$paid_amt,
						 'CURRENT_DATE'=>$curnt_date);
		
		 $this->invoice_model->insert_data('tbl_invoice',$data);
		 $invo_id=$this->db->insert_id();
		
		if (isset($_POST['item'])) 
		{
			for($i = 0; $i< count($_POST['item']); $i++)
			{
				echo $item=$_POST['item'][$i];
				echo $cost=$_POST['cost'][$i];
				echo $des=$_POST['description'][$i];
				echo $qty=$_POST['qty'][$i];
							 
			$data=array('ITEM'=>$item,
			             'DESCRIPTION'=>$des,
			 			 'UNIT_COST'=>$cost,
						 'QUANTITY'=>$qty,
						 'INVOICE_ID'=>$invo_id);
			$this->invoice_model->insert_data('tbl_invoicedetails',$data);	
			echo"<br>";
			
			}
		}
	 $this->db->query("update tbl_transaction set DEL_FLAG=0 where BOOK_NAME='INVOE' AND BOOK_NUMBER='$book_num' ");
	 
	 $remarks=$description." / ".$cust_name;      
		         $trn_data=array('FIN_YEAR_ID'=>2,
				                 'ACC_ID'=>108,
								 'DATE_OF_TRANSACTION'=>$invoice_date,
								 'CREDIT'=> $total,
								 'REMARKS'=>$remarks,
								 'DEL_FLAG'=>1,
								 'BOOK_NUMBER'=> $book_num,
								 'BOOK_NAME'=>'INVOE',
								 'SUB_ACC'=>$cut_id
								 );
				$trn_data1=array('FIN_YEAR_ID'=>2,
				                 'ACC_ID'=>47,
								 'DATE_OF_TRANSACTION'=> $invoice_date,
								 'DEBIT'=> $total,
								 'REMARKS'=>$remarks,
								 'DEL_FLAG'=>1,
								 'BOOK_NUMBER'=>$book_num,
								 'BOOK_NAME'=>'INVOE',
								 'SUB_ACC'=>$cut_id
								 );
								 
		   $this->invoice_model->insert_data('tbl_transaction',$trn_data);
		   $this->invoice_model->insert_data('tbl_transaction',$trn_data1);	
			
			
			redirect('invoice');
			
				
			/*$data['sub_acc_list']= $this->invoice_model->select_sub_acc('tbl_account');
			$data['cust']=$this->invoice_model->select_customer('tbl_account');
			$data['msg']='Invoice added successfully';
			$data['errmsg']="";
			$layout=array('page'=>'form_invoice','title'=>'Invoice','data'=>$data);
			render_template($layout);*/
	
	}
	
	
	

	function select_data()
	{
		//echo "Hai";
		 $buk_num=$this->input->post('voc_no');
		
		$data['vno']= $this->invoice_model->select_info('tbl_transaction',$buk_num);
		$this->load->view('form_displayData',$data);
	}
	function invoice_delete()
	{
		$data_id=$this->uri->segment(3);
		$data_id = str_replace( "~", "/",  $data_id );
        $data_id = str_replace( "-", "=",  $data_id );
        $data_id = str_replace( ".", "+",  $data_id );
		$book_num= $this->encryption->decrypt($data_id);
		//$book_num= $this->uri->segment(3);
		$data['vno']= $this->invoice_model->invoice_edit($book_num);
		$data['sub_acc_list']= $this->invoice_model->select_sub_acc('tbl_account');
			$data['cust']=$this->invoice_model->select_customer('tbl_account');
			$data['msg']='';
			$data['errmsg']="";
			$layout=array('page'=>'form_invoice_delete','title'=>'Invoice','data'=>$data);
			render_template($layout);
	}

	function del_data()
	{
		 $buk_num=$this->input->post('txt_buk_num');
		 $data=array('DEL_FLAG'=>'0');
		
		$this->invoice_model->delete_data1('tbl_transaction',$data,$buk_num);
	}
	
	function delete_data()
	{
	
		$invoice_id=$this->input->post('hdd_invo_id');
		$book_num=$this->input->post('txt_buk_num');
		$data=array('DEL_FLAG'=>'0');
		$this->invoice_model->delete_data1('tbl_transaction',$data,$book_num);
		$this->invoice_model->invo_delete('tbl_invoice',$data,$invoice_id);
		$this->invoice_model->invo_delete('tbl_invoicedetails',$data,$invoice_id);
		
		redirect('invoice');
		
		/*$data['sub_acc_list']= $this->invoice_model->select_sub_acc('tbl_account');
			$data['cust']=$this->invoice_model->select_customer('tbl_account');
			$data['msg']='Invoice delete successfully';
			$data['errmsg']="";
			$layout=array('page'=>'form_invoice','title'=>'Invoice','data'=>$data);
			render_template($layout);*/
			
		
		
	}
	
	
			function mult_search()
		    {
			    $dat_from=$this->input->post('calc');
				if($dat_from != '')
				{
				$dat_from = strtotime($dat_from);
	            $dat_from=date("Y-m-d",$dat_from);
				}
				
			    $dat_to=$this->input->post('dat');
				if($dat_to != '')
				{
				$dat_to = strtotime($dat_to);
	             $dat_to=date("Y-m-d",$dat_to);
				}
			    $key_words=$this->input->post('key_words');
			    $data['serch']= $this->invoice_model->multipe_select($dat_from,$dat_to,$key_words);
			    $this->load->view('form_search_data',$data);
		
		}
	
}

?>