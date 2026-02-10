<?php

class Graph extends MX_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $menu_id = 49;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $date2 = date('Y-m-d');
        $date1 = date('Y-m-d', strtotime('-6 month'));
        $dis_year = date('Y', strtotime($date1));
        $dis_month = date('m', strtotime($date1));
        $data['sal_summary'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'SAL' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_SAL,
			(Select COALESCE(Sum(DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'INVOE' And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As D_SAL
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 and tbl_transaction.DATE_OF_TRANSACTION >='$date1' and tbl_transaction.DATE_OF_TRANSACTION <= '$date2' Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
        $data['sal_return'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'SALRTN' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_RTN
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 and tbl_transaction.DATE_OF_TRANSACTION >='$date1' and tbl_transaction.DATE_OF_TRANSACTION <= '$date2' Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
        $data['dev_return'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'DRTN' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_RTN
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 and tbl_transaction.DATE_OF_TRANSACTION >='$date1' and tbl_transaction.DATE_OF_TRANSACTION <= '$date2' Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
        $layout = array('page' => 'graph_view', 'title' => 'Dashboard', 'data' => $data);
        render_template($layout);
        //$this->load->view('graph_view');	
    }

    function payment_graph() {
        $menu_id = 50;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $from_date = date('Y-m-d', strtotime('-6 month'));
        $to_date = date('Y-m-d');
        $from1 = date('Y-M-d', strtotime('-6 month'));
        $to1 = date('Y-M-d');
        $data['from'] = $from1;
        $data['to'] = $to1;
        $data['sal_summary'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'PAY' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_SAL,
			(Select COALESCE(Sum(DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'PAYD' And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As D_SAL,
				(Select COALESCE(Sum(CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME in ('CR','PV','BV') And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH and ACC_ID = 80) As O_SAL,
				(Select COALESCE(Sum(CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME in ('PV','BV') And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH and ACC_ID = 97) As B_SAL
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 and tbl_transaction.DATE_OF_TRANSACTION >='$from_date' and tbl_transaction.DATE_OF_TRANSACTION <= '$to_date' Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");

        $data['rtyp'] = "PAYMENT";
        //$this->load->view('graph_view_search',$data);
        $layout = array('page' => 'graph_view_payments', 'title' => 'Dashboard', 'data' => $data);
        render_template($layout);
    }

    function search_graph() {
        $from_date = $this->input->post('calc');
        $from1 = date('Y-M-d', strtotime($from_date));
        $data['from'] = $from1;
        $from_date = date('Y-m-d', strtotime($from_date));
        $to_date = $this->input->post('dat');
        $to1 = date('Y-M-d', strtotime($to_date));
        $data['to'] = $to1;
        $to_date = date('Y-m-d', strtotime($to_date));
        $category = $this->input->post('category');
        if ($category == 'sal') {

            $data['sal_summary'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'SAL' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_SAL,
			(Select COALESCE(Sum(DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'INVOE' And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As D_SAL
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 and tbl_transaction.DATE_OF_TRANSACTION >='$from_date' and tbl_transaction.DATE_OF_TRANSACTION <= '$to_date' Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
            $data['sal_return'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'SALRTN' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_RTN
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 and tbl_transaction.DATE_OF_TRANSACTION >='$from_date' and tbl_transaction.DATE_OF_TRANSACTION <= '$to_date' Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
            $data['dev_return'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'DRTN' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_RTN
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 and tbl_transaction.DATE_OF_TRANSACTION >='$from_date' and tbl_transaction.DATE_OF_TRANSACTION <= '$to_date' Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
            $data['rtyp'] = "SALES";
        } else {

            $data['sal_summary'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'PAY' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_SAL,
			(Select COALESCE(Sum(DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'PAYD' And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As D_SAL,
				(Select COALESCE(Sum(CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME in ('CR','PV','BV') And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH and ACC_ID = 80) As O_SAL,
				(Select COALESCE(Sum(CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME in ('PV','BV') And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH and ACC_ID = 97) As B_SAL
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 and tbl_transaction.DATE_OF_TRANSACTION >='$from_date' and tbl_transaction.DATE_OF_TRANSACTION <= '$to_date' Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");

            $data['rtyp'] = "PAYMENT";
        }
        $this->load->view('graph_view_search', $data);
    }

    function income_expenditure_graph() {
        $menu_id = 51;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $date2 = date('Y-m-d');
        $date1 = date('Y-m-d', strtotime('-6 month'));
        $dis_year = date('Y', strtotime($date1));
        $dis_month = date('m', strtotime($date1));
        $data['sal_summary'] = $this->db->query("Select Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,IFNULL( SUM( DEBIT ) , 0 ) as expen,IFNULL( SUM( CREDIT ) , 0 ) AS income,income_exp.ACC_NAME as acc_type FROM `tbl_transaction` join tbl_account on tbl_transaction.ACC_ID=tbl_account.ACC_ID join tbl_account as income_exp on tbl_account.PARENT_ACC_ID=income_exp.ACC_ID where tbl_account.PARENT_ACC_ID in(3,4) and tbl_transaction.DEL_FLAG=1 and tbl_transaction.DATE_OF_TRANSACTION>='$date1' and tbl_transaction.DATE_OF_TRANSACTION<='$date2' group by acc_type,Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
        $layout = array('page' => 'income_expenditure_view', 'title' => 'Dashboard', 'data' => $data);
        render_template($layout);
    }

    function search_income_graph() {
        $from_date = $this->input->post('calc');
        $from1 = date('Y-M-d', strtotime($from_date));
        $data['from'] = $from1;
        $from_date = date('Y-m-d', strtotime($from_date));
        $to_date = $this->input->post('dat');
        $to1 = date('Y-M-d', strtotime($to_date));
        $data['to'] = $to1;
        $to_date = date('Y-m-d', strtotime($to_date));
        $data['type'] = 'Income and Expenditure';
        $data['sal_summary'] = $this->db->query("Select Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,IFNULL( SUM( DEBIT ) , 0 ) as expen,IFNULL( SUM( CREDIT ) , 0 ) AS income,income_exp.ACC_NAME as acc_type FROM `tbl_transaction` join tbl_account on tbl_transaction.ACC_ID=tbl_account.ACC_ID join tbl_account as income_exp on tbl_account.PARENT_ACC_ID=income_exp.ACC_ID where tbl_account.PARENT_ACC_ID in(3,4) and tbl_transaction.DEL_FLAG=1 and tbl_transaction.DATE_OF_TRANSACTION>='$from_date' and tbl_transaction.DATE_OF_TRANSACTION<='$to_date' group by acc_type,Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
        $this->load->view('graph_View_income', $data);
    }

}

?>