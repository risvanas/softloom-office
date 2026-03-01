<?php

class Feecollection extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->model('fee_model');
    }

    function index()
    {
        $menu_id = 32;
        $this->load->library('../controllers/permition_checker');
        $data['parent_account'] = $this->fee_model->selectAll('tbl_account');
        $data['r'] = $this->fee_model->select_st_name('tbl_student');
        $data['s'] = $this->fee_model->select_acc_type('tbl_account');
        $data['errmsg'] = $this->session->flashdata('errmsg') ?? "";
        $data['msg'] = $this->session->flashdata('msg') ?? "";
        $this->form_validation->set_rules('txt_payment_date', 'Payment Date', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $data['success'] = 0;
            $layout = array('page' => 'form_fee_collection', 'title' => 'Feecollection', 'data' => $data);
            render_template($layout);
        } else {
            $this->permition_checker->permition_addprocess($menu_id);
            $sess_array = $this->session->userdata('logged_in');
            $year_code = $sess_array['accounting_year'];
            $company_code = $sess_array['comp_code'];
            $pay_date = $this->input->post('txt_payment_date');
            $this->load->library('../controllers/lockdate');
            $this->lockdate->index($pay_date);
            $check_status = $this->lockdate->check_date($pay_date);
            $message_display = $this->lockdate->message_val($pay_date, $check_status);
            if ($check_status == 'true') {
                $data['msg'] = '';
                $data['errmsg'] = $message_display;
                $data['success'] = 0;
                $layout = array('page' => 'form_fee_collection', 'title' => 'Feecollection', 'data' => $data);
                render_template($layout);
                return FALSE;
            }

            $query = $this->db->query("SELECT IFNULL(MAX(PAY_NUMBER), 100)+1 AS PAY_NUMBER
                    FROM tbl_payment WHERE TYPE='STD' and COMPANY='$company_code' and  ACC_YEAR_CODE=$year_code and DEL_FLAG=1");

            $row = $query->row_array();
            $pay_num = $row['PAY_NUMBER'];

            $invoice_type = $this->input->post('invoice_type');
            $name = $this->input->post('txt_stud_name');
            $course = $this->input->post('txt_course');
            $pay_date = $this->input->post('txt_payment_date');
            $pay_date = strtotime($pay_date);
            $pay_date = date("Y-m-d", $pay_date);
            $due_date = $this->input->post('txt_due_date');
            $due_date = strtotime($due_date);
            $due_date = date("Y-m-d", $due_date);
            $amt = $this->input->post('txt_amount');
            $trans_type = $this->input->post('txt_trans_type');
            $payment_type = $this->input->post('txt_payment_type');
            $chq_no = $this->input->post('txt_cheque_no');
            $chq_date = $this->input->post('txt_cheque_date');
            $chq_date = strtotime($chq_date);
            $chq_date = date("Y-m-d", $chq_date);
            $accnt_no = $this->input->post('txt_accnt_no');
            $bank_id = $this->input->post('sel_bank');
            $entry_date = date('Y-m-d');
            //$query=$this->db->query("SELECT NAME FROM tbl_student where STUDENT_ID=$name ");
            //$row = $query->row_array();
            $stud_name = $this->input->post('lbl_stud_name');
            $sess_array = $this->session->userdata('logged_in');
            $create_by = $sess_array['user_id'];
            $this->load->library('../controllers/lockdate');
            $location_details = $this->lockdate->location_details();
            $create_on = gmdate("Y-m-d H:i:s");

            $sgst_percent = 9;
            $cgst_percent = 9;

            // Calculate GST based on invoice type
            if ($invoice_type == 'with_tax') {

                $total_tax_percent = ($sgst_percent + $cgst_percent) / 100;
                $base_amount = $amt / (1 + $total_tax_percent);

                $sgst_amt = $base_amount * ($sgst_percent / 100);
                $cgst_amt = $base_amount * ($cgst_percent / 100);

                $sub_total_amt = $base_amount;
            } else {
                $sgst_amt = 0;
                $cgst_amt = 0;
                $sub_total_amt = $amt;
            }

            $start_number = ($invoice_type == 'with_tax') ? 100 : 0;

            $paymentData = $this->db->select("IFNULL(MAX(BOOK_NUMBER), $start_number) + 1 AS BOOK_NUMBER", false)
                ->from('tbl_transaction')
                ->where([
                    'ACC_YEAR_CODE' => $year_code,
                    'DEL_FLAG'      => 1,
                    'INVOICE_TYPE'  => $invoice_type,
                    'COMPANY'       => $company_code
                ])
                ->get()
                ->row_array();

            $pay_data = array(
                'PAY_NUMBER' => $pay_num,
                'BOOK_NUMBER' => $paymentData['BOOK_NUMBER'] ?? $start_number + 1,
                'INVOICE_TYPE' => $invoice_type,
                'STUDENT_ID' => $name,
                'DEL_FLAG' => 1,
                'AMOUNT' => $amt,
                'SUB_TOTAL_PRICE' => $sub_total_amt,
                'SGST_PERCENT' => $sgst_percent,
                'CGST_PERCENT' => $cgst_percent,
                'SGST_AMOUNT' => $sgst_amt,
                'CGST_AMOUNT' => $cgst_amt,
                'TRANSACTION_TYPE' => $trans_type,
                'PAYMENT_TYPE' => $payment_type,
                'ENTRY_DATE' => $entry_date,
                'PAYMENT_DATE' => $pay_date,
                'DUE_DATE' => $due_date,
                'CHEQUE_NUMBER' => $chq_no,
                'CHEQUE_DATE' => $chq_date,
                'ACCOUNT_NUMBER' => $accnt_no,
                'BANK' => $bank_id,
                /* 'REMARKS'=>'ADVANCE', */
                'TYPE' => 'STD',
                'FIN_YEAR_ID' => 2,
                'ACC_YEAR_CODE' => $year_code,
                'COMPANY' => $company_code,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details
            );
            $this->fee_model->trans_ins('tbl_payment', $pay_data);
            $pay_id = $this->db->insert_id();

            $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER
                    FROM tbl_transaction WHERE BOOK_NAME='PAY' and COMPANY='$company_code' and  ACC_YEAR_CODE=$year_code and DEL_FLAG=1");

            $row = $query->row_array();

            if ($trans_type == "cash") {
                $book_num = $row['BOOK_NUMBER'];
                $remarks = "Cash from" . " " . $stud_name . " " . "(Course Fee)";
                $ceredt_data = array(
                    'FIN_YEAR_ID' => 2,
                    'INVOICE_TYPE' => $invoice_type,
                    'ACC_ID' => 38,
                    'DATE_OF_TRANSACTION' => $pay_date,
                    'CREDIT' => $amt,
                    'REMARKS' => $remarks,
                    'TRANS_TYPE' => $trans_type,
                    'DEL_FLAG' => 1,
                    'BOOK_NUMBER' => $book_num,
                    'BOOK_NAME' => 'PAY',
                    'SRC_ID' => $name,
                    'SUB_ACC' => $course,
                    'PAYMENT_ID' => $pay_id,
                    'ACC_YEAR_CODE' => $year_code,
                    'COMPANY' => $company_code,
                    'CREATED_BY' => $create_by,
                    'CREATED_ON' => $create_on,
                    'LOCATION_DETAILS' => $location_details,
                    'TRANSACTION_DATE' => $entry_date
                );

                $debit_data = array(
                    'FIN_YEAR_ID' => 2,
                    'INVOICE_TYPE' => $invoice_type,
                    'ACC_ID' => 39,
                    'DATE_OF_TRANSACTION' => $pay_date,
                    'DEBIT' => $amt,
                    'REMARKS' => $remarks,
                    'TRANS_TYPE' => $trans_type,
                    'DEL_FLAG' => 1,
                    'BOOK_NUMBER' => $book_num,
                    'BOOK_NAME' => 'PAY',
                    'SRC_ID' => $name,
                    'PAYMENT_ID' => $pay_id,
                    'ACC_YEAR_CODE' => $year_code,
                    'COMPANY' => $company_code,
                    'CREATED_BY' => $create_by,
                    'CREATED_ON' => $create_on,
                    'LOCATION_DETAILS' => $location_details,
                    'TRANSACTION_DATE' => $entry_date
                );

                $this->fee_model->trans_ins('tbl_transaction', $ceredt_data);
                $this->fee_model->trans_ins('tbl_transaction', $debit_data);
            }

            if ($trans_type == "bank") {
                $book_num = $row['BOOK_NUMBER'];
                //$query=$this->db->query("SELECT ACC_ID FROM tbl_account where ACC_CODE=$bank");  
                //$row = $query->row_array();
                //$bank_accid=$row['ACC_ID'];
                $remarks = $stud_name . " " . "(Course Fee) " . $chq_no;
                $ceredt_data = array(
                    'FIN_YEAR_ID' => 2,
                    'INVOICE_TYPE' => $invoice_type,
                    'ACC_ID' => 38,
                    'DATE_OF_TRANSACTION' => $pay_date,
                    'CREDIT' => $amt,
                    'REMARKS' => $remarks,
                    'TRANS_TYPE' => $trans_type,
                    'DEL_FLAG' => 1,
                    'BOOK_NUMBER' => $book_num,
                    'BOOK_NAME' => 'PAY',
                    'SRC_ID' => $name,
                    'SUB_ACC' => $course,
                    'PAYMENT_ID' => $pay_id,
                    'ACC_YEAR_CODE' => $year_code,
                    'COMPANY' => $company_code,
                    'CREATED_BY' => $create_by,
                    'CREATED_ON' => $create_on,
                    'LOCATION_DETAILS' => $location_details,
                    'TRANSACTION_DATE' => $entry_date
                );

                $debit_data = array(
                    'FIN_YEAR_ID' => 2,
                    'INVOICE_TYPE' => $invoice_type,
                    'ACC_ID' => $bank_id,
                    'DATE_OF_TRANSACTION' => $pay_date,
                    'DEBIT' => $amt,
                    'REMARKS' => $remarks,
                    'TRANS_TYPE' => $trans_type,
                    'DEL_FLAG' => 1,
                    'BOOK_NUMBER' => $book_num,
                    'BOOK_NAME' => 'PAY',
                    'SRC_ID' => $name,
                    'PAYMENT_ID' => $pay_id,
                    'ACC_YEAR_CODE' => $year_code,
                    'COMPANY' => $company_code,
                    'CREATED_BY' => $create_by,
                    'CREATED_ON' => $create_on,
                    'LOCATION_DETAILS' => $location_details,
                    'TRANSACTION_DATE' => $entry_date
                );
                $this->fee_model->trans_ins('tbl_transaction', $ceredt_data);
                $this->fee_model->trans_ins('tbl_transaction', $debit_data);
            }

            $this->db->query("UPDATE tbl_student SET `DUE_DATE`='$due_date' where DEL_FLAG='1' AND STUDENT_ID='$name'");
            $data['msg'] = 'Payment added successfully';
            $data['errmsg'] = "";
            $data['success'] = 1;
            $data['book_num'] = $book_num;
            $data['book_name'] = 'PAY';

            $this->session->set_flashdata('msg', $data['msg']);
            $this->session->set_flashdata('errmsg', $data['errmsg']);
            redirect('feecollection');
            //            $layout = array('page' => 'form_fee_collection', 'title' => 'Feecollection', 'data' => $data);
            //            render_template($layout);
        }
    }

    function bank_details()
    {

        $type = $this->input->post('type');
        if ($type == 'bank') {

            $res['bank'] = $this->fee_model->select_acc_code('tbl_account');
            $this->load->view('form_bank_details', $res);
        }
    }

    function payment_stud_details()
    {

        $sid = $this->input->post('sname');
        $data['res'] = $this->fee_model->stud_details('tbl_payment', $sid);
        $this->load->view('form_stud_details', $data);
    }

    function student_details()
    {
        $sid = $this->input->post('sname');

        $data['rs'] = $this->fee_model->select_course('tbl_student', $sid);
        $data['res'] = $this->fee_model->stud_details('tbl_transaction', $sid);
        $this->load->view('form_stud_details', $data);
    }

    function student_names()
    {
        $cname = $this->input->post('cname');
        $this->load->model('fee_model');
        $data['name'] = $this->fee_model->select_stud_name('tbl_student', $cname);
        $this->load->view('form_stud_name', $data);
    }

    function fee_edit()
    {
        $menu_id = 32;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_editprocess($menu_id);
        $id = $this->uri->segment(3);
        $data['fee_edit'] = $this->fee_model->fee_edit_data('tbl_payment', $id);
        $data['parent_account'] = $this->fee_model->selectAll('tbl_account');
        $data['trans_edit'] = $this->fee_model->select_data('tbl_transaction', $id);
        $layout = array('page' => 'form_fee_edit', 'data' => $data);
        render_template($layout);
    }

    function fee_update()
    {
        $menu_id = 32;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_editprocess($menu_id);
        $sess_array = $this->session->userdata('logged_in');
        $year_code = $sess_array['accounting_year'];
        $pay_date = $this->input->post('txt_payment_date');
        $this->load->library('../controllers/lockdate');
        $this->lockdate->index($pay_date);
        $check_status = $this->lockdate->check_date($pay_date);
        $message_display = $this->lockdate->message_val($pay_date, $check_status);
        if ($check_status == 'true') {
            $data['parent_account'] = $this->fee_model->selectAll('tbl_account');
            $data['r'] = $this->fee_model->select_st_name('tbl_student');
            $data['s'] = $this->fee_model->select_acc_type('tbl_account');
            $data['msg'] = '';
            $data['errmsg'] = $message_display;
            //            $layout = array('page' => 'form_fee_collection', 'title' => 'Feecollection', 'data' => $data);
            //            render_template($layout);
            //            return FALSE;
            redirect('feecollection');
        }
        $book_num = $this->input->post('hdd_book_num');
        $stud_id = $this->input->post('hdd_src_id');
        $course = $this->input->post('hdd_sub_acc');
        $pay_id = $this->input->post('txt_pay_id');
        $pay_number = $this->input->post('txt_pay_number');
        $stud_name = $this->input->post('txt_stud_name');
        //$pay_date=$this->input->post('txt_payment_date');
        $pay_date = strtotime($pay_date);
        $pay_date = date("Y-m-d", $pay_date);
        $hdd_due_date = $this->input->post('hdd_due_date');
        $due_date = $this->input->post('txt_due_date');
        $due_date = strtotime($due_date);
        $due_date = date("Y-m-d", $due_date);
        $amt = $this->input->post('txt_amount');
        $trans_type = $this->input->post('txt_trans_type');
        $payment_type = $this->input->post('txt_payment_type');
        $chq_no = $this->input->post('txt_cheque_no');
        $chq_date = $this->input->post('txt_cheque_date');
        $chq_date = strtotime($chq_date);
        $chq_date = date("Y-m-d", $chq_date);
        $accnt_no = $this->input->post('txt_accnt_no');
        $bank = $this->input->post('sel_bank');
        $entry_date = date('Y-m-d');
        if ($pay_id == "") {
            $data['parent_account'] = $this->fee_model->selectAll('tbl_account');
            $data['r'] = $this->fee_model->select_st_name('tbl_student');
            $data['s'] = $this->fee_model->select_acc_type('tbl_account');
            $data['msg'] = '';
            $data['errmsg'] = '';
            //            $layout = array('page' => 'form_fee_collection', 'title' => 'Feecollection', 'data' => $data);
            //            render_template($layout);
            redirect('feecollection');
        }
        if ($pay_id != "") {
            $sess_array = $this->session->userdata('logged_in');
            $modified_by = $sess_array['user_id'];
            $this->load->library('../controllers/lockdate');
            $location_details = $this->lockdate->location_details();
            $modified_on = gmdate("Y-m-d H:i:s");
            $sess_array = $this->session->userdata('logged_in');
            $company_code = $sess_array['comp_code'];
            $query2 = $this->db->query("select ACC_YEAR_CODE from tbl_transaction where BOOK_NUMBER=$book_num AND BOOK_NAME='PAY' AND DEL_FLAG=1 and COMPANY='$company_code'");
            $val2 = $query2->row_array();
            $acc_year = $val2['ACC_YEAR_CODE'];
            if ($year_code == $acc_year) {

                // Calculate GST based on invoice type
                if ($this->input->post('txt_invoice_type') == 'with_tax') {

                    $sgst_percent = 9;
                    $cgst_percent = 9;

                    $total_tax_percent = ($sgst_percent + $cgst_percent) / 100;
                    $base_amount = $amt / (1 + $total_tax_percent);

                    $sgst_amt = $base_amount * ($sgst_percent / 100);
                    $cgst_amt = $base_amount * ($cgst_percent / 100);

                    $sub_total_amt = $base_amount;
                } else {
                    $sgst_amt = 0;
                    $cgst_amt = 0;
                    $sub_total_amt = $amt;
                }

                $this->db->query("update tbl_payment set DEL_FLAG=0 where TYPE='STD' AND PAY_ID=" . $pay_id . " and COMPANY='$company_code'");
                $pay_update = array(
                    'PAY_NUMBER' => $pay_number,
                    'STUDENT_ID' => $stud_id,
                    'DEL_FLAG' => 1,
                    'AMOUNT' => $amt,
                    'SUB_TOTAL_PRICE' => $sub_total_amt,
                    'SGST_PERCENT' => $sgst_percent,
                    'CGST_PERCENT' => $cgst_percent,
                    'SGST_AMOUNT' => $sgst_amt,
                    'CGST_AMOUNT' => $cgst_amt,
                    'TRANSACTION_TYPE' => $trans_type,
                    'PAYMENT_TYPE' => $payment_type,
                    'ENTRY_DATE' => $entry_date,
                    'PAYMENT_DATE' => $pay_date,
                    'DUE_DATE' => $due_date,
                    'CHEQUE_NUMBER' => $chq_no,
                    'CHEQUE_DATE' => $chq_date,
                    'ACCOUNT_NUMBER' => $accnt_no,
                    'BANK' => $bank,
                    /* 		  'REMARKS'=>'ADVANCE', */
                    'TYPE' => 'STD',
                    'FIN_YEAR_ID' => 2,
                    'ACC_YEAR_CODE' => $year_code,
                    'COMPANY' => $company_code,
                    'MODIFIED_BY' => $modified_by,
                    'MODIFIED_ON' => $modified_on,
                    'LOCATION_DETAILS' => $location_details
                );
                $this->fee_model->trans_ins('tbl_payment', $pay_update);
                $ins_pay_id = $this->db->insert_id();
                $this->db->query("update tbl_transaction set DEL_FLAG=0 where PAYMENT_ID=$pay_id AND BOOK_NAME='PAY' and COMPANY='$company_code'");

                if ($trans_type == "cash") {
                    $remarks = "Cash from" . " " . $stud_name . " " . "(Course Fee)";
                    $ceredt_data = array(
                        'FIN_YEAR_ID' => 2,
                        'ACC_ID' => 38,
                        'DATE_OF_TRANSACTION' => $pay_date,
                        'CREDIT' => $amt,
                        'REMARKS' => $remarks,
                        'TRANS_TYPE' => $trans_type,
                        'DEL_FLAG' => 1,
                        'BOOK_NUMBER' => $book_num,
                        'BOOK_NAME' => 'PAY',
                        'SRC_ID' => $stud_id,
                        'SUB_ACC' => $course,
                        'PAYMENT_ID' => $ins_pay_id,
                        'ACC_YEAR_CODE' => $year_code,
                        'COMPANY' => $company_code,
                        'MODIFIED_BY' => $modified_by,
                        'MODIFIED_ON' => $modified_on,
                        'LOCATION_DETAILS' => $location_details
                    );

                    $debit_data = array(
                        'FIN_YEAR_ID' => 2,
                        'ACC_ID' => 39,
                        'DATE_OF_TRANSACTION' => $pay_date,
                        'DEBIT' => $amt,
                        'REMARKS' => $remarks,
                        'TRANS_TYPE' => $trans_type,
                        'DEL_FLAG' => 1,
                        'BOOK_NUMBER' => $book_num,
                        'BOOK_NAME' => 'PAY',
                        'SRC_ID' => $stud_id,
                        'SUB_ACC' => $course,
                        'PAYMENT_ID' => $ins_pay_id,
                        'ACC_YEAR_CODE' => $year_code,
                        'COMPANY' => $company_code,
                        'MODIFIED_BY' => $modified_by,
                        'MODIFIED_ON' => $modified_on,
                        'LOCATION_DETAILS' => $location_details
                    );
                    $this->fee_model->trans_ins('tbl_transaction', $ceredt_data);
                    $this->fee_model->trans_ins('tbl_transaction', $debit_data);
                }

                if ($trans_type == "bank") {

                    //$query=$this->db->query("SELECT ACC_ID FROM tbl_account where ACC_CODE=$bank");  
                    //$row = $query->row_array();
                    //$bank_accid=$row['ACC_ID'];
                    $remarks = $stud_name . " " . "(Course Fee) " . $chq_no;
                    $ceredt_data = array(
                        'FIN_YEAR_ID' => 2,
                        'ACC_ID' => 38,
                        'DATE_OF_TRANSACTION' => $pay_date,
                        'CREDIT' => $amt,
                        'REMARKS' => $remarks,
                        'TRANS_TYPE' => $trans_type,
                        'DEL_FLAG' => 1,
                        'BOOK_NUMBER' => $book_num,
                        'BOOK_NAME' => 'PAY',
                        'SRC_ID' => $stud_id,
                        'SUB_ACC' => $course,
                        'PAYMENT_ID' => $ins_pay_id,
                        'ACC_YEAR_CODE' => $year_code,
                        'COMPANY' => $company_code,
                        'MODIFIED_BY' => $modified_by,
                        'MODIFIED_ON' => $modified_on,
                        'LOCATION_DETAILS' => $location_details
                    );

                    $debit_data = array(
                        'FIN_YEAR_ID' => 2,
                        'ACC_ID' => $bank,
                        'DATE_OF_TRANSACTION' => $pay_date,
                        'DEBIT' => $amt,
                        'REMARKS' => $remarks,
                        'TRANS_TYPE' => $trans_type,
                        'DEL_FLAG' => 1,
                        'BOOK_NUMBER' => $book_num,
                        'BOOK_NAME' => 'PAY',
                        'SRC_ID' => $stud_id,
                        'SUB_ACC' => $course,
                        'PAYMENT_ID' => $ins_pay_id,
                        'ACC_YEAR_CODE' => $year_code,
                        'COMPANY' => $company_code,
                        'MODIFIED_BY' => $modified_by,
                        'MODIFIED_ON' => $modified_on,
                        'LOCATION_DETAILS' => $location_details
                    );
                    $this->fee_model->trans_ins('tbl_transaction', $ceredt_data);
                    $this->fee_model->trans_ins('tbl_transaction', $debit_data);
                }

                if ($hdd_due_date != $due_date) {
                    $this->db->query("update tbl_student set DUE_DATE='$due_date' where STUDENT_ID='$stud_id'");
                }

                $data['parent_account'] = $this->fee_model->selectAll('tbl_account');
                $data['r'] = $this->fee_model->select_st_name('tbl_student');
                $data['s'] = $this->fee_model->select_acc_type('tbl_account');
                $data['msg'] = 'Payment updated successfully';
                $data['errmsg'] = "";

                $this->session->set_flashdata('msg', $data['msg']);
                $this->session->set_flashdata('errmsg', $data['errmsg']);
                //                $layout = array('page' => 'form_fee_collection', 'title' => 'Feecollection', 'data' => $data);
                //                render_template($layout);
                redirect('feecollection');
            } else {
                $data['parent_account'] = $this->fee_model->selectAll('tbl_account');
                $data['r'] = $this->fee_model->select_st_name('tbl_student');
                $data['s'] = $this->fee_model->select_acc_type('tbl_account');
                $data['msg'] = '';
                $data['errmsg'] = "Accounting Year Do not Match";

                $this->session->set_flashdata('msg', $data['msg']);
                $this->session->set_flashdata('errmsg', $data['errmsg']);
                //                $layout = array('page' => 'form_fee_collection', 'title' => 'Feecollection', 'data' => $data);
                //                render_template($layout);
                //                return FALSE;
                redirect('feecollection');
            }
        }
    }

    function fee_delete()
    {
        $menu_id = 32;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $sess_array = $this->session->userdata('logged_in');
        $year_code = $sess_array['accounting_year'];
        $id = $this->uri->segment(3);
        $sess_array = $this->session->userdata('logged_in');
        $company_code = $sess_array['comp_code'];
        $query2 = $this->db->query("select ACC_YEAR_CODE,DATE_OF_TRANSACTION from tbl_transaction where PAYMENT_ID=$id AND BOOK_NAME='PAY' AND DEL_FLAG=1 and COMPANY='$company_code'");
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
            $data = array(
                'DEL_FLAG' => '0',
                'DELETED_BY' => $deleted_by,
                'DELETED_ON' => $deleted_on,
                'LOCATION_DETAILS' => $location_details
            );
            $this->fee_model->delete_data('tbl_payment', $data, $id);
            $this->fee_model->delete_data1('tbl_transaction', $data, $id);

            $data['parent_account'] = $this->fee_model->selectAll('tbl_account');
            $data['r'] = $this->fee_model->select_st_name('tbl_student');
            $data['s'] = $this->fee_model->select_acc_type('tbl_account');
            $data['msg'] = 'Delete successfully';
            $data['errmsg'] = "";
            //            $layout = array('page' => 'form_fee_collection', 'title' => 'Feecollection', 'data' => $data);
            //            render_template($layout);
            redirect('feecollection');
        } else {
            $data['parent_account'] = $this->fee_model->selectAll('tbl_account');
            $data['r'] = $this->fee_model->select_st_name('tbl_student');
            $data['s'] = $this->fee_model->select_acc_type('tbl_account');
            $data['msg'] = '';
            $data['errmsg'] = $message_display;
            //            $layout = array('page' => 'form_fee_collection', 'title' => 'Feecollection', 'data' => $data);
            //            render_template($layout);
            //            return FALSE;
            redirect('feecollection');
        }
    }

    function coursecompletion()
    {
        $menu_id = 25;
        $this->load->library('../controllers/permition_checker');
        $this->form_validation->set_rules('txt_completed_date', 'Completed Date', 'required');
        //echo $student_id=$this->uri->segment(3);
        if ($this->form_validation->run() == FALSE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            //echo $student_id=$this->uri->segment(3);
            $data['msg'] = '';
            $data['parent_account'] = $this->fee_model->selectAll('tbl_account');
            //$data['student_account']=$this->fee_model->course_com_student('tbl_student',$student_id);
            $layout = array('page' => 'form_course_completion', 'title' => 'Course Completion', 'data' => $data);
            render_template($layout);
        } else {
            $this->permition_checker->permition_addprocess($menu_id);
            echo $stud_id = $this->input->post('txt_stud_name');
            echo "<br>";
            echo $course_id = $this->input->post('txt_course');
            echo "<br>";
            $sess_array = $this->session->userdata('logged_in');
            $modified_by = $sess_array['user_id'];
            $this->load->library('../controllers/lockdate');
            $location_details = $this->lockdate->location_details();
            $modified_on = gmdate("Y-m-d H:i:s");
            $completed_date = $this->input->post('txt_completed_date');
            $completed_date = strtotime($completed_date);
            $completed_date = date("Y-m-d", $completed_date);
            $this->db->query("update tbl_student set COMPLETED_DATE='$completed_date',STATUS='8',MODIFIED_BY=$modified_by,MODIFIED_ON='$modified_on',LOCATION_DETAILS='$location_details' where STUDENT_ID='$stud_id'");


            //$this->load->library('../controllers/student_list');
            //redirect('student_list');
            $data['parent_account'] = $this->fee_model->selectAll('tbl_account');
            $data['msg'] = 'Completed successfully';
            $layout = array('page' => 'form_course_completion', 'title' => 'Course Completion', 'data' => $data);
            render_template($layout);
        }
    }

    function completion_details()
    {
        $sid = $this->input->post('sname');
        $data['stud'] = $this->fee_model->select_course('tbl_student', $sid);
        $data['res'] = $this->fee_model->stud_details('tbl_transaction', $sid);
        $this->load->view('form_completion_details', $data);
    }
}
