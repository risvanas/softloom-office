<?php

class Income_and_expenditure extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->load->helper('date');
        $this->template->set_template('admin_template');
        $this->load->model('income_and_expenditure_model');
        $this->load->library('form_validation');
    }

    function index() {
        $menu_id = 45;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['company'] = $this->income_and_expenditure_model->select_company();
        $layout = array('page' => 'form_income_and_expenditure', 'title' => 'Income and Expenditure', 'data' => $data);
        render_template($layout);
    }

    function calculation() {
        $from_date = $this->input->post("from_date");
        $data['frm'] = $from_date;
        $from_date = strtotime($from_date);
        $from_date = date('Y-m-d', $from_date) . " to ";
        $data['from_date'] = $from_date;
        $to_date = $this->input->post("to_date");
        $company_code = $this->input->post('comp_code');
        $data['to'] = $to_date;
        $to_date = strtotime($to_date);
        $to_date = date('Y-m-d', $to_date);
        $data['to_date'] = $to_date;
        $generate_pdf = $this->input->post('generate_pdf');
        
        $sql = "SELECT IFNULL( SUM( DEBIT ) , 0 ) as expen,IFNULL( SUM( CREDIT ) , 0 ) AS income,income_exp.ACC_NAME as acc_type,tbl_account.ACC_NAME as a_name FROM `tbl_transaction` join tbl_account on tbl_transaction.ACC_ID=tbl_account.ACC_ID join tbl_account as income_exp on tbl_account.PARENT_ACC_ID=income_exp.ACC_ID where tbl_account.PARENT_ACC_ID in(3,4) and tbl_transaction.DEL_FLAG=1 and tbl_transaction.DATE_OF_TRANSACTION>='$from_date' and tbl_transaction.DATE_OF_TRANSACTION<='$to_date'";
        If($company_code != "") {
            $sql .= " and tbl_transaction.COMPANY=$company_code";
        }
        $sql .= " group by tbl_account.ACC_ID";
        $data['data_pass'] = $this->db->query($sql);
        $data['company'] = $this->income_and_expenditure_model->select_company($company);

        if ($generate_pdf == 'generate_pdf') {
            $this->load->library('pdfgenerator');
            $html = $this->load->view('income_and_expenditure_pdf', $data, true);
            $filename = 'income_and_expenditure_report_' . time();
            $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
        } else if ($generate_pdf == 'generate_excel') {
            $filename = 'income_and_expenditure_report_' . time() . '.xls';
            $html = $this->load->view('income_and_expenditure_excel', $data, true);
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$filename");
            echo $html;
        } else {
            $this->load->view('form_profit_and_loss', $data);
        }
    }
    
    function income_and_expenditure_api() {
        $this->form_validation->set_rules('fromdate', 'Fromdate', 'trim|required');
        $this->form_validation->set_rules('todate', 'Todate', 'trim|required');
        $this->form_validation->set_rules('company_code', 'Company Code', 'trim');
        if ($this->form_validation->run() == FALSE) {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $from_date = $this->input->post('fromdate');
            $to_date = $this->input->post('todate');
            $company_code = $this->input->post('company_code');
            $data['status'] = 1;
            $data['frm'] = $from_date;
            $data['to'] = $to_date;
            $data['company_code'] = $company_code;
            // $rdate=substr($calc,0,10);
            $rdate = strtotime($from_date);
            $from_date = date("Y-m-d", $rdate);
            // $ddate=substr($calc,12);
            $ddate = strtotime($to_date);
            $to_date = date("Y-m-d", $ddate);
            $sql = "SELECT IFNULL( SUM( DEBIT ) , 0 ) as expen,IFNULL( SUM( CREDIT ) , 0 ) AS income,income_exp.ACC_NAME as acc_type,tbl_account.ACC_NAME as a_name FROM `tbl_transaction` join tbl_account on tbl_transaction.ACC_ID=tbl_account.ACC_ID join tbl_account as income_exp on tbl_account.PARENT_ACC_ID=income_exp.ACC_ID where tbl_account.PARENT_ACC_ID in(3,4) and tbl_transaction.DEL_FLAG=1 and tbl_transaction.DATE_OF_TRANSACTION>='$from_date' and tbl_transaction.DATE_OF_TRANSACTION<='$to_date'";
            If($company_code != "") {
                $sql .= " and tbl_transaction.COMPANY=$company_code";
            }
            $sql .= " group by tbl_account.ACC_ID";
            $data['data'] = $this->db->query($sql)->result();
            if(count($data['data']) > 0) {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                unset($result['data']);
                $result['status'] = 0;
                $result['msg'] = 'No Data Found';
                header('Content-Type: application/json');
                echo json_encode($result);
            }
        }
    }

}

?>