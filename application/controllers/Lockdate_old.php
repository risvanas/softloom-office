<?php

class Lockdate extends MX_Controller

{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		$this->load->helper(array('form', 'template'));
		$this->template->set_template('admin_template');
		$this->load->library('form_validation');
	}

	function index($date="")
	{
		if($date=="")
		{
			 $layout = array('page' =>'form_error','title'=>'lockdate');	
		     render_template($layout);
		}
		if($date !="")
		{
		//$date='08-12-2015';
		 $date = strtotime($date);
		 $date=date("Y-m-d", $date);
	 $lockdate=$this->db->query("SELECT LOCK_DATE As lockdate  FROM tbl_lockdate WHERE DEL_FALG = 1 ");
	 $lockdate=$lockdate->row_array();
		if($lockdate['lockdate'] > $date)
		{
			redirect('lockdate/error');
			
			//$this->load->view('form_error');
			//return FALSE;
		}
		/*else
		{
			redirect('receipt');
		}*/
		}
		
	}
	function check_date($date)
	{
		//echo $date;
		//exit;
		if($date != '')
		{
			$date=strtotime($date);
			$date=date('Y-m-d',$date);
		}
		$sess_array=$this->session->userdata('logged_in');
		$id=$sess_array['accounting_year'];
		$sql="select * from tbl_accounting_year where AY_ID=$id";
		$query=$this->db->query($sql);
		$val=$query->row_array();
		$cur_date=date('Y-m-d');
		if($val['FROM_DATE'] > $date || $val['TO_DATE'] < $date || $cur_date < $date)
		{
           $value='true';
		   return $value;
				
		}
		else
		{
			$value='false';
		   return $value;
		}
	}
	function message_val($date,$val)
	{
		if($date != '')
		{
			$date=strtotime($date);
			$date=date('Y-m-d',$date);
		}
		if($val == 'true')
		{
			$sess_array=$this->session->userdata('logged_in');
		$id=$sess_array['accounting_year'];
		$sql="select * from tbl_accounting_year where AY_ID=$id";
		$query=$this->db->query($sql);
		$val=$query->row_array();
			$cur_date=date('Y-m-d');
	if($val['FROM_DATE'] > $date || $val['TO_DATE'] < $date)
		{
          $message="Date is Out of Accounting Year";
		}
		else
			{
				$message="Entered Date is Greater Than Current date";
			}
			return $message;
		}
	}
	 function error()
	{
		//$this->load->view('form_error');
		
		  $layout=array('page'=>'form_error','title'=>'Lockdate');
				render_template($layout);
	} 
	function date_register()
	{
		 $this->form_validation->set_rules('txt_lockdate', 'Lockdate','required');
		
		 if ($this->form_validation->run() != FALSE)
		 {
		 $lock_date=$this->input->post('txt_lockdate');
		 $lock_date = strtotime($lock_date);
		 $lock_date=date("Y-m-d", $lock_date);
		 $set_date=date('Y-m-d');
		$this->db->query("update tbl_lockdate set `DEL_FALG`=0 WHERE `DEL_FALG`=1");
		$this->db->query("INSERT INTO tbl_lockdate(LOCK_DATE,SET_DATE)VALUES('$lock_date','$set_date')");
		// $data['msg']='Payment added successfully';
		 $layout = array('page' =>'form_error','title'=>'');	
		 render_template($layout);	
		 }
		 else
		 {
			$layout=array('page'=>'form_error','title'=>'Lockdate');
		    render_template($layout); 
		 }
	}
	

}

?>