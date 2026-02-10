<?php
class Income_expenditure extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
		$this->load->helper('date');
		$this->template->set_template('admin_template');
	}
	function index()
	{
		$layout = array('page' => 'form_income_expenditure','title'=>'trial_balance');	
		render_template($layout);
	}
	function calculation()
	{
		$date_m=$this->input->post("date");
		$data['from']=$date_m;
		$date_m=strtotime($date_m);
		$date_m=date('Y-m-d',$date_m);
		
		$date_n=$this->input->post("to_date");
		$data['to']=$date_n;
		$date_n=strtotime($date_n);
		$date_n=date('Y-m-d',$date_n);
		
  $data['data_pass']=$this->db->query("SELECT IFNULL( SUM( DEBIT ) , 0 ) - IFNULL( SUM( CREDIT ) , 0 ) AS income,tbl_account.PARENT_ACC_ID as id FROM `tbl_transaction` join tbl_account on tbl_transaction.ACC_ID=tbl_account.ACC_ID where tbl_account.PARENT_ACC_ID in(3,4) and tbl_transaction.DEL_FLAG=1 and tbl_transaction.DATE_OF_TRANSACTION>='$date_m' and tbl_transaction.DATE_OF_TRANSACTION<='$date_n' group by tbl_account.PARENT_ACC_ID");
  
		       //$data= $m->row_array();
     		   //echo $data['acc'];
			   $this->load->view('form_income_disp_table.php',$data);

	}
	
	
}
?>