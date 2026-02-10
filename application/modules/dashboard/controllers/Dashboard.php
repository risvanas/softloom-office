<?php

class Dashboard extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->model('dashboard_model');
        $session_data = $this->session->userdata('logged_in');
        if ($session_data['user_id'] == '') {
            redirect(base_url());
        }
    }

    function index() {
        /* $data['sal_summary'] = $this->db->query("Select
          Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
          Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
          (Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'SAL' And
          Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_SAL,
          (Select COALESCE(Sum(DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'INVOE' And
          Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As D_SAL
          From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
          Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH"); */
        $layout = array('page' => 'welcome', 'title' => 'Dashboard');
        render_template($layout);
    }

    function paycanvas() {
        $data['pay_summary'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'PAY' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As TIAMT,
			(Select COALESCE(Sum(DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'PAYD' And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As DIAMT
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
        $this->load->view('form_paycanvas', $data);
    }

    function salcanvas() {
        $data['sal_summary'] = $this->db->query("Select
  			Year(tbl_transaction.DATE_OF_TRANSACTION) As YEAR,
  			Month(tbl_transaction.DATE_OF_TRANSACTION) As MONTH,
  			(Select COALESCE(Sum(tbl_transaction.CREDIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'SAL' And
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As T_SAL,
			(Select COALESCE(Sum(DEBIT),0) From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 And tbl_transaction.BOOK_NAME = 'INVOE' And 
    			Year(tbl_transaction.DATE_OF_TRANSACTION) = YEAR And Month(tbl_transaction.DATE_OF_TRANSACTION) = MONTH) As D_SAL
			From tbl_transaction Where tbl_transaction.DEL_FLAG = 1 Group By Year(tbl_transaction.DATE_OF_TRANSACTION),
			Month(tbl_transaction.DATE_OF_TRANSACTION) Order By YEAR, MONTH");
        $this->load->view('form_salcanvas', $data);
    }

    function log_details() {
        $menu_id = 70;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['staff_list'] = $this->dashboard_model->selectStaff();
        $from_date = date('Y-m-d') . " 00:00:00";
        $to_date = date('Y-m-d H:i:s');
        $data['cond'] = $this->dashboard_model->select_log_details($from_date, $to_date, '');
//        echo "<pre>";
//        print_r($data);exit();
        $layout = array('page' => 'form_login_details_list', 'title' => 'Login details', 'data' => $data);
        render_template($layout);
    }
    
    function mult_search() {
        $menu_id = 70;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $staff = $this->input->post('staff');
        $from_date = $this->input->post('fromdate');
        $to_date = $this->input->post('todate');
        $from_date = strtotime($from_date);
        $from = date("Y-m-d", $from_date);
        $to_date = strtotime($to_date);
        $to = date("Y-m-d", $to_date);
        $data['staff'] = $staff;
        $data['from_date'] = $this->input->post('fromdate');
        $data['to_date'] = $this->input->post('todate');
        $data['cond'] = $this->dashboard_model->select_log_details($from, $to, $staff);
        $this->load->view('form_search_list', $data);
    }
    
    function remove_recurring_invoice() {
        //ob_start();
//        $menu_id = 13;
//        $this->load->library('../controllers/permition_checker');
//        $this->permition_checker->permition_deleteprocess($menu_id);
        $id = $this->uri->segment(3);
//        $sess_array = $this->session->userdata('logged_in');
//        $deleted_by = $sess_array['user_id'];
//        $this->load->library('../controllers/lockdate');
//        $location_details = $this->lockdate->location_details();
//        $deleted_on = gmdate("Y-m-d H:i:s");
        $dat = array('REC_COMPLETE_FLAG' => '0');
        $this->dashboard_model->delete('tbl_invoice', $id, $dat);
        redirect('dashboard');
//        $this->mainaccount_list();
    }

}

?>