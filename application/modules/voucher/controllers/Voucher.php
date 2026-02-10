<?php

class Voucher extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->model('voucher_model');
    }

    function index() {
        $menu_id = 29;
        $this->load->library('../controllers/permition_checker');
        $autoload['helper'] = array('security');
        $this->load->helper('security');
        $this->form_validation->set_rules('txt_voucher_date', 'voucher date', 'required');
        if ($this->form_validation->run() != TRUE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
            $data['msg'] = "";
            $data['errmsg'] = "";
            $layout = array('page' => 'form_voucher', 'title' => 'Payment Voucher', 'data' => $data);
            render_template($layout);
        } else {
            $this->permition_checker->permition_addprocess($menu_id);
            $sess_array = $this->session->userdata('logged_in');
            $year_code = $sess_array['accounting_year'];
            $voucher_date = $this->input->post('txt_voucher_date');
            $company = $sess_array['comp_code'];
            $this->load->library('../controllers/lockdate');
            $this->lockdate->index($voucher_date);
            $check_status = $this->lockdate->check_date($voucher_date);
            $message_display = $this->lockdate->message_val($voucher_date, $check_status);
            if ($check_status == 'true') {
                $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
                $data['msg'] = "";
                $data['errmsg'] = $message_display;
                $layout = array('page' => 'form_voucher', 'title' => 'Voucher', 'data' => $data);
                render_template($layout);
                return FALSE;
            }
            $n = $this->input->post('Num');
            if ($n == '2') {
                $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
                $data['msg'] = "";
                $data['errmsg'] = "You have some form errors. Please check below.";
                $layout = array('page' => 'form_voucher', 'title' => 'Voucher', 'data' => $data);
                render_template($layout);
                return FALSE;
            }

            for ($i = 3; $i <= $n; $i++) {
                $amt = $this->input->post('amount' . $i);
                if ($amt == 0 || $amt == "") {
                    $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
                    $data['msg'] = "";
                    $data['errmsg'] = "Amount is Not Valid";
                    $layout = array('page' => 'form_voucher', 'title' => 'Voucher', 'data' => $data);
                    render_template($layout);
                    return FALSE;
                }
            }

            $temp_voc_num = $this->input->post('temp_voc_num');
            if ($temp_voc_num != "") {
                $this->permition_checker->permition_editprocess($menu_id);
//                $query2 = $this->db->query("select ACC_YEAR_CODE from tbl_transaction where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='PV' AND DEL_FLAG=1 and COMPANY='$company'");
//                $val2 = $query2->row_array();
//                $acc_year = $val2['ACC_YEAR_CODE'];
                $acc_year = $this->input->post('acc_year');
                $sess_array = $this->session->userdata('logged_in');
                $modified_by = $sess_array['user_id'];
                $this->load->library('../controllers/lockdate');
                $location_details = $this->lockdate->location_details();
                $modified_on = gmdate("Y-m-d H:i:s");
                if ($year_code == $acc_year) {
                    $this->db->query("update tbl_transaction set DEL_FLAG=0,MODIFIED_BY=$modified_by,MODIFIED_ON='$modified_on',LOCATION_DETAILS='$location_details' where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='PV' and COMPANY='$company' and ACC_YEAR_CODE=$acc_year");
                    $book_num = $temp_voc_num;
                } else {
                    $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
                    $data['msg'] = "";
                    $data['errmsg'] = "Accounting Year Do not Match";
                    $layout = array('page' => 'form_voucher', 'title' => 'Voucher', 'data' => $data);
                    render_template($layout);
                    return FALSE;
                }
            } else {
                $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='PV' and COMPANY='$company' and ACC_YEAR_CODE=$year_code and DEL_FLAG=1");
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
                $cash_received_by = $this->input->post('txt_received_by');
                $voucher_date = $this->input->post('txt_voucher_date');
                $voucher_date = strtotime($voucher_date);
                $voucher_date = date("Y-m-d", $voucher_date);
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
                $remark_cashac = "Cash To  " . $course_name;
                $remark = "Cash To  " . $course_name . $sub_acc_description . $description;
                $sess_array = $this->session->userdata('logged_in');
                $create_by = $sess_array['user_id'];
                $this->load->library('../controllers/lockdate');
                $location_details = $this->lockdate->location_details();
                $create_on = gmdate("Y-m-d H:i:s");
                $data = array('FIN_YEAR_ID' => '2',
                    'ACC_ID' => $acc_id,
                    'DATE_OF_TRANSACTION' => $voucher_date,
                    'DEBIT' => $amt,
                    'REMARKS' => $remark,
                    'DESCRIPTION' => $rem,
                    'TRANS_TYPE' => 'cash',
                    'BOOK_NUMBER' => $book_num,
                    'BOOK_NAME' => 'PV',
                    'REF_VOUCHERNO' => $rvno,
                    'SUB_ACC' => $sub_acc_id,
                    'ACC_YEAR_CODE' => $year_code,
                    'CASH_TO' => $cash_to,
                    'CASH_RECEIVED_BY' => $cash_received_by,
                    'CREATED_BY' => $create_by,
                    'CREATED_ON' => $create_on,
                    'COMPANY' => $company,
                    'LOCATION_DETAILS' => $location_details);

                $data2 = array('FIN_YEAR_ID' => '2',
                    'ACC_ID' => '39',
                    'DATE_OF_TRANSACTION' => $voucher_date,
                    'CREDIT' => $amt,
                    'REMARKS' => $remark,
                    'DESCRIPTION' => $rem,
                    'TRANS_TYPE' => 'cash',
                    'BOOK_NUMBER' => $book_num,
                    'BOOK_NAME' => 'PV',
                    'REF_VOUCHERNO' => $rvno,
                    'ACC_YEAR_CODE' => $year_code,
                    'CASH_TO' => $cash_to,
                    'CASH_RECEIVED_BY' => $cash_received_by,
                    'CREATED_BY' => $create_by,
                    'CREATED_ON' => $create_on,
                    'COMPANY' => $company,
                    'LOCATION_DETAILS' => $location_details);

                $this->voucher_model->insert_data('tbl_transaction', $data);
                $this->voucher_model->insert_data('tbl_transaction', $data2);
            }
            $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
            $data['msg'] = 'Payment added successfully';
            $data['errmsg'] = "";
            $layout = array('page' => 'form_voucher', 'title' => 'Voucher', 'data' => $data);
            render_template($layout);
        }
    }

    function account_list() {
        $acc_name = $this->input->post('name');

        $data['cond'] = $this->voucher_model->select_All('tbl_account', $acc_name);
        $this->load->view('form_acclist', $data);
    }

    function add_list() {
        $acc_name = $this->input->post('name');

        $data['cond'] = $this->voucher_model->select_All('tbl_account', $acc_name);
        $this->load->view('form_acclist', $data);
    }

    function select_data() {
        //echo "Hai";
        $sess_array = $this->session->userdata('logged_in');
        $company = $sess_array['comp_code'];
        $buk_num = $this->input->post('voc_no');
        $generate_pdf = $this->input->post('generate_pdf');
        $accounting_year = $this->input->post('accounting_year');
        $data['vno'] = $this->voucher_model->select_info('tbl_transaction', $buk_num, $accounting_year);
        $data['company'] = $this->voucher_model->select_company($company);
        if ($generate_pdf == 'generate_pdf') {
            $this->load->library('pdfgenerator');
//            $this->load->view('cash_receipt_pdf', $data);
            $html = $this->load->view('cash_voucher_pdf', $data, true);
            $filename = 'cah_voucher_' . time();
            $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
        } else {
            $this->load->view('form_displayData', $data);
        }
    }

    function del_data() {
        $menu_id = 29;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $sess_array = $this->session->userdata('logged_in');
        $year_code = $sess_array['accounting_year'];
        $buk_num = $this->input->post('txt_buk_num');
        $sess_array = $this->session->userdata('logged_in');
        $company_code = $sess_array['comp_code'];
        $query2 = $this->db->query("select ACC_YEAR_CODE,DATE_OF_TRANSACTION from tbl_transaction where BOOK_NUMBER=$buk_num AND BOOK_NAME='PV' AND DEL_FLAG=1 and COMPANY='$company_code'");
        $val2 = $query2->row_array();
        $acc_year = $val2['ACC_YEAR_CODE'];
        $this->load->library('../controllers/lockdate');
        $voucher_date = $val2['DATE_OF_TRANSACTION'];
        $check_status = $this->lockdate->check_date($voucher_date);
        $message_display = $this->lockdate->message_val($voucher_date, $check_status);
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

            $this->voucher_model->delete_data1('tbl_transaction', $data, $buk_num);
        } else {
            $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
            $data['msg'] = "";
            $data['errmsg'] = $message_display;
            $layout = array('page' => 'form_voucher', 'title' => 'Voucher', 'data' => $data);
            render_template($layout);
            return FALSE;
        }
    }

    function delete_data() {
        $menu_id = 29;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        //echo "Hai";
        $sess_array = $this->session->userdata('logged_in');
        $year_code = $sess_array['accounting_year'];
        $buk_num = $this->uri->segment(3);
        $acc_year = $this->uri->segment(4);
        $sess_array = $this->session->userdata('logged_in');
        $company_code = $sess_array['comp_code'];
        $query2 = $this->db->query("select DATE_OF_TRANSACTION from tbl_transaction where BOOK_NUMBER=$buk_num AND BOOK_NAME='PV' AND DEL_FLAG=1 and COMPANY='$company_code' and ACC_YEAR_CODE=$acc_year");
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
            $this->voucher_model->delete_data1('tbl_transaction', $data, $buk_num, $acc_year);
            $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
            $data['msg'] = "Voucher Delete successfully";
            $data['errmsg'] = "";
            $layout = array('page' => 'form_voucher', 'title' => 'Voucher', 'data' => $data);
            render_template($layout);
            return FALSE;
        } else {
            $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
            $data['msg'] = "";
            $data['errmsg'] = $message_display;
            $layout = array('page' => 'form_voucher', 'title' => 'Voucher', 'data' => $data);
            render_template($layout);
            return FALSE;
        }
    }
    
    function api_payment_voucher()
    {
        $this->load->library('../controllers/Permition_checker_api');
        $this->form_validation->set_rules('menu_id','Menu Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('book_name','Book Name','trim|required');
        $this->form_validation->set_rules('book_number','Book Number','trim|required');
        $this->form_validation->set_rules('ref_voucher_number','Reference Voucher Number','trim');
        $this->form_validation->set_rules('voucher_date','Voucher Date','trim|required');
        $this->form_validation->set_rules('search_account','Search account','trim');
        $this->form_validation->set_rules('cash_to','Cash To','trim');
        $this->form_validation->set_rules('cash_received_by','Cash Received By','trim');
        $this->form_validation->set_rules('comp_code','Company','trim|required|required'); 
        $this->form_validation->set_rules('year_code','Accounting Year','trim|required');  
        if ($this->form_validation->run() != TRUE) 
        {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } 
        else 
        {
            $menu_id = $this->input->post('menu_id');
            $user_id = $this->input->post('user_id');
            $result = $this->permition_checker_api->permition_addprocess($menu_id,$user_id);
            if($result == 'access_denied')
            {
                $data['status'] = 0;
                $data['msg'] = "Access Denied";
                header('Content-Type: application/json');
                echo json_encode($data);
            } 
            else
            {
                //$sess_array = $this->session->userdata('logged_in');
                //$year_code = $sess_array['accounting_year'];
                $voucher_date = $this->input->post('voucher_date');
                $company = $this->input->post('comp_code');
                $year_code = $this->input->post('year_code');
                $n = $this->input->post('Num');
                if ($n == '2') 
                {
                    $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
                    $data['msg'] = "";
                    $data['errmsg'] = "You have some form errors. Please check below.";
                    header('Content-Type: application/json');
                    echo json_encode($data);
                }
                for ($i = 3; $i <= $n; $i++) 
                {
                    $amt = $this->input->post('amount' . $i);
                    if ($amt == 0 || $amt == "") 
                    {
                        $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
                        $data['msg'] = "";
                        $data['errmsg'] = "Amount is Not Valid";
                        header('Content-Type: application/json');
                        echo json_encode($data);
                    }
                }
                $temp_voc_num = $this->input->post('temp_voc_num');
                if ($temp_voc_num != "") 
                {
                    $this->permition_checker_api->permition_editprocess($menu_id);
                    $acc_year = $this->input->post('acc_year');
                    $sess_array = $this->session->userdata('logged_in');
                    $modified_by = $sess_array['user_id'];
                    // $this->load->library('../controllers/lockdate');
                    // $location_details = $this->lockdate->location_details();
                    // $modified_on = gmdate("Y-m-d H:i:s");
                    if ($year_code == $acc_year) 
                    {
                        $this->db->query("update tbl_transaction set DEL_FLAG=0,MODIFIED_BY=$modified_by,MODIFIED_ON='$modified_on',LOCATION_DETAILS='$location_details' where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='PV' and COMPANY='softloom' and ACC_YEAR_CODE= 2018-2019");
                        $book_num = $temp_voc_num;
                    } 
                    else 
                    {
                        $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
                        $data['msg'] = "";
                        $data['errmsg'] = "Accounting Year Do not Match";
                         header('Content-Type: application/json');
                         echo json_encode($data);
                    }
                } 
                else 
                {
                    $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='PV' and COMPANY='softloom' and ACC_YEAR_CODE= 2018-2019 and DEL_FLAG=1");
                    $row = $query->row_array();
                    $book_num = $row['BOOK_NUMBER'];
                }

                for ($i = 3; $i <= $n; $i++) 
                {
                    $acc_id = $this->input->post('acc_id' . $i);
                    $sub_acc_id = $this->input->post('sub_acc' . $i);
                    $amt = $this->input->post('amount' . $i);
                    $rem = $this->input->post('remarks' . $i);
                    $course_name = $this->input->post('acc_name' . $i);
                    $rvno = $this->input->post('ref_voucher_number');
                    $cash_to = $this->input->post('cash_to');
                    $cash_received_by = $this->input->post('cash_received_by');
                    $voucher_date = $this->input->post('voucher_date');
                    $voucher_date = strtotime($voucher_date);
                    $voucher_date = date("Y-m-d", $voucher_date);
                    $query = $this->db->query("SELECT ACC_NAME FROM tbl_account WHERE ACC_ID='$sub_acc_id' ");
                    $res = $query->row_array();
                    $sub_name = $res['ACC_NAME'];
                    if ($sub_name != "") 
                    {
                        $sub_acc_description = " - " . $sub_name;
                    } 
                    else 
                    {
                        $sub_acc_description = "";
                    }
                    if ($rem != "") 
                    {
                        $description = " / " . $rem;
                    }
                    else 
                    {
                        $description = "";
                    }
                    $remark_cashac = "Cash To  " . $course_name;
                    $remark = "Cash To  " . $course_name . $sub_acc_description . $description;
                    $sess_array = $this->input->post('logged_in');
                    $create_by = $sess_array['user_id'];
                    // $this->load->library('../controllers/lockdate');
                    // $location_details = $this->lockdate->location_details();
                    // $create_on = gmdate("Y-m-d H:i:s");
                    $data = array('FIN_YEAR_ID' => '2',
                        'ACC_ID' => $acc_id,
                        'DATE_OF_TRANSACTION' => $voucher_date,
                        'DEBIT' => $amt,
                        'REMARKS' => $remark,
                        'DESCRIPTION' => $rem,
                        'TRANS_TYPE' => 'cash',
                        'BOOK_NUMBER' => $book_num,
                        'BOOK_NAME' => 'PV',
                        'REF_VOUCHERNO' => $rvno,
                        'SUB_ACC' => $sub_acc_id,
                        'ACC_YEAR_CODE' => $year_code,
                        'CASH_TO' => $cash_to,
                        'CASH_RECEIVED_BY' => $cash_received_by,
                        'CREATED_BY' => $create_by,
                        'CREATED_ON' => $create_on,
                        'COMPANY' => $company,
                        'LOCATION_DETAILS' => $location_details);

                    $data2 = array('FIN_YEAR_ID' => '2',
                        'ACC_ID' => '39',
                        'DATE_OF_TRANSACTION' => $voucher_date,
                        'CREDIT' => $amt,
                        'REMARKS' => $remark,
                        'DESCRIPTION' => $rem,
                        'TRANS_TYPE' => 'cash',
                        'BOOK_NUMBER' => $book_num,
                        'BOOK_NAME' => 'PV',
                        'REF_VOUCHERNO' => $rvno,
                        'ACC_YEAR_CODE' => $year_code,
                        'CASH_TO' => $cash_to,
                        'CASH_RECEIVED_BY' => $cash_received_by,
                        'CREATED_BY' => $create_by,
                        'CREATED_ON' => $create_on,
                        'COMPANY' => $company,
                        'LOCATION_DETAILS' => $location_details);

                    $this->voucher_model->insert_data('tbl_transaction', $data);
                    $this->voucher_model->insert_data('tbl_transaction', $data2);
                }
                $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account')->result();
                $data['msg'] = 'Payment added successfully';
                if(count($data) > 0)
                { 
                    $retrn_value = array('status' => 1, 'data'=> $data);
                    header('Content-Type: application/json');
                    echo json_encode($retrn_value);
                }
                else
                {
                    $data['status'] = 0;
                    $data['msg'] = "No Data Found";
                    header('Content-Type: application/json');
                   echo json_encode($data);
                }
            } 
        }
    }

    function api_voucher() {
        // $menu_id = 29;
        $this->load->library('../controllers/permition_checker_api');
        $voucher_data = $this->input->post('voucher_data');
        $selected_acnts = $this->input->post('selected_acnts');
        $voucher_data = json_decode($voucher_data);
        $selected_acnts = json_decode($selected_acnts);
        $menu_id = $voucher_data->menu_id;
        $user_id = $voucher_data->user_id;
        $return = $this->permition_checker_api->permition_addprocess($menu_id, $user_id);
        header('Content-Type: application/json');
        if($return == 'access_denied')
        {
            $data['status'] = 0;
            $data['msg'] = "Access Denied";
            echo json_encode($data);
        } 
        else
        {
            // $sess_array = $this->session->userdata('logged_in');
            $year_code =$voucher_data->accounting_year;
            // $voucher_date = $voucher_data->voucher_date;
            $company = $voucher_data->comp_code;
            // $this->load->library('../controllers/lockdate');
            // $this->lockdate->index($voucher_date);
            // $check_status = $this->lockdate->check_date($voucher_date);
            // $message_display = $this->lockdate->message_val($voucher_date, $check_status);
            // if ($check_status == 'true') {
            //     $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
            //     $data['msg'] = "";
            //     $data['errmsg'] = $message_display;
            //     $layout = array('page' => 'form_voucher', 'title' => 'Voucher', 'data' => $data);
            //     render_template($layout);
            //     return FALSE;
            // }
            // $n = $this->input->post('Num');
            // if ($n == '2') {
            //     $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
            //     $data['msg'] = "";
            //     $data['errmsg'] = "You have some form errors. Please check below.";
            //     $layout = array('page' => 'form_voucher', 'title' => 'Voucher', 'data' => $data);
            //     render_template($layout);
            //     return FALSE;
            // }
            $error = 0;
            // for ($i = 3; $i <= $n; $i++) {
            //     $amt = $this->input->post('amount' . $i);
            //     if ($amt == 0 || $amt == "") {
            //         // $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
            //         $error = 1;
            //         $data['status'] = 0;
            //         $data['msg'] = "Amount is Not Valid";
            //         echo json_encode($data);
            //         // $layout = array('page' => 'form_voucher', 'title' => 'Voucher', 'data' => $data);
            //         // render_template($layout);
            //         // return FALSE;
            //     }
            // }
            foreach ($selected_acnts as $key => $value) {
                $amt = $value->amount;
                if ($amt == 0 || $amt == "") {
                    // $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
                    $error = 1;
                    $data['status'] = 0;
                    $data['msg'] = "Amount is Not Valid";
                    echo json_encode($data);
                    break;
                    // $layout = array('page' => 'form_voucher', 'title' => 'Voucher', 'data' => $data);
                    // render_template($layout);
                    // return FALSE;
                }
             } 
            if($error == 0) {
                $temp_voc_num = $voucher_data->temp_voc_num;
                $year_error = 0;
                if ($temp_voc_num != "") {
                    $this->permition_checker_api->permition_editprocess($menu_id, $user_id);
                    $acc_year = $voucher_data->acc_year;
                    // $sess_array = $this->session->userdata('logged_in');
                    // $modified_by = $sess_array['user_id'];
                    // $this->load->library('../controllers/lockdate');
                    $location_details = $voucher_data->device_type . " " . $voucher_data->device_id;
                    $modified_on = gmdate("Y-m-d H:i:s");
                    if ($year_code == $acc_year) {
                        $this->db->query("update tbl_transaction set DEL_FLAG=0,MODIFIED_BY=$user_id,MODIFIED_ON='$modified_on',LOCATION_DETAILS='$location_details' where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='PV' and COMPANY='$company' and ACC_YEAR_CODE=$acc_year");
                        $book_num = $temp_voc_num;
                    } else {
                        // $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
                        $data['status'] = 0;
                        $data['msg'] = "Accounting Year Do not Match";
                        echo json_encode($data);
                        $year_error = 1;
                        // $layout = array('page' => 'form_voucher', 'title' => 'Voucher', 'data' => $data);
                        // render_template($layout);
                        // return FALSE;
                    }
                } else {
                    $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='PV' and COMPANY='$company' and ACC_YEAR_CODE=$year_code and DEL_FLAG=1");
                    $row = $query->row_array();
                    $book_num = $row['BOOK_NUMBER'];
                }

                if($year_error == 0) {
                    // for ($i = 3; $i <= $n; $i++) {
                    foreach ($selected_acnts as $key => $value) {
                        $acc_id = $value->account_id;
                        $sub_acc_id = $value->subaccount_acc;
                        $amt = $value->amount;
                        $rem = $value->remarks;
                        $course_name = $value->account_name;
                        $rvno = $voucher_data->ref_voucher_no;
                        $cash_to = $voucher_data->cash_to;
                        $cash_received_by = $voucher_data->received_by;
                        $voucher_date = $voucher_data->voucher_date;
                        $voucher_date = strtotime($voucher_date);
                        $voucher_date = date("Y-m-d", $voucher_date);
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
                        $remark_cashac = "Cash To  " . $course_name;
                        $remark = "Cash To  " . $course_name . $sub_acc_description . $description;
                        // $sess_array = $this->session->userdata('logged_in');
                        // $create_by = $sess_array['user_id'];
                        // $this->load->library('../controllers/lockdate');
                        // $location_details = $this->lockdate->location_details();
                        $location_details = $voucher_data->device_type . " " . $voucher_data->device_id;
                        $create_on = gmdate("Y-m-d H:i:s");
                        $data = array('FIN_YEAR_ID' => '2',
                            'ACC_ID' => $acc_id,
                            'DATE_OF_TRANSACTION' => $voucher_date,
                            'DEBIT' => $amt,
                            'REMARKS' => $remark,
                            'DESCRIPTION' => $rem,
                            'TRANS_TYPE' => 'cash',
                            'BOOK_NUMBER' => $book_num,
                            'BOOK_NAME' => 'PV',
                            'REF_VOUCHERNO' => $rvno,
                            'SUB_ACC' => $sub_acc_id,
                            'ACC_YEAR_CODE' => $year_code,
                            'CASH_TO' => $cash_to,
                            'CASH_RECEIVED_BY' => $cash_received_by,
                            'CREATED_BY' => $user_id,
                            'CREATED_ON' => $create_on,
                            'COMPANY' => $company,
                            'LOCATION_DETAILS' => $location_details);

                        $data2 = array('FIN_YEAR_ID' => '2',
                            'ACC_ID' => '39',
                            'DATE_OF_TRANSACTION' => $voucher_date,
                            'CREDIT' => $amt,
                            'REMARKS' => $remark,
                            'DESCRIPTION' => $rem,
                            'TRANS_TYPE' => 'cash',
                            'BOOK_NUMBER' => $book_num,
                            'BOOK_NAME' => 'PV',
                            'REF_VOUCHERNO' => $rvno,
                            'ACC_YEAR_CODE' => $year_code,
                            'CASH_TO' => $cash_to,
                            'CASH_RECEIVED_BY' => $cash_received_by,
                            'CREATED_BY' => $user_id,
                            'CREATED_ON' => $create_on,
                            'COMPANY' => $company,
                            'LOCATION_DETAILS' => $location_details);

                        $this->voucher_model->insert_data('tbl_transaction', $data);
                        $this->voucher_model->insert_data('tbl_transaction', $data2);
                    }
                    $data = array('status' =>1,
                            'msg' => 'Payment added successfully',
                            'voucher_date' => $voucher_date,
                            'ref_voucher_no' => $rvno,
                            'accounting_year' => $year_code,
                            'cash_to' => $cash_to,
                            'cash_received_by' => $cash_received_by,
                            'company' => $company);
                    echo json_encode($data);
                }
            }
        }
    }
}

?>