<?php

class Trialbalance extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->load->helper('date');
        $this->template->set_template('admin_template');
        $this->load->model('trialbalance_model');
        $this->load->library('encryption');
        $this->load->library('form_validation');
    }

    function index() {
        $menu_id = 39;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['company'] = $this->trialbalance_model->select_company();
        $layout = array('page' => 'form_trialbal_disp', 'title' => 'trial_balance', 'data' => $data);
        render_template($layout);
    }

    function calculation() {
        $date_m = $this->input->post("date");
        $date_m = strtotime($date_m);
        $data['from_date'] = date('Y-m-d', $date_m);
        $generate_pdf = $this->input->post('generate_pdf');
        $company_code = $this->input->post('comp_code');
        $data['company_code'] = $company_code;
        $date_n = $this->input->post("to_date");
        $date_n = strtotime($date_n);
        $data['next_date'] = date('Y-m-d', $date_n);
        /* $data['data_pass']=$this->db->query("Select
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
          tbl_account"); */
        $data['data_pass'] = $this->db->query("Select tbl_account.ACC_ID ,tbl_account.ACC_NAME,tbl_account.OPENING_BALANCE,parent_account.ACC_NAME as p_name from tbl_account left join tbl_account as parent_account on tbl_account.PARENT_ACC_ID=parent_account.ACC_ID where tbl_account.ACC_ID not in(1,2,3,4) and tbl_account.DEL_FLAG =1 and tbl_account.TYPE ='M'");
        $data['company'] = $this->trialbalance_model->select_company($company_code);
        //$data= $m->row_array();
        //echo $data['acc'];

        if ($generate_pdf == 'generate_pdf') {
            $this->load->library('pdfgenerator');
            $html = $this->load->view('trialbalance_pdf', $data, true);
            $filename = 'trialbalance_report_' . time();
            $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
        } else if ($generate_pdf == 'generate_excel') {
            $filename = 'trialbalance_report_' . time() . '.xls';
            $html = $this->load->view('trialbalance_excel', $data, true);
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$filename");
            echo $html;
        } else {
            $this->load->view('form_trialbal_disp_table.php', $data);
        }
    }

    function mail_trialbalance() {
        $html_table = $this->input->post('mail_data');
        $to = $this->input->post('to_mail');

        $subject = $this->input->post('mail_sub');
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <info@softloom.com>' . "\r\n";

        mail($to, $subject, $html_table, $headers);
    }

    function view_details() {
        $acc_name = $this->uri->segment(3);
        $acc_name = str_replace("~", "/", $acc_name);
        $acc_name = str_replace("-", "=", $acc_name);
        $acc_name = str_replace(".", "+", $acc_name);
        $acc_name = $this->encryption->decrypt($acc_name);
        $from_date = $this->uri->segment(4);
        $from_date = str_replace("~", "/", $from_date);
        $from_date = str_replace("-", "=", $from_date);
        $from_date = str_replace(".", "+", $from_date);
        $from_date = $this->encryption->decrypt($from_date);
        if ($from_date != '') {
            $from_date = date('Y-m-d', strtotime($from_date));
        }
        $to_date = $this->uri->segment(5);
        $to_date = str_replace("~", "/", $to_date);
        $to_date = str_replace("-", "=", $to_date);
        $to_date = str_replace(".", "+", $to_date);
        $to_date = $this->encryption->decrypt($to_date);
        if ($to_date != '') {
            $to_date = date('Y-m-d', strtotime($to_date));
        }
        $company_code = $this->uri->segment(6);
        $company_code = str_replace("~", "/", $company_code);
        $company_code = str_replace("-", "=", $company_code);
        $company_code = str_replace(".", "+", $company_code);
        $company_code = $this->encryption->decrypt($company_code);
        
        $data['acc'] = $acc_name;
        $data['sub'] = '';
        $data['frm'] = $from_date;
        $data['to'] = $to_date;
        $open_sql = "SELECT IFNULL( SUM( DEBIT ) , 0 ) - IFNULL( SUM( CREDIT ) , 0 ) AS opening
			  	FROM tbl_transaction
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  '$acc_name' ";
        if($from_date != "" && $from_date != '1970-01-01') {
            $open_sql .= "AND tbl_transaction.DATE_OF_TRANSACTION < '$from_date' ";
        }
        if($to_date != "" && $to_date != '1970-01-01') {
            $open_sql .= "AND tbl_transaction.DATE_OF_TRANSACTION < '$to_date'";
        }
        if ($company_code != "") {
            $open_sql .= "and COMPANY=$company_code";
        }
        $openings = $this->db->query($open_sql);
        $balance = $this->db->query("SELECT OPENING_BALANCE AS balance FROM tbl_account WHERE tbl_account.DEL_FLAG='1' AND tbl_account.ACC_ID='$acc_name'");

        $opening = $openings->row_array();
        $balance1 = $balance->row_array();
        $opening['opening'];
        $balance1['balance'];
        $data['opening_balance'] = $balance1['balance'] + $opening['opening'];
        $data['sel'] = $this->trialbalance_model->multi_search($acc_name, $from_date, $to_date, $company_code);
        //$this->load->view('form_ledger_list',$data);
        $layout = array('page' => 'form_ledger_list', 'title' => 'Finance', 'data' => $data);
        render_template($layout);
    }

}

?>