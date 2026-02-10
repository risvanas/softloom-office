<?php
class Graph extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function index()
	{
		$date2=date('Y-m-d');
		$date1=date('Y-m-d',strtotime('-6 month'));
		$dis_year=date('Y',strtotime($date1));
		$dis_month=date('m',strtotime($date1));
		$data['sal_summary'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'SAL' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_SAL,
			(Select COALESCE(Sum(DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'INVOE' And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As D_SAL
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 and tbl_transaction.DATE_OF_TRANSACTION >='$date1' and tbl_transaction.DATE_OF_TRANSACTION <= '$date2' Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
   		$layout = array('page' => 'graph_view','title'=>'Dashboard','data'=>$data);	
		render_template($layout);
	  //$this->load->view('graph_view');	
	}
	function search_graph()
	{
		$from_date=$this->input->post('calc');
		$from_date=date('Y-m-d',strtotime($from_date));
		$to_date=$this->input->post('dat');
		$to_date=date('Y-m-d',strtotime($to_date));
		$category=$this->input->post('category');
		if($category == 'sal')
		{
			
		$data['sal_summary'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'SAL' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_SAL,
			(Select COALESCE(Sum(DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'INVOE' And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As D_SAL
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 and tbl_transaction.DATE_OF_TRANSACTION >='$from_date' and tbl_transaction.DATE_OF_TRANSACTION <= '$to_date' Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
			$data['rtyp']="SALES";
			
		}
		else
		{
			
			$data['sal_summary'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'PAY' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_SAL,
			(Select COALESCE(Sum(DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'PAYD' And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As D_SAL
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 and tbl_transaction.DATE_OF_TRANSACTION >='$from_date' and tbl_transaction.DATE_OF_TRANSACTION <= '$to_date' Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
			$data['rtyp']="PAYMENT";
		}
			$this->load->view('graph_view_search',$data);
	}
}
?>