<?php
class Dashboard extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
	}
	
	function index()
	{
		$data['sal_summary'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'SAL' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_SAL,
			(Select COALESCE(Sum(DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'INVOE' And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As D_SAL
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
   		$layout = array('page' => 'welcome','title'=>'Dashboard','data'=>$data);	
		render_template($layout);

	}
	
	function paycanvas()
	{
		$data['pay_summary'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'PAY' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As TIAMT,
			(Select COALESCE(Sum(DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'PAYD' And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As DIAMT
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
		$this->load->view('form_paycanvas',$data);
	}
	function salcanvas()
	{
		$data['sal_summary'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'SAL' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_SAL,
			(Select COALESCE(Sum(DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'INVOE' And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As D_SAL
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
		$this->load->view('form_salcanvas',$data);
	}
}
?>