<?php
class Accounting_year_income extends MX_Controller
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
		/* $menu_id=45;
         $this->load->library('../controllers/permition_checker');
    		 $this->permition_checker->permition_viewprocess($menu_id); */
			 $data['year_data']=$this->db->query("select tbl_accounting_year.YEAR_CODE as code,tbl_accounting_year.FROM_DATE as st_date,tbl_accounting_year.TO_DATE as end_date,(SELECT IFNULL( SUM( CREDIT ) , 0 ) FROM `tbl_transaction` join tbl_account on tbl_transaction.ACC_ID=tbl_account.ACC_ID join tbl_account as income_exp on tbl_account.PARENT_ACC_ID=income_exp.ACC_ID where tbl_account.PARENT_ACC_ID in(3) and tbl_transaction.DEL_FLAG=1 and tbl_transaction.DATE_OF_TRANSACTION>=st_date and tbl_transaction.DATE_OF_TRANSACTION<=end_date) as income from tbl_accounting_year where tbl_accounting_year.DEL_FLAG=1 group by code");
		$layout = array('page' => 'form_accountingyear_income','title'=>'Accounting Year Income','data'=>$data);	
		render_template($layout);
	}
	function year_growth()
	{
			 $data['growth']=$this->db->query("select tbl_accounting_year.YEAR_CODE as code,tbl_accounting_year.FROM_DATE as st_date,tbl_accounting_year.TO_DATE as end_date,(SELECT IFNULL( SUM( CREDIT ) , 0 ) FROM `tbl_transaction` join tbl_account on tbl_transaction.ACC_ID=tbl_account.ACC_ID join tbl_account as income_exp on tbl_account.PARENT_ACC_ID=income_exp.ACC_ID where tbl_account.PARENT_ACC_ID in(3) and tbl_transaction.DEL_FLAG=1 and tbl_transaction.DATE_OF_TRANSACTION>=st_date and tbl_transaction.DATE_OF_TRANSACTION<=end_date) as income from tbl_accounting_year where tbl_accounting_year.DEL_FLAG=1 group by code");
		$layout = array('page' => 'form_growth_graph','title'=>'Business_growth','data'=>$data);	
		render_template($layout);
	}
}
?>