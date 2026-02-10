<?php
class Account extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
		$this->template->set_template('admin_template');
		$this->load->library('form_validation');
		$this->load->model('account_model');
	}
	
	function index()
	{
		$data['accounts']=$this->account_model->select_mainaccount('tbl_account');
		
	    $data['msg']="";
		$this->form_validation->set_rules('txt_acc_code','Acc_code','required');
		if ($this->form_validation->run() == FALSE)
		{
   		$layout = array('page' =>'form_accreg','title'=>'Account','data'=>$data);	
		render_template($layout);		
	    }
		else
		{
			   $acc_code=$this->input->post('txt_acc_code');
			   $acc_name= $this->input->post('txt_name');
			   $acc_level= $this->input->post('drp_acc_level');
			   $parent_acc= $this->input->post('drp_acc_parent');
			   $acc_group= $this->input->post('txt_acc_group');
			   $status=$this->input->post('drp_status');
		       $acc_type=$this->input->post('drp_acc_type');
			   $opng_balance=$this->input->post('txt_opng_balance');
			   $data = array('COMPANY_ID'=> '1',
								'ACC_LEVEL'=>$acc_level,
								'PARENT_ACC_ID'=>$parent_acc,
								'ACC_CODE'=>$acc_code,
   							 	'ACC_NAME'=>$acc_name,
								'ACC_GROUP'=>$acc_group,
								'STATUS'=>$status,
								'ACC_TYPE'=>$acc_type,
								'TYPE'=>'M',
								'OPENING_BALANCE'=>$opng_balance
								);
	
	    $this->account_model->acc_insert('tbl_account',$data); 
		$data['accounts']=$this->account_model->select_mainaccount('tbl_account');
		$data['msg']='New Account added successfully';
		$layout = array('page' =>'form_accreg','title'=>'Account','data'=>$data);	
		render_template($layout);		
		}
	}
	
	function subaccount()
	{
		 $data['accounts']=$this->account_model->select_mainaccount('tbl_account');
		 $this->form_validation->set_rules('drp_account', 'Account','required');
		 $data['msg']="";
		 if ($this->form_validation->run() == FALSE)
		 {
		 $layout = array('page' =>'form_subaccount','title'=>'Account','data'=>$data);	
		 render_template($layout);
		}
		else
		{
		 $acc_code=$this->input->post('txt_acc_code');
		 $acc_name=$this->input->post('txt_name');
		 $parent_acc=$this->input->post('drp_account');
		 $status= $this->input->post('drp_status');
		 $data = array('COMPANY_ID'=>'1',
								'PARENT_ACC_ID'=>$parent_acc,
								'ACC_CODE'=>$acc_code,
   							 	'ACC_NAME'=>$acc_name,
								'STATUS'=>$status,
								'TYPE'=>'S'
								);
	    $this->account_model->acc_insert('tbl_account',$data); 
		
		$data['accounts']=$this->account_model->select_mainaccount('tbl_account');
		$data['msg']='New Sub Account added successfully';
		$layout = array('page' =>'form_subaccount','title'=>'Account','data'=>$data);	
		render_template($layout);
		}
		 
	 }
	 
	 function staff_register()
		 {
		 
		 $data['desi']=$this->account_model->select_designation('tbl_designation');
		 $this->form_validation->set_rules('txt_staff_name', 'Staff_name','required');
		 $data['msg']="";
		if($this->form_validation->run() == FALSE)
		{
		 $layout = array('page' =>'form_staff_register','title'=>'Account','data'=>$data);	
		 render_template($layout);
		}
		else
		{
		  $staff_name=$this->input->post('txt_staff_name');
		  $address1=$this->input->post('txt_address1');
		  $address2=$this->input->post('txt_address2');
		  $contact=$this->input->post('txt_contact');
		  $email=$this->input->post('txt_email');
		  $designation=$this->input->post('txt_staff_desi');
		  $cust_dob=$this->input->post('txt_staff_dobdate');
		  $cust_dob = strtotime($cust_dob);
		  $cust_dob=date("Y-m-d", $cust_dob);
		  $genger=$this->input->post('rad_gender');
		  $status=$this->input->post('status');
		  $remark=$this->input->post('txt_remark');
		  
		  $data=array('COMPANY_ID'=>'1',
					'PARENT_ACC_ID'=>'46',
		  			'ACC_NAME'=>$staff_name,
		  			'ADDRESS_ONE'=>$address1,
		  			'ADDRESS_TWO'=>$address2,
		  			'PHONE'=>$contact,
		  			'ACC_EMAIL'=>$email,
		  			'DESIGNATION'=>$designation,
					'GENDER'=>$genger,
					'CUST_DOB'=>$cust_dob,
		  			'STATUS'=>$status,
		  			'ACC_MODE'=>'STAFF',
		  			'TYPE'=>'S',
		  			'REMARK'=>$remark);
		 $this->account_model->acc_insert('tbl_account',$data);
		
		  $data['desi']=$this->account_model->select_designation('tbl_designation');
		  $data['msg']='New Sub Account added successfully';
		 $layout = array('page' =>'form_staff_register','title'=>'Account','data'=>$data);	
		 render_template($layout);  
		 }
		 
		 }
		 
		 function customer_register()
		 {
			  $this->form_validation->set_rules('txt_cust_name', 'customer_name','required');
		      $data['msg']="";
			 if($this->form_validation->run() == FALSE)
			 {
			 $layout = array('page' =>'form_customer_register','title'=>'Account','data'=>$data);	
		     render_template($layout);   
		 	}
		 	else
		 	{
			  $cust_name=$this->input->post('txt_cust_name');
		      $address1=$this->input->post('txt_address1');
		      $address2=$this->input->post('txt_address2');
		      $contact=$this->input->post('txt_contact');
		      $email=$this->input->post('txt_email');
			  $cust_dob=$this->input->post('txt_cust_dobdate');
			  $cust_dob = strtotime($cust_dob);
		      $cust_dob=date("Y-m-d", $cust_dob);
		      $genger=$this->input->post('rad_gender');
			  $status=$this->input->post('status');
		  	  $remark=$this->input->post('txt_remark');
			  $op_balance=$this->input->post('txt_balance');
			  $contact_person=$this->input->post('txt_contactperson');
			  $data=array('COMPANY_ID'=>'1',
					'PARENT_ACC_ID'=>'47',
		  			'ACC_NAME'=>$cust_name,
		  			'ADDRESS_ONE'=>$address1,
		  			'ADDRESS_TWO'=>$address2,
					'CONTACT_PERSON'=>$contact_person,
		  			'PHONE'=>$contact,
		  			'ACC_EMAIL'=>$email,
					'GENDER'=>$genger,
					'CUST_DOB'=>$cust_dob,
		  			'STATUS'=>$status,
		  			'ACC_MODE'=>'CUSTOMER',
		  			'TYPE'=>'S',
		  			'REMARK'=>$remark,
					'OPENING_BALANCE'=>$op_balance);
			  $this->account_model->acc_insert('tbl_account',$data);
			  $data['msg']='New Sub Account added successfully';
			  $layout = array('page' =>'form_customer_register','title'=>'Account','data'=>$data);	
		      render_template($layout);   
			 }
		 	 }
	 
		function mainaccount_list()
	    {
			
		$data['cond']=$this->account_model->select_mainaccount('tbl_account');
		$layout = array('page' => 'form_mainaccount_list','title'=>'Main Account List','data'=>$data);
		render_template($layout);	
	    }
		
	   function subaccount_list()
	    {
		$data['cond']=$this->account_model->select_subaccount('tbl_account');
		$layout = array('page' => 'form_subaccount_list','title'=>'Sub Account List','data'=>$data);
		render_template($layout);	
	    }
	
	    function staff_list()
	    {
		$data['desi']=$this->account_model->select_designation('tbl_designation');
		$data['staff_list']=$this->account_model->selectAll('tbl_account');
		$layout = array('page' => 'form_staff_list','title'=>'Staff List','data'=>$data);
		render_template($layout);	
	    }
		
		function customer_list()
	    {
		
		$data['customer_list']=$this->account_model->selectcustomer('tbl_account');
		$layout = array('page' => 'form_customer_list','title'=>'Customer List','data'=>$data);
		render_template($layout);	
	    }
		
		function account_edit()
		{
	    $id = $this->uri->segment(3);
		$data['accounts']=$this->account_model->select_mainaccount('tbl_account');
		$data['account_edit']=$this->account_model->edit('tbl_account',$id);
		$layout = array('page' =>'form_account_edit','data'=>$data);
		render_template($layout);	
		}
         
		function subaccount_edit()
		{
	    $id = $this->uri->segment(3);
		$data['accounts']=$this->account_model->select_mainaccount('tbl_account');
		//$data['status']=$this->account_model->select_status('tbl_status');
		$data['subaccount_edit']=$this->account_model->edit('tbl_account',$id);
		$layout = array('page' => 'form_subaccount_edit','data'=>$data);
		render_template($layout);	
		}
		function staff_edit()
		{
	    $id = $this->uri->segment(3);
		
		$data['desi']=$this->account_model->select_designation('tbl_designation');
		$data['staff_edit']=$this->account_model->edit('tbl_account',$id);
		$layout = array('page' => 'form_staff_edit','data'=>$data);
		render_template($layout);	
		}
		function customer_edit()
		{
		   echo $id =$this->uri->segment(3);	
		   $data['cust_edit']=$this->account_model->edit('tbl_account',$id);
		   $layout = array('page' => 'form_customer_edit','data'=>$data);
		   render_template($layout);
		}
		
		function mainaccount_update()
		{	
			$id=$this->input->post('txt_acc_id');
			$acc_code=$this->input->post('txt_acc_code');
			$acc_name= $this->input->post('txt_name');
			$acc_level= $this->input->post('drp_acc_level');
			$parent_acc= $this->input->post('drp_acc_parent');
			$acc_group= $this->input->post('txt_acc_group');
			$status= $this->input->post('drp_status');
			$acc_type= $this->input->post('drp_acc_type');
			$opng_balance=$this->input->post('txt_opng_balance');
			$data = array('COMPANY_ID'=> '1',
								'ACC_LEVEL'=>$acc_level,
								'PARENT_ACC_ID'=>$parent_acc,
								'ACC_CODE'=>$acc_code,
   							 	'ACC_NAME'=>$acc_name,
								'ACC_GROUP'=>$acc_group,
								'STATUS'=>$status,
								'ACC_TYPE'=>$acc_type,
								'TYPE'=>'M',
								'OPENING_BALANCE'=>$opng_balance
								);
	$this->account_model->acc_update('tbl_account',$data,$id);
    $this->mainaccount_list();	
	}
	
	function subaccount_update()
	{
		 
		 $id=$this->input->post('txt_acc_id');
		 $acc_code=$this->input->post('txt_acc_code');
		 $acc_name=$this->input->post('txt_name');
		 $parent_acc=$this->input->post('drp_account');
		 $status= $this->input->post('drp_status');
		 $data = array('COMPANY_ID'=>'1',
								'PARENT_ACC_ID'=>$parent_acc,
								'ACC_CODE'=>$acc_code,
   							 	'ACC_NAME'=>$acc_name,
								'STATUS'=>$status,
								'TYPE'=>'S'
								);
	    $this->account_model->acc_update('tbl_account',$data,$id);
		$this->subaccount_list();
	}
	function staff_update()
	{
		  $id=$this->input->post('txt_id');
		  $staff_name=$this->input->post('txt_staff_name');
		  $address1=$this->input->post('txt_address1');
		  $address2=$this->input->post('txt_address2');
		  $contact=$this->input->post('txt_contact');
		  $email=$this->input->post('txt_email');
		  $cust_dob=$this->input->post('txt_staff_dobdate');
		  $cust_dob = strtotime($cust_dob);
		  $cust_dob=date("Y-m-d", $cust_dob);
		  $genger=$this->input->post('rad_gender');
		  $designation=$this->input->post('txt_staff_desi');
		  $status=$this->input->post('status');
		  $remark=$this->input->post('txt_remark');
		  $data=array('COMPANY_ID'=>'1',
					'PARENT_ACC_ID'=>'46',
		  			'ACC_NAME'=>$staff_name,
		 			'ADDRESS_ONE'=>$address1,
		  			'ADDRESS_TWO'=>$address2,
		  			'PHONE'=>$contact,
		  			'ACC_EMAIL'=>$email,
					'GENDER'=>$genger,
					'CUST_DOB'=>$cust_dob,
		  			'DESIGNATION'=>$designation,
		  			'STATUS'=>$status,
		  			'ACC_MODE'=>'STAFF',
		  			'TYPE'=>'S',
		  			'REMARK'=>$remark);
		 $this->account_model->acc_update('tbl_account',$data,$id);
		 $this->staff_list();
	}
	
	function customer_update()
	{
		      $id=$this->input->post('txt_id');
		      $cust_name=$this->input->post('txt_cust_name');
		      $address1=$this->input->post('txt_address1');
		      $address2=$this->input->post('txt_address2');
		      $contact=$this->input->post('txt_contact');
		      $email=$this->input->post('txt_email');
			  $cust_dob=$this->input->post('txt_cust_dobdate');
			  $cust_dob = strtotime($cust_dob);
		      $cust_dob=date("Y-m-d", $cust_dob);
		      $genger=$this->input->post('rad_gender');
			  $status=$this->input->post('status');
		  	  $remark=$this->input->post('txt_remark');
			  $op_balance=$this->input->post('txt_balance');
			  $contact_person=$this->input->post('txt_contactperson');
			  $data=array('COMPANY_ID'=>'1',
					'PARENT_ACC_ID'=>'47',
		  			'ACC_NAME'=>$cust_name,
		  			'ADDRESS_ONE'=>$address1,
		  			'ADDRESS_TWO'=>$address2,
					'CONTACT_PERSON'=>$contact_person,
		  			'PHONE'=>$contact,
		  			'ACC_EMAIL'=>$email,
					'GENDER'=>$genger,
					'CUST_DOB'=>$cust_dob,
		  			'STATUS'=>$status,
		  			'ACC_MODE'=>'CUSTOMER',
		  			'TYPE'=>'S',
		  			'REMARK'=>$remark,
					'OPENING_BALANCE'=>$op_balance);
			   $this->account_model->acc_update('tbl_account',$data,$id);
			   $this->customer_list();
	}
	
	function account_delete()
	{
		//ob_start();
		$id = $this->uri->segment(3);
		$dat =array('DEL_FLAG'=>'0');
		$this->load->model('account_model');	
		$this->account_model->delete('tbl_account',$id,$dat);	
		//redirect($_SERVER['HTTP_REFERER']);
		$this->mainaccount_list();
	}
	
	
	function test()
	{
		ob_start();
		//redirect('/dashboard');
		//header ('Location: http://wesmosis.softloom.com/dashboard/');
		
		$newURL = "http://wesmosis.softloom.com/dashboard/";

        // echo $redirect_url="http://callnconnect.com/ad/".$row['SLUG']."/";
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: $newURL");
				exit();
		//wesmosis.softloom.com/dashboard/
		//redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	
	function subaccount_delete()
	{
		$id = $this->uri->segment(3);
		$dat =array('DEL_FLAG'=>'0');
		$this->load->model('account_model');	
		$this->account_model->delete('tbl_account',$id,$dat);	
		$this->subaccount_list();
	}
	
}
?>