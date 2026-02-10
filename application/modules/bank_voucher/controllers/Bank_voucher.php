<?php

class Bank_voucher extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->library('form_validation');
        $this->load->model('bank_model');
    }

    function index() {
        $menu_id = 31;
        $this->load->library('../controllers/permition_checker');
        $data['bank'] = $this->bank_model->select_acc_code('tbl_account');
        $this->form_validation->set_rules('txt_receipt_date', 'receipt date', 'required');
        if ($this->form_validation->run() != TRUE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $data['sub_acc_list'] = $this->bank_model->select_sub_acc('tbl_account');
            $data['msg'] = "";
            $data['errmsg'] = "";
            $layout = array('page' => 'form_bank_voucher', 'title' => 'Bank Voucher', 'data' => $data);
            render_template($layout);
        } else {
            $this->permition_checker->permition_addprocess($menu_id);
            $sess_array = $this->session->userdata('logged_in');
            $year_code = $sess_array['accounting_year'];
            $company = $sess_array['comp_code'];
            $receipt_date = $this->input->post('txt_receipt_date');
            $this->load->library('../controllers/lockdate');
            $this->lockdate->index($receipt_date);
            $check_status = $this->lockdate->check_date($receipt_date);
            $message_display = $this->lockdate->message_val($receipt_date, $check_status);
            if ($check_status == 'true') {
                $data['sub_acc_list'] = $this->bank_model->select_sub_acc('tbl_account');
                $data['msg'] = "";
                $data['errmsg'] = $message_display;
                $layout = array('page' => 'form_bank_voucher', 'title' => 'Bank Voucher', 'data' => $data);
                render_template($layout);
                return FALSE;
            }
            $n = $this->input->post('Num');
            if ($n == '2') {
                $data['sub_acc_list'] = $this->bank_model->select_sub_acc('tbl_account');
                $data['msg'] = "";
                $data['errmsg'] = "You have some form errors. Please check below.";
                $layout = array('page' => 'form_bank_voucher', 'title' => 'Bank Voucher', 'data' => $data);
                render_template($layout);
                return FALSE;
            }

            $temp_voc_num = $this->input->post('temp_voc_num');
            $bank_id = $this->input->post('sel_bank');
            $trans_type = $this->input->post('txt_trans_type');

            for ($i = 3; $i <= $n; $i++) {
                $amt = $this->input->post('amount' . $i);
                if ($amt == 0 || $amt == "") {
                    $data['bank'] = $this->bank_model->select_acc_code('tbl_account');
                    $data['sub_acc_list'] = $this->bank_model->select_sub_acc('tbl_account');
                    $data['msg'] = "";
                    $data['errmsg'] = "Amount is Not Valid";
                    $layout = array('page' => 'form_bank_voucher', 'title' => 'Bank Voucher', 'data' => $data);
                    render_template($layout);
                    return FALSE;
                }
            }

            if ($temp_voc_num != "") {
                $this->permition_checker->permition_editprocess($menu_id);
//                $query2 = $this->db->query("select ACC_YEAR_CODE from tbl_transaction where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='BV' AND DEL_FLAG=1 and COMPANY='$company'");
//                $val2 = $query2->row_array();
//                $acc_year = $val2['ACC_YEAR_CODE'];
                $acc_year = $this->input->post('acc_year');
                if ($year_code == $acc_year) {
                    $sess_array = $this->session->userdata('logged_in');
                    $modified_by = $sess_array['user_id'];
                    $this->load->library('../controllers/lockdate');
                    $location_details = $this->lockdate->location_details();
                    $modified_on = gmdate("Y-m-d H:i:s");
                    $this->db->query("update tbl_transaction set DEL_FLAG=0,MODIFIED_BY=$modified_by,MODIFIED_ON='$modified_on',LOCATION_DETAILS='$location_details' where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='BV' AND DEL_FLAG=1 and COMPANY='$company' and ACC_YEAR_CODE=$acc_year");
                    $book_num = $temp_voc_num;
                } else {
                    $data['sub_acc_list'] = $this->bank_model->select_sub_acc('tbl_account');
                    $data['msg'] = "";
                    $data['errmsg'] = "Accounting Year Do not Match";
                    $layout = array('page' => 'form_bank_voucher', 'title' => 'Bank Voucher', 'data' => $data);
                    render_template($layout);
                    return FALSE;
                }
            } else {
                $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='BV' and COMPANY='$company' and  ACC_YEAR_CODE=$year_code and DEL_FLAG=1");
                $row = $query->row_array();
                $book_num = $row['BOOK_NUMBER'];
            }

            for ($i = 3; $i <= $n; $i++) {
                $acc_id = $this->input->post('acc_id' . $i);
                $sub_acc_id = $this->input->post('sub_acc' . $i);
                $amt = $this->input->post('amount' . $i);
                $rem = $this->input->post('remarks' . $i);
                $course_name = $this->input->post('acc_name' . $i);
                $rvno = $this->input->post('txt_ref_voucher_no');
                $cash_to = $this->input->post('txt_cash_to');
                $receipt_date = $this->input->post('txt_receipt_date');
                $receipt_date = strtotime($receipt_date);
                $receipt_date = date("Y-m-d", $receipt_date);
                $query = $this->db->query("SELECT ACC_NAME FROM tbl_account WHERE ACC_ID='$sub_acc_id' ");
                $res = $query->row_array();
                $sub_name = $res['ACC_NAME'];

                if ($sub_name != "") {
                    $sub_acc_description = " - " . $sub_name;
                } else {
                    $sub_acc_description = "";
                }
                if ($rem != "") {
                    $description = " / " . $rem;
                } else {
                    $description = "";
                }

                //$remark="To Cash Payment - ".$course_name." ".$rem." ".$sub_acc_description;
                $sess_array = $this->session->userdata('logged_in');
                $create_by = $sess_array['user_id'];
                $this->load->library('../controllers/lockdate');
                $location_details = $this->lockdate->location_details();
                $create_on = gmdate("Y-m-d H:i:s");
                if ($trans_type == "Deposit") {
                    $remark_cashac = "Payment From  " . $course_name;
                    $remark = "Payment From  " . $course_name . $sub_acc_description . $description;

                    $data = array('FIN_YEAR_ID' => '2',
                        'ACC_ID' => $acc_id,
                        'DATE_OF_TRANSACTION' => $receipt_date,
                        'CREDIT' => $amt,
                        'REMARKS' => $remark,
                        'DESCRIPTION' => $rem,
                        'TRANS_TYPE' => $trans_type,
                        'BOOK_NUMBER' => $book_num,
                        'BOOK_NAME' => 'BV',
                        'REF_VOUCHERNO' => $rvno,
                        'SUB_ACC' => $sub_acc_id,
                        'ACC_YEAR_CODE' => $year_code,
                        'CASH_TO' => $cash_to,
                        'COMPANY' => $company,
                        'CREATED_BY' => $create_by,
                        'CREATED_ON' => $create_on,
                        'LOCATION_DETAILS' => $location_details);

                    $data2 = array('FIN_YEAR_ID' => '2',
                        'ACC_ID' => $bank_id,
                        'DATE_OF_TRANSACTION' => $receipt_date,
                        'DEBIT' => $amt,
                        'REMARKS' => $remark,
                        'DESCRIPTION' => $rem,
                        'TRANS_TYPE' => $trans_type,
                        'BOOK_NUMBER' => $book_num,
                        'BOOK_NAME' => 'BV',
                        'REF_VOUCHERNO' => $rvno,
                        'ACC_YEAR_CODE' => $year_code,
                        'CASH_TO' => $cash_to,
                        'COMPANY' => $company,
                        'CREATED_BY' => $create_by,
                        'CREATED_ON' => $create_on,
                        'LOCATION_DETAILS' => $location_details);
                } else {
                    $remark_cashac = "Payment To  " . $course_name;
                    $remarks = "Payment To  " . $course_name . $sub_acc_description . $description;

                    $data = array('FIN_YEAR_ID' => '2',
                        'ACC_ID' => $acc_id,
                        'DATE_OF_TRANSACTION' => $receipt_date,
                        'DEBIT' => $amt,
                        'REMARKS' => $remarks,
                        'DESCRIPTION' => $rem,
                        'TRANS_TYPE' => $trans_type,
                        'BOOK_NUMBER' => $book_num,
                        'BOOK_NAME' => 'BV',
                        'REF_VOUCHERNO' => $rvno,
                        'SUB_ACC' => $sub_acc_id,
                        'ACC_YEAR_CODE' => $year_code,
                        'CASH_TO' => $cash_to,
                        'COMPANY' => $company,
                        'CREATED_BY' => $create_by,
                        'CREATED_ON' => $create_on,
                        'LOCATION_DETAILS' => $location_details);

                    $data2 = array('FIN_YEAR_ID' => '2',
                        'ACC_ID' => $bank_id,
                        'DATE_OF_TRANSACTION' => $receipt_date,
                        'CREDIT' => $amt,
                        'REMARKS' => $remarks,
                        'DESCRIPTION' => $rem,
                        'TRANS_TYPE' => $trans_type,
                        'BOOK_NUMBER' => $book_num,
                        'BOOK_NAME' => 'BV',
                        'REF_VOUCHERNO' => $rvno,
                        'ACC_YEAR_CODE' => $year_code,
                        'CASH_TO' => $cash_to,
                        'COMPANY' => $company,
                        'CREATED_BY' => $create_by,
                        'CREATED_ON' => $create_on,
                        'LOCATION_DETAILS' => $location_details);
                }

                $this->bank_model->insert_data('tbl_transaction', $data);
                $this->bank_model->insert_data('tbl_transaction', $data2);
            }

            $data['bank'] = $this->bank_model->select_acc_code('tbl_account');
            $data['sub_acc_list'] = $this->bank_model->select_sub_acc('tbl_account');
            $data['msg'] = 'bank voucher added successfully';
//            $data['errmsg'] = "";
//            $layout = array('page' => 'form_bank_voucher', 'title' => 'Bank Voucher', 'data' => $data);
//            render_template($layout);
            redirect('bank_voucher');
        }
    }

    function account_list() {
        $acc_name = $this->input->post('name');
        $data['cond'] = $this->bank_model->select_All('tbl_account', $acc_name);
        $this->load->view('form_acclist', $data);
    }

    function add_list() {
        $acc_name = $this->input->post('name');
        $data['cond'] = $this->bank_model->select_All('tbl_account', $acc_name);
        $this->load->view('form_acclist', $data);
    }

    function select_data() {
        $sess_array = $this->session->userdata('logged_in');
        $company = $sess_array['comp_code'];
        $buk_num = $this->input->post('voc_no');
        $accounting_year = $this->input->post('accounting_year');
        $generate_pdf = $this->input->post('generate_pdf');
        $data['vno'] = $this->bank_model->select_info('tbl_transaction', $buk_num, $accounting_year);
        $data['company'] = $this->bank_model->select_company($company);
        if ($generate_pdf == 'generate_pdf') {
            $this->load->library('pdfgenerator');
//            $this->load->view('cash_receipt_pdf', $data);
            $html = $this->load->view('bank_voucher_pdf', $data, true);
            $filename = 'bank_voucher_' . time();
            $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
        } else {
            $this->load->view('form_displayData', $data);
        }
    }

    function del_data() {
        $menu_id = 31;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $sess_array = $this->session->userdata('logged_in');
        $year_code = $sess_array['accounting_year'];
        $buk_num = $this->input->post('txt_buk_num');
        $sess_array = $this->session->userdata('logged_in');
        $company_code = $sess_array['comp_code'];
        $query2 = $this->db->query("select ACC_YEAR_CODE,DATE_OF_TRANSACTION from tbl_transaction where BOOK_NUMBER=$buk_num AND BOOK_NAME='BV' AND DEL_FLAG=1 and COMPANY='$company_code'");
        $val2 = $query2->row_array();
        $acc_year = $val2['ACC_YEAR_CODE'];
        $this->load->library('../controllers/lockdate');
        $voucher_date = $val2['DATE_OF_TRANSACTION'];
        $check_status = $this->lockdate->check_date($voucher_date);
        $message_display = $this->lockdate->message_val($voucher_date, $check_status);
        if ($message_display == '') {
            $message_display = 'Accounting Year Do not Match';
        }
        if ($year_code == $acc_year && $check_status == 'false') {
            $sess_array = $this->session->userdata('logged_in');
            $deleted_by = $sess_array['user_id'];
            $this->load->library('../controllers/lockdate');
            $location_details = $this->lockdate->location_details();
            $deleted_on = gmdate("Y-m-d H:i:s");
            $data = array('DEL_FLAG' => '0',
                'DELETED_BY' => $deleted_by,
                'DELETED_ON' => $deleted_on,
                'LOCATION_DETAILS' => $location_details);
            $this->bank_model->delete_data1('tbl_transaction', $data, $buk_num);
        } else {
            $data['bank'] = $this->bank_model->select_acc_code('tbl_account');
            $data['sub_acc_list'] = $this->bank_model->select_sub_acc('tbl_account');
            $data['msg'] = "";
//            $data['errmsg'] = $message_display;
//            $layout = array('page' => 'form_bank_voucher', 'title' => 'Bank Voucher', 'data' => $data);
//            render_template($layout);
//            return FALSE;
            redirect('bank_voucher');
        }
    }

    function delete_data() {
        $menu_id = 31;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $sess_array = $this->session->userdata('logged_in');
        $year_code = $sess_array['accounting_year'];
        $buk_num = $this->uri->segment(3);
        $acc_year = $this->uri->segment(4);
        $sess_array = $this->session->userdata('logged_in');
        $company_code = $sess_array['comp_code'];
        $query2 = $this->db->query("select DATE_OF_TRANSACTION from tbl_transaction where BOOK_NUMBER=$buk_num AND BOOK_NAME='BV' AND DEL_FLAG=1 and COMPANY='$company_code' and ACC_YEAR_CODE=$acc_year");
        $val2 = $query2->row_array();
//        $acc_year = $val2['ACC_YEAR_CODE'];
        $this->load->library('../controllers/lockdate');
        $voucher_date = $val2['DATE_OF_TRANSACTION'];
        $check_status = $this->lockdate->check_date($voucher_date);
        $message_display = $this->lockdate->message_val($voucher_date, $check_status);
        if ($message_display == '') {
            $message_display = 'Accounting Year Do not Match';
        }
        if ($year_code == $acc_year && $check_status == 'false') {
            $sess_array = $this->session->userdata('logged_in');
            $deleted_by = $sess_array['user_id'];
            $this->load->library('../controllers/lockdate');
            $location_details = $this->lockdate->location_details();
            $deleted_on = gmdate("Y-m-d H:i:s");
            $data = array('DEL_FLAG' => '0',
                'DELETED_BY' => $deleted_by,
                'DELETED_ON' => $deleted_on,
                'LOCATION_DETAILS' => $location_details);
            $this->bank_model->delete_data1('tbl_transaction', $data, $buk_num, $acc_year);

            $data['bank'] = $this->bank_model->select_acc_code('tbl_account');
            $data['sub_acc_list'] = $this->bank_model->select_sub_acc('tbl_account');
            $data['msg'] = "bank voucher Delete successfully";
//            $data['errmsg'] = "";
//            $layout = array('page' => 'form_bank_voucher', 'title' => 'Bank Voucher', 'data' => $data);
//            render_template($layout);
            redirect('bank_voucher');
        } else {
            $data['bank'] = $this->bank_model->select_acc_code('tbl_account');
            $data['sub_acc_list'] = $this->bank_model->select_sub_acc('tbl_account');
            $data['msg'] = "";
            $data['errmsg'] = $message_display;
//            $layout = array('page' => 'form_bank_voucher', 'title' => 'Bank Voucher', 'data' => $data);
//            render_template($layout);
//            return FALSE;
//            echo "hai";
            redirect('bank_voucher');
        }
    }

}

?>