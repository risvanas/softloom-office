<?php
class Income_and_expenditure extends MX_Controller
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
		$layout = array('page' => 'form_income_and_expenditure','title'=>'Income and Expenditure');	
		render_template($layout);
	}
	function calculation()
	{
		$from_date=$this->input->post("from_date");
		$from_date=strtotime($from_date);
		echo $from_date=date('Y-m-d',$from_date);
		
		$to_date=$this->input->post("to_date");
		$to_date=strtotime($to_date);
		echo $to_date=date('Y-m-d',$to_date);
		
		$data['data_pass']=$this->db->query("Select
							  tbl_transaction.ACC_ID,
							  Sum(tbl_transaction.CREDIT) As CREDIT,
							  Sum(tbl_transaction.DEBIT) As DEBIT,
							  tbl_transaction.BOOK_NAME,
							  tbl_account.ACC_NAME
							From
							  tbl_transaction Left Join
							  tbl_account On tbl_transaction.ACC_ID =
								tbl_account.ACC_ID
							Where
							  tbl_transaction.DATE_OF_TRANSACTION Between '$from_date' And '$to_date' And
							  (tbl_account.PARENT_ACC_ID = 3 Or
								tbl_account.PARENT_ACC_ID = 4) And
							  tbl_transaction.DEL_FLAG = 1
							Group By
							  tbl_transaction.ACC_ID,
							  tbl_transaction.BOOK_NAME,
							  tbl_account.ACC_NAME
							 Order By
  tbl_account.ACC_NAME");
			   $this->load->view('form_profit_and_loss_table',$data);

	}
	
}
?>