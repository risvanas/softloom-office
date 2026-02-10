<?php

class Day_book extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->model('day_book_model');
    }

    function index() {
        $menu_id = 34;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['company'] = $this->day_book_model->select_company();
        $layout = array('page' => 'form_daybook', 'title' => 'DAYBOOK', 'data' => $data);
        render_template($layout);
    }

    function diff_date() {
        $from_date = $this->input->post('fromdate');
        $to_date = $this->input->post('todate');
        $generate_pdf = $this->input->post('generate_pdf');
        $company_code = $this->input->post('comp_code');
        $data['frm'] = $from_date;
        $data['to'] = $to_date;
        $data['company_code'] = $company_code;
        // $rdate=substr($calc,0,10);
        $rdate = strtotime($from_date);
        $from_date = date("Y-m-d", $rdate);
        // $ddate=substr($calc,12);
        $ddate = strtotime($to_date);
        $to_date = date("Y-m-d", $ddate);
        $sql = "SELECT IFNULL( SUM( CREDIT ) , 0 ) - IFNULL( SUM( DEBIT ) , 0 ) AS opening FROM tbl_transaction WHERE tbl_transaction.DEL_FLAG =  '1' AND tbl_transaction.ACC_ID != 39 AND tbl_transaction.DATE_OF_TRANSACTION < '$from_date' ";
        if ($company_code != "") {
            $sql .= "and COMPANY=$company_code";
        }
        $openings = $this->db->query($sql);
        //$openings = $this->db->query("SELECT IFNULL( SUM( CREDIT ) , 0 ) - IFNULL( SUM( DEBIT ) , 0 ) AS opening FROM tbl_transaction WHERE tbl_transaction.DEL_FLAG =  '1' AND tbl_transaction.ACC_ID != 39 AND tbl_transaction.DATE_OF_TRANSACTION < '$from_date' ");

        $opening = $openings->row_array();
        $opening['opening'];
        //echo "<br>";
        $balance = $this->db->query("SELECT IFNULL( SUM(OPENING_BALANCE), 0) AS balance FROM tbl_account WHERE tbl_account.DEL_FLAG='1' AND tbl_account.ACC_ID =39 ");

        $balance1 = $balance->row_array();
        $balance1['balance'];

        $data['company'] = $this->day_book_model->select_company($company_code);
        //echo "<br>";
        $data['opening_balance'] = $balance1['balance'] + $opening['opening'];

        $data['list'] = $this->day_book_model->diff_date($from_date, $to_date, $company_code);
        if ($generate_pdf == 'generate_pdf') {
            $this->load->library('pdfgenerator');
            $html = $this->load->view('daybook_pdf', $data, true);
            $filename = 'daybook_report_' . time();
            $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
        } else if ($generate_pdf == 'generate_excel') {
            $filename = 'daybook_report_' . time() . '.xls';
            $html = $this->load->view('daybook_excel', $data, true);
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$filename");
            echo $html;
        } else {
            $this->load->view('form_viewdaybook3', $data);
        }
    }

    function day_book_api() {
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
            $sql = "SELECT IFNULL( SUM( CREDIT ) , 0 ) - IFNULL( SUM( DEBIT ) , 0 ) AS opening FROM tbl_transaction WHERE tbl_transaction.DEL_FLAG =  '1' AND tbl_transaction.ACC_ID != 39 AND tbl_transaction.DATE_OF_TRANSACTION < '$from_date' ";
            if ($company_code != "") {
                $sql .= "and COMPANY=$company_code";
            }
            $openings = $this->db->query($sql);
            //$openings = $this->db->query("SELECT IFNULL( SUM( CREDIT ) , 0 ) - IFNULL( SUM( DEBIT ) , 0 ) AS opening FROM tbl_transaction WHERE tbl_transaction.DEL_FLAG =  '1' AND tbl_transaction.ACC_ID != 39 AND tbl_transaction.DATE_OF_TRANSACTION < '$from_date' ");

            $opening = $openings->row_array();
            $opening['opening'];
            //echo "<br>";
            $balance = $this->db->query("SELECT IFNULL( SUM(OPENING_BALANCE), 0) AS balance FROM tbl_account WHERE tbl_account.DEL_FLAG='1' AND tbl_account.ACC_ID =39 ");

            $balance1 = $balance->row_array();
            $balance1['balance'];
            //echo "<br>";
            $opening_balance = $balance1['balance'] + $opening['opening'];

            $list = $this->day_book_model->diff_date($from_date, $to_date, $company_code);
            foreach ($list->result() as $key => $value) {
                $date = $value->DATE_OF_TRANSACTION;
                $sql1 = "Select
                            tbl_transaction.BOOK_NAME,
                            tbl_transaction.BOOK_NUMBER,
                            tbl_transaction.ACC_ID,
                            tbl_account.ACC_NAME,
                            tbl_account.ACC_CODE,
                            tbl_transaction.SUB_ACC,
                            tbl_account1.ACC_NAME As SUB_ACC_NAME,
                            tbl_transaction.CREDIT,
                            tbl_transaction.DEBIT,
                            tbl_transaction.FIN_YEAR_ID,
                            tbl_transaction.REMARKS,
                            tbl_transaction.TRANS_TYPE,
                            tbl_transaction.DEL_FLAG,
                            tbl_transaction.SRC_ID,
                            tbl_transaction.REF_VOUCHERNO,
                            tbl_transaction.PAYMENT_ID,
                            tbl_transaction.ACC_YEAR_CODE,
                            tbl_transaction.DATE_OF_TRANSACTION
                          From
                            tbl_transaction Left Join
                            tbl_account On tbl_transaction.ACC_ID =
                              tbl_account.ACC_ID Left Join
                            tbl_account tbl_account1
                              On tbl_transaction.SUB_ACC = tbl_account1.ACC_ID
                          Where
                            tbl_transaction.DEL_FLAG = '1' And
                            tbl_transaction.ACC_ID != 39 And
                              tbl_transaction.DATE_OF_TRANSACTION = '$date'";
                if ($company_code != "") {
                    $sql1 .= " and COMPANY=$company_code";
                }
                $sql1 .= " Order By tbl_transaction.DATE_OF_TRANSACTION";
                $query1 = $this->db->query($sql1);
                $day_book_details[$date] = $query1->result();
            }
            // $opening_balance = $data['opening_balance'];
            foreach ($day_book_details as $key => $value) {
                $totreceipt = 0.0;
                $totpayment = 0.0;
                $debitsum = 0.0;
                $sum_receipt = 0;
                $details[$key]['data'] = $value;
                $temp_opening_balance = $opening_balance;
                if ($opening_balance > 0) {
                    $details[$key]['opening_balance'] = $opening_balance . " Db.";
                }
                else if ($opening_balance < 0) {
                    $details[$key]['opening_balance'] = abs($opening_balance) . " Cr.";
                }
                else {
                    $details[$key]['opening_balance'] = $opening_balance;
                }
                foreach ($value as $key1 => $rs) {
                    $sum_receipt+=$rs->CREDIT;
                    $totreceipt+=$rs->CREDIT;
                    $totpayment+=$rs->DEBIT;
                    $opening_balance+=$rs->CREDIT - $rs->DEBIT;
                }
                if ($opening_balance > 0) {
                    $details[$key]['closing_balance'] = $opening_balance . " Db.";
                }
                else if ($opening_balance < 0) {
                    $details[$key]['closing_balance'] = abs($opening_balance) . " Cr.";
                }
                else {
                    $details[$key]['closing_balance'] = $opening_balance;
                }
                $debitsum+=$totpayment + $opening_balance;
                $details[$key]['receipt_total'] = $sum_receipt + $temp_opening_balance;
                $temp_opening_balance = 0;
                $details[$key]['debitsum'] = $debitsum;
            }
            $data['list'] = $details;
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }
    
}

?>