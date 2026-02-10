<?php

class Balance_sheet extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->load->helper('date');
        $this->template->set_template('admin_template');
        $this->load->model('balancesheet_model');
        $this->load->library('form_validation');
    }

    function index() {
        $menu_id = 41;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['company'] = $this->balancesheet_model->select_company();
        $layout = array('page' => 'form_balance_sheet_disp', 'title' => 'balance_sheet', 'data' => $data);
        render_template($layout);
    }

    function calculation() {
        $date_m = $this->input->post("date");
        $date_m = strtotime($date_m);
        $date_m = date('Y-m-d', $date_m);
        $company_code = $this->input->post('comp_code');
        $sql = "Select
            tbl_account.ACC_ID as acc,tbl_account.opening_balance as op,
            (Select
            Sum(tbl_transaction.DEBIT) As debit_sum
          From
            tbl_transaction where tbl_transaction.ACC_ID = acc and tbl_transaction.date_of_transaction<='$date_m' and tbl_account.acc_code='BS'";
        if ($company_code != "") {
            $sql .= " and tbl_transaction.COMPANY=$company_code";
        }
        $sql .= ") As Column1,
            (Select
            Sum(tbl_transaction.CREDIT) As creit_sum
          From
            tbl_transaction where tbl_transaction.ACC_ID = acc and tbl_transaction.date_of_transaction<='$date_m' and tbl_account.acc_code='BS' ";
        if ($company_code != "") {
            $sql .= " and tbl_transaction.COMPANY=$company_code";
        }
        $sql .= ") As Column2
          From
            tbl_account";
        $data['data_pass'] = $this->db->query($sql);

        //$data= $m->row_array();
        //echo $data['acc'];
        $this->load->view('form_balance_sheet_table.php', $data);
    }

    function balance_sheet_api() {
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('company_code', 'Company Code', 'trim');
        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $date_m = $this->input->post("date");
            $date_m = strtotime($date_m);
            $date_m = date('Y-m-d', $date_m);
            $company_code = $this->input->post('company_code');
            $sql = "Select
            tbl_account.ACC_ID as acc,tbl_account.acc_name, IFNULL(tbl_account.opening_balance, 0) as opening_balance,
            (Select
            IFNULL(Sum(tbl_transaction.DEBIT), 0) As debit_sum
          From
            tbl_transaction where tbl_transaction.ACC_ID = acc and tbl_transaction.date_of_transaction<='$date_m' and tbl_account.acc_code='BS'";
            if ($company_code != "") {
                $sql .= " and tbl_transaction.COMPANY=$company_code";
            }
            $sql .= ") As debit,
            (Select
            IFNULL(Sum(tbl_transaction.CREDIT), 0) As creit_sum
          From
            tbl_transaction where tbl_transaction.ACC_ID = acc and tbl_transaction.date_of_transaction<='$date_m' and tbl_account.acc_code='BS' ";
            if ($company_code != "") {
                $sql .= " and tbl_transaction.COMPANY=$company_code";
            }
            $sql .= ") As credit
          From
            tbl_account";
            $data['status'] = 1;
            $data['data'] = $this->db->query($sql)->result();
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

}

?>