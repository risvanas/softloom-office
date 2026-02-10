<?php
class Trialbalance extends MX_Controller
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
		$layout = array('page' => 'form_trialbal_disp','title'=>'trial_balance');	
		render_template($layout);
	}
	function calculation()
	{
		$date_m=$this->input->post("date");
		$date_m=strtotime($date_m);
		$date_m=date('Y-m-d',$date_m);
		$data['data_pass']=$this->db->query("Select
  tbl_account.ACC_ID as acc,tbl_account.opening_balance as op,
  (Select
  Sum(tbl_transaction.DEBIT) As debit_sum
From
  tbl_transaction where tbl_transaction.ACC_ID = acc and tbl_transaction.date_of_transaction<='$date_m') As Column1,
  (Select
  Sum(tbl_transaction.CREDIT) As creit_sum
From
  tbl_transaction where tbl_transaction.ACC_ID = acc and tbl_transaction.date_of_transaction<='$date_m' ) As Column2
From
  tbl_account");
  
		       //$data= $m->row_array();
     		   //echo $data['acc'];
			   $this->load->view('form_trialbal_disp_table.php',$data);

	}
	
}
?>