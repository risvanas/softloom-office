<?php

class Invoice extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->model('invoice_model');
        $this->load->library('encryption');
    }

    function index() {
        $menu_id = 35;
        $this->load->library('../controllers/permition_checker');
        $autoload['helper'] = array('security');
        $this->load->helper('security');
        $this->form_validation->set_rules('txt_invoice_date', 'Invoice date', 'required');
        if ($this->form_validation->run() != TRUE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
            $data['cust'] = $this->invoice_model->select_customer('tbl_account');
            $data['description'] = $this->invoice_model->select_description();
            $data['msg'] = "";
            $data['errmsg'] = "";
            $layout = array('page' => 'form_invoice', 'title' => 'Invoice', 'data' => $data);
            render_template($layout);
            //$this->load->view('form_invoice',$data);
        } else {

            // $invoice_date=$this->input->post('txt_invoice_date');
            //$this->load->library('../controllers/lockdate');
            //$this->lockdate->index($invoice_date);
            $this->permition_checker->permition_addprocess($menu_id);

            $sess_array = $this->session->userdata('logged_in');
            $year_code = $sess_array['accounting_year'];
            $company = $sess_array['comp_code'];
            $invoice_type = $this->input->post('invoice_type');

            $sql = "SELECT ";
            $sql .= ($invoice_type == 'with_tax') ? "IFNULL(MAX(BOOK_NUMBER), 100)+1" : "IFNULL(MAX(BOOK_NUMBER), 0)+1";
            $sql .= " AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='INVOE' and  ACC_YEAR_CODE=$year_code and DEL_FLAG=1 and INVOICE_TYPE='$invoice_type' and COMPANY='$company'";


//            $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='INVOE' and  ACC_YEAR_CODE=$year_code and DEL_FLAG=1");
            $query = $this->db->query($sql);
            $row = $query->row_array();
            $book_num = $row['BOOK_NUMBER'];
            //$book_num=$this->input->post('txt_buk_num');
            $invoice_date = $this->input->post('txt_invoice_date');
            $temp_inv_no = $this->input->post('temp_inv_no');
            $temp_inv_added = $this->input->post('temp_inv_added');
            $cut_id = $this->input->post('txt_cust_name');

            $this->load->library('../controllers/lockdate');
            $this->lockdate->index($invoice_date);
            $check_status = $this->lockdate->check_date($invoice_date);
            $message_display = $this->lockdate->message_val($invoice_date, $check_status);
            if ($check_status == 'true') {
                $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
                $data['cust'] = $this->invoice_model->select_customer('tbl_account');
                $data['description'] = $this->invoice_model->select_description();
                $data['msg'] = '';
                $data['errmsg'] = $message_display;
                $layout = array('page' => 'form_invoice', 'title' => 'Invoice', 'data' => $data);
                render_template($layout);
                return FALSE;
            }
            if ($temp_inv_added == 1) {
                $temp_inv_details = $this->invoice_model->select_temp_inv_details($temp_inv_no, $year_code, $company)->row();
                if($temp_inv_details->CUSTOMER_ID != $cut_id) {
                    $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
                    $data['cust'] = $this->invoice_model->select_customer('tbl_account');
                    $data['description'] = $this->invoice_model->select_description();
                    $data['msg'] = '';
                    $data['errmsg'] = 'The customer is different in temporary invoice';
                    $layout = array('page' => 'form_invoice', 'title' => 'Invoice', 'data' => $data);
                    render_template($layout);
                    return FALSE;
                }
            }
            $invoice_date = strtotime($invoice_date);
            $invoice_date = date("Y-m-d", $invoice_date);
            
            $total = $this->input->post('subtotal');
            $sgst_percent = $this->input->post('sgst_percent');
            $cgst_percent = $this->input->post('cgst_percent');
            $flood_cess_percent = $this->input->post('flood_cess_percent');
            $sgst_amt = $this->input->post('sgst');
            $cgst_amt = $this->input->post('cgst');
            $flood_cess_amt = $this->input->post('flood_cess');
            $round_off = $this->input->post('round_off');
            $grand_total = $this->input->post('total');
            //$paid_amt = $this->input->post('paid');
            $description = $this->input->post('txt_des');
            $rec_inv = $this->input->post('txt_recrng_inv');
            $rec_inv_type = $this->input->post('txt_recrng_type');
            $rec_inv_cmnt = $this->input->post('txt_rec_cmnt');
            $next_inv_date = $this->input->post('txt_nxt_invoice_date');
            $next_inv_date = strtotime($next_inv_date);
            $next_inv_date = date("Y-m-d", $next_inv_date);
            $curnt_date = date('Y-m-d');
            $cust_name = $this->input->post('lbl_cust_name');
            $sess_array = $this->session->userdata('logged_in');
            $create_by = $sess_array['user_id'];
            $this->load->library('../controllers/lockdate');
            $location_details = $this->lockdate->location_details();
            $create_on = gmdate("Y-m-d H:i:s");

            $data = array('BOOK_NUMBER' => $book_num,
                'CUSTOMER_ID' => $cut_id,
                'BOOK_NAME' => 'INVO',
                'INVOICE_TYPE' => $invoice_type,
                'COMPANY' => $company,
                'INVOICE_DATE' => $invoice_date,
                'DESCRIPTION' => $description,
                'SUB_TOTAL_PRICE' => $total,
                'SGST_PERCENT' => $sgst_percent,
                'CGST_PERCENT' => $cgst_percent,
                'FLOOD_CESS_PERCENT' => $flood_cess_percent,
                'SGST_AMOUNT' => $sgst_amt,
                'CGST_AMOUNT' => $cgst_amt,
                'FLOOD_CESS_AMOUNT' => $flood_cess_amt,
                'ROUND_OFF' => $round_off,
                'TOTAL_PRICE' => $grand_total,
                //'PAID_PRICE' => $paid_amt,
                'CURRENT_DATE' => $curnt_date,
                'ACC_YEAR_CODE' => $year_code,
                'INVOICE_RECURRING' => $rec_inv,
                'INVOICE_RECURRING_TYPE' => $rec_inv_type,
                'INVOICE_RECURRING_COMMENT' => $rec_inv_cmnt,
                'NEXT_INVOICE_DATE' => $next_inv_date,
                'TEMP_INVOICE_ADDED' => $temp_inv_added,
                'TEMP_INVOICE_ID' => $temp_inv_no,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details);
            $this->invoice_model->insert_data('tbl_invoice', $data);
            $invo_id = $this->db->insert_id();

            if (isset($_POST['item'])) {
                for ($i = 0; $i < count($_POST['item']); $i++) {
                    $item = $_POST['item'][$i];
                    $cost = $_POST['cost'][$i];
                    $des = $_POST['description'][$i];
                    $qty = $_POST['qty'][$i];


                    $data = array('ITEM' => $item,
                        'DESCRIPTION' => $des,
                        'UNIT_COST' => $cost,
                        'QUANTITY' => $qty,
                        'INVOICE_ID' => $invo_id,
                        'ACC_YEAR_CODE' => $year_code,
                        'CREATED_BY' => $create_by,
                        'CREATED_ON' => $create_on,
                        'LOCATION_DETAILS' => $location_details);
                    $this->invoice_model->insert_data('tbl_invoicedetails', $data);
//                    echo"<br>";
                }
            }
            $query1 = $this->db->query("SELECT `description` FROM `tbl_invoice_description` WHERE `id`=$description");
            $row1 = $query1->row_array();
            $description1 = $row1['description'];
            $remarks = $description1 . " / " . $cust_name;
            $trn_data = array('FIN_YEAR_ID' => 2,
                'ACC_ID' => 108,
                'INVOICE_ID' => $invo_id ?? null,
                'DATE_OF_TRANSACTION' => $invoice_date,
                'CREDIT' => $grand_total,
                'REMARKS' => $remarks,
                'DEL_FLAG' => 1,
                'BOOK_NUMBER' => $book_num,
                'BOOK_NAME' => 'INVOE',
                'SUB_ACC' => $cut_id,
                'ACC_YEAR_CODE' => $year_code,
                'COMPANY' => $company,
                'INVOICE_TYPE' => $invoice_type,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details,
                'TRANSACTION_DATE' => $curnt_date);
            $trn_data1 = array('FIN_YEAR_ID' => 2,
                'ACC_ID' => 47,
                'INVOICE_ID' => $invo_id ?? null,
                'DATE_OF_TRANSACTION' => $invoice_date,
                'DEBIT' => $grand_total,
                'REMARKS' => $remarks,
                'DEL_FLAG' => 1,
                'BOOK_NUMBER' => $book_num,
                'BOOK_NAME' => 'INVOE',
                'SUB_ACC' => $cut_id,
                'ACC_YEAR_CODE' => $year_code,
                'COMPANY' => $company,
                'INVOICE_TYPE' => $invoice_type,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details,
                'TRANSACTION_DATE' => $curnt_date);

            $this->invoice_model->insert_data('tbl_transaction', $trn_data);
            $this->invoice_model->insert_data('tbl_transaction', $trn_data1);

            $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
            $data['cust'] = $this->invoice_model->select_customer('tbl_account');
            $data['description'] = $this->invoice_model->select_description();
            $data['msg'] = 'Invoice added successfully';
            $data['errmsg'] = "";
//            $layout = array('page' => 'form_invoice', 'title' => 'Invoice', 'data' => $data);
//            render_template($layout);
            redirect('invoice');
        }
    }

    function add_new_invoice() {
        $menu_id = 35;
        $this->load->library('../controllers/permition_checker');
        $autoload['helper'] = array('security');
        $this->load->helper('security');
        $this->form_validation->set_rules('txt_invoice_date', 'Invoice date', 'required');
        if ($this->form_validation->run() != TRUE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
            $data['cust'] = $this->invoice_model->select_customer('tbl_account');
            $data['description'] = $this->invoice_model->select_description();
            $data['msg'] = "";
            $data['errmsg'] = "";
            $layout = array('page' => 'form_invoice', 'title' => 'Invoice', 'data' => $data);
            render_template($layout);
        }
        else 
        {
            $this->permition_checker->permition_addprocess($menu_id);
            $sess_array = $this->session->userdata('logged_in');
            $year_code = $sess_array['accounting_year'];
            $company = $sess_array['comp_code'];
            $invoice_type = $this->input->post('invoice_type');

            $sql = "SELECT ";
            $sql .= ($invoice_type == 'with_tax') ? "IFNULL(MAX(BOOK_NUMBER), 100)+1" : "IFNULL(MAX(BOOK_NUMBER), 0)+1";
            $sql .= " AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='INVOE' and  ACC_YEAR_CODE=$year_code and DEL_FLAG=1 and INVOICE_TYPE='$invoice_type' and COMPANY='$company'";


//            $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='INVOE' and  ACC_YEAR_CODE=$year_code and DEL_FLAG=1");
            $query = $this->db->query($sql);
            $row = $query->row_array();
            $book_num = $row['BOOK_NUMBER'];
            //$book_num=$this->input->post('txt_buk_num');
            $invoice_date = $this->input->post('txt_invoice_date');
            $temp_inv_no = $this->input->post('temp_inv_no');
            $temp_inv_added = $this->input->post('temp_inv_added');
            $cut_id = $this->input->post('txt_cust_name');

            $this->load->library('../controllers/lockdate');
            $this->lockdate->index($invoice_date);
            $check_status = $this->lockdate->check_date($invoice_date);
            $message_display = $this->lockdate->message_val($invoice_date, $check_status);
            if ($check_status == 'true') {
                $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
                $data['cust'] = $this->invoice_model->select_customer('tbl_account');
                $data['description'] = $this->invoice_model->select_description();
                $data['msg'] = '';
                $data['errmsg'] = $message_display;
                $layout = array('page' => 'form_invoice', 'title' => 'Invoice', 'data' => $data);
                render_template($layout);
                return FALSE;
            }
            if ($temp_inv_added == 1) {
                $temp_inv_details = $this->invoice_model->select_temp_invoice_details($temp_inv_no, $year_code, $company)->row();
                if($temp_inv_details->CUSTOMER_ID != $cut_id) {
                    $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
                    $data['cust'] = $this->invoice_model->select_customer('tbl_account');
                    $data['description'] = $this->invoice_model->select_description();
                    $data['msg'] = '';
                    $data['errmsg'] = 'The customer is different in temporary invoice';
                    $layout = array('page' => 'form_invoice', 'title' => 'Invoice', 'data' => $data);
                    render_template($layout);
                    return FALSE;
                }
            }
            $invoice_date = strtotime($invoice_date);
            $invoice_date = date("Y-m-d", $invoice_date);
            
            $total = $this->input->post('subtotal');
            $sgst_percent = $this->input->post('sgst_percent');
            $cgst_percent = $this->input->post('cgst_percent');
            $flood_cess_percent = $this->input->post('flood_cess_percent');
            $sgst_amt = $this->input->post('sgst');
            $cgst_amt = $this->input->post('cgst');
            $flood_cess_amt = $this->input->post('flood_cess');
            $round_off = $this->input->post('round_off');
            $grand_total = $this->input->post('total');
            //$paid_amt = $this->input->post('paid');
            $description = $this->input->post('txt_des');
            $rec_inv = $this->input->post('txt_recrng_inv');
            $rec_inv_type = $this->input->post('txt_recrng_type');
            $rec_inv_cmnt = $this->input->post('txt_rec_cmnt');
            $next_inv_date = $this->input->post('txt_nxt_invoice_date');
            $next_inv_date = strtotime($next_inv_date);
            $next_inv_date = date("Y-m-d", $next_inv_date);
            $curnt_date = date('Y-m-d');
            $cust_name = $this->input->post('lbl_cust_name');
            $sess_array = $this->session->userdata('logged_in');
            $create_by = $sess_array['user_id'];
            $this->load->library('../controllers/lockdate');
            $location_details = $this->lockdate->location_details();
            $create_on = gmdate("Y-m-d H:i:s");

            $data = array('BOOK_NUMBER' => $book_num,
                'CUSTOMER_ID' => $cut_id,
                'BOOK_NAME' => 'INVO',
                'INVOICE_TYPE' => $invoice_type,
                'COMPANY' => $company,
                'INVOICE_DATE' => $invoice_date,
                'DESCRIPTION' => $description,
                'SUB_TOTAL_PRICE' => $total,
                'SGST_PERCENT' => $sgst_percent,
                'CGST_PERCENT' => $cgst_percent,
                'FLOOD_CESS_PERCENT' => $flood_cess_percent,
                'SGST_AMOUNT' => $sgst_amt,
                'CGST_AMOUNT' => $cgst_amt,
                'FLOOD_CESS_AMOUNT' => $flood_cess_amt,
                'ROUND_OFF' => $round_off,
                'TOTAL_PRICE' => $grand_total,
                'CURRENT_DATE' => $curnt_date,
                'ACC_YEAR_CODE' => $year_code,
                'INVOICE_RECURRING' => $rec_inv,
                'INVOICE_RECURRING_TYPE' => $rec_inv_type,
                'INVOICE_RECURRING_COMMENT' => $rec_inv_cmnt,
                'NEXT_INVOICE_DATE' => $next_inv_date,
                'TEMP_INVOICE_ADDED' => $temp_inv_added,
                'TEMP_INVOICE_ID' => $temp_inv_no,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details);
            $this->invoice_model->insert_data('tbl_invoice', $data);
            $invo_id = $this->db->insert_id();

            if (isset($_POST['item'])) {
                for ($i = 0; $i < count($_POST['item']); $i++) {
                    $item = $_POST['item'][$i];
                    $cost = $_POST['cost'][$i];
                    $des = $_POST['description'][$i];
                    $qty = $_POST['qty'][$i];


                    $data = array('ITEM' => $item,
                        'DESCRIPTION' => $des,
                        'UNIT_COST' => $cost,
                        'QUANTITY' => $qty,
                        'INVOICE_ID' => $invo_id,
                        'ACC_YEAR_CODE' => $year_code,
                        'CREATED_BY' => $create_by,
                        'CREATED_ON' => $create_on,
                        'LOCATION_DETAILS' => $location_details);
                    $this->invoice_model->insert_data('tbl_invoicedetails', $data);
//                    echo"<br>";
                }
            }
            $query1 = $this->db->query("SELECT `description` FROM `tbl_invoice_description` WHERE `id`=$description");
            $row1 = $query1->row_array();
            $description1 = $row1['description'];
            $remarks = $description1 . " / " . $cust_name;
            $trn_data = array('FIN_YEAR_ID' => 2,
                'ACC_ID' => 108,
                'INVOICE_ID' => $invo_id ?? null,
                'DATE_OF_TRANSACTION' => $invoice_date,
                'CREDIT' => $grand_total,
                'REMARKS' => $remarks,
                'DEL_FLAG' => 1,
                'BOOK_NUMBER' => $book_num,
                'BOOK_NAME' => 'INVOE',
                'SUB_ACC' => $cut_id,
                'ACC_YEAR_CODE' => $year_code,
                'COMPANY' => $company,
                'INVOICE_TYPE' => $invoice_type,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details);
            $trn_data1 = array('FIN_YEAR_ID' => 2,
                'ACC_ID' => 47,
                'INVOICE_ID' => $invo_id ?? null,
                'DATE_OF_TRANSACTION' => $invoice_date,
                'DEBIT' => $grand_total,
                'REMARKS' => $remarks,
                'DEL_FLAG' => 1,
                'BOOK_NUMBER' => $book_num,
                'BOOK_NAME' => 'INVOE',
                'SUB_ACC' => $cut_id,
                'ACC_YEAR_CODE' => $year_code,
                'COMPANY' => $company,
                'INVOICE_TYPE' => $invoice_type,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details);

            $this->invoice_model->insert_data('tbl_transaction', $trn_data);
            $this->invoice_model->insert_data('tbl_transaction', $trn_data1);

            $temp_data = array(
			    'INVOICE_STATUS' => 1
			);
            $this->db->where('INVOICE_ID', $temp_inv_no);
	        $this->db->where('DEL_FLAG=1');
	        $this->db->update('tbl_temp_invoice', $temp_data);


            $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
            $data['cust'] = $this->invoice_model->select_customer('tbl_account');
            $data['description'] = $this->invoice_model->select_description();
            $data['msg'] = 'Invoice added successfully';
            $data['errmsg'] = "";
//            $layout = array('page' => 'form_invoice', 'title' => 'Invoice', 'data' => $data);
//            render_template($layout);
            redirect('invoice');
        }
    }

    function create_invoice() {
        $menu_id = 35;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_editprocess($menu_id);
        $encrypted_inv_id = $this->uri->segment(3);
        $accounting_year = $this->uri->segment(4);
        $sess_array = $this->session->userdata('logged_in');
        $company = $sess_array['comp_code'];
        $encrypted_inv_id = str_replace("~", "/", $encrypted_inv_id);
        $encrypted_inv_id = str_replace("-", "=", $encrypted_inv_id);
        $encrypted_inv_id = str_replace(".", "+", $encrypted_inv_id);
        $temp_inv_id = $this->encryption->decrypt($encrypted_inv_id);
        $data['vno'] = $this->invoice_model->get_invoice($temp_inv_id,$accounting_year);
        $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
        $data['cust'] = $this->invoice_model->select_customer('tbl_account');
        $data['description'] = $this->invoice_model->select_description();
        $data['msg'] = 'Invoice added successfully';
        $data['errmsg'] = "";
        $layout = array('page' => 'form_create_invoice', 'title' => 'Invoice', 'data' => $data);
        render_template($layout);
    }

    function invoice_list() {
        $menu_id = 44;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $sess_array = $this->session->userdata('logged_in');
        $company = $sess_array['comp_code'];
        $data['company_code'] = $company;
        $data['list'] = $this->invoice_model->invoice_list($company);
        $layout = array('page' => 'form_invoice_list', 'title' => 'Invoice', 'data' => $data);
        render_template($layout);
    }

    function print_invoice() {
        $data_id = $this->uri->segment(3);
        $accounting_year = $this->uri->segment(4);
        $data['encrypted_data'] = $data_id;
        $sess_array = $this->session->userdata('logged_in');
        $company = $sess_array['comp_code'];
//        $generate_pdf = $this->input->post('generate_pdf');
        $data_id = str_replace("~", "/", $data_id);
        $data_id = str_replace("-", "=", $data_id);
        $data_id = str_replace(".", "+", $data_id);
        $book_num = $this->encryption->decrypt($data_id);
        $invoiceId = decrypt($this->uri->segment(5)) ?? null;
        $data['vno'] = $this->invoice_model->invoice_edit($book_num, $accounting_year, $company, $invoiceId);
        $data['company'] = $this->invoice_model->select_company($company);
//        if ($generate_pdf == 'generate_pdf') {
//            $html = $this->load->view('invoice_pdf', $data);
        $this->load->library('pdfgenerator');
        $html = $this->load->view('invoice_pdf', $data, true);
        $filename = 'invoice_report_' . time();
        $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
//        } else {
////            $this->load->view('invoice_pdf', $data);
//            $this->load->view('form_print_invoice', $data);
//        }
    }

    function invoice_details() {
        $book_num = $this->input->post('voc_no');
        $data['vno'] = $this->invoice_model->invoice_edit($book_num);
        $this->load->view('form_acclist1', $data);
    }

    function invoice_edit() {
        $menu_id = 35;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_editprocess($menu_id);
        $data_id = $this->uri->segment(3);
        $accounting_year = $this->uri->segment(4);
        $sess_array = $this->session->userdata('logged_in');
        $company = $sess_array['comp_code'];
        $data_id = str_replace("~", "/", $data_id);
        $data_id = str_replace("-", "=", $data_id);
        $data_id = str_replace(".", "+", $data_id);
        $book_num = $this->encryption->decrypt($data_id);
        //$book_num= $this->uri->segment(3);
        $invoiceId = decrypt($this->uri->segment(5)) ?? null;
        $data['vno'] = $this->invoice_model->invoice_edit($book_num, $accounting_year, $company, $invoiceId);
        $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
        $data['cust'] = $this->invoice_model->select_customer('tbl_account');
        $data['description'] = $this->invoice_model->select_description();
        $data['msg'] = 'Invoice added successfully';
        $data['errmsg'] = "";
        $layout = array('page' => 'form_invoice_edit', 'title' => 'Invoice', 'data' => $data);
        render_template($layout);
    }

    function account_list() {
        $acc_name = $this->input->post('name');

        $data['cond'] = $this->invoice_model->select_All('invoice_account_herd', $acc_name);
        $this->load->view('form_acclist', $data);
    }

    function add_list() {
        $acc_name = $this->input->post('name');

        $data['cond'] = $this->invoice_model->select_All('tbl_account', $acc_name);
        $this->load->view('form_acclist', $data);
    }

    function customer_details() {
        $cust_id = $this->input->post('cust_id');

        $data['customer'] = $this->invoice_model->select_customer_details('tbl_account', $cust_id);
        $this->load->view('form_customer', $data);
    }

    function invoice_update() {
        $sess_array = $this->session->userdata('logged_in');
        $year_code = $sess_array['accounting_year'];
        $company = $sess_array['comp_code'];
        $invoice_id = $this->input->post('hdd_invo_id');
        $book_num = $this->input->post('hdd_buk_num');
        $invoice_date = $this->input->post('txt_invoice_date');
        $invoice_type = $this->input->post('invoice_type');
        $temp_inv_no = $this->input->post('temp_inv_no');
        $temp_inv_added = $this->input->post('temp_inv_added');
        $cut_id = $this->input->post('txt_cust_name');
        $this->load->library('../controllers/lockdate');
        $this->lockdate->index($invoice_date);
        $check_status = $this->lockdate->check_date($invoice_date);
        $message_display = $this->lockdate->message_val($invoice_date, $check_status);
        if ($check_status == 'true') {
            $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
            $data['cust'] = $this->invoice_model->select_customer('tbl_account');
            $data['description'] = $this->invoice_model->select_description();
            $data['msg'] = '';
            $data['errmsg'] = $message_display;
            $layout = array('page' => 'form_invoice', 'title' => 'Invoice', 'data' => $data);
            render_template($layout);
            return FALSE;
//            redirect('invoice');
        }
        if ($temp_inv_added == 1) {
            $temp_inv_details = $this->invoice_model->select_temp_inv_details($temp_inv_no, $year_code, $company)->row();
            if($temp_inv_details->CUSTOMER_ID != $cut_id) {
                $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
                $data['cust'] = $this->invoice_model->select_customer('tbl_account');
                $data['description'] = $this->invoice_model->select_description();
                $data['msg'] = '';
                $data['errmsg'] = 'The customer is different in temporary invoice';
                $layout = array('page' => 'form_invoice', 'title' => 'Invoice', 'data' => $data);
                render_template($layout);
                return FALSE;
            }
        }
//        $query2 = $this->db->query("select ACC_YEAR_CODE from tbl_transaction where BOOK_NUMBER=$book_num AND BOOK_NAME='INVOE' AND DEL_FLAG=1 and COMPANY='$company'");
//        $val2 = $query2->row_array();
//        $acc_year = $val2['ACC_YEAR_CODE'];
        $acc_year = $this->input->post('acc_year');
        if ($year_code != $acc_year) {
            $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
            $data['cust'] = $this->invoice_model->select_customer('tbl_account');
            $data['description'] = $this->invoice_model->select_description();
            $data['msg'] = '';
            $data['errmsg'] = "Accounting Year Do not match";
            $layout = array('page' => 'form_invoice', 'title' => 'Invoice', 'data' => $data);
            render_template($layout);
            return FALSE;
//            redirect('invoice');
        }
        $invoice_date = strtotime($invoice_date);
        $invoice_date = date("Y-m-d", $invoice_date);
        $total = $this->input->post('subtotal');
        $sgst_percent = $this->input->post('sgst_percent');
        $cgst_percent = $this->input->post('cgst_percent');
        $flood_cess_percent = $this->input->post('flood_cess_percent');
        $sgst_amt = $this->input->post('sgst');
        $cgst_amt = $this->input->post('cgst');
        $flood_cess_amt = $this->input->post('flood_cess');
        $round_off = $this->input->post('round_off');
        $grand_total = $this->input->post('total');
        //$paid_amt = $this->input->post('paid');
        $description = $this->input->post('txt_des');
        $rec_inv = $this->input->post('txt_recrng_inv');
        $rec_inv_type = $this->input->post('txt_recrng_type');
        $rec_inv_cmnt = $this->input->post('txt_rec_cmnt');
        $next_inv_date = $this->input->post('txt_nxt_invoice_date');
        $next_inv_date = strtotime($next_inv_date);
        $next_inv_date = date("Y-m-d", $next_inv_date);

        $cust_name = $this->input->post('lbl_cust_name');
        $curnt_date = date('Y-m-d');

        $sess_array = $this->session->userdata('logged_in');
        $modified_by = $sess_array['user_id'];
        $this->load->library('../controllers/lockdate');
        $location_details = $this->lockdate->location_details();
        $modified_on = gmdate("Y-m-d H:i:s");
        $this->db->query("update tbl_invoice set DEL_FLAG=0,MODIFIED_BY=$modified_by,MODIFIED_ON='$modified_on',
         LOCATION_DETAILS='$location_details' where INVOICE_ID='$invoice_id'");
        $this->db->query("update tbl_invoicedetails set DEL_FLAG=0,MODIFIED_BY=$modified_by,MODIFIED_ON='$modified_on',LOCATION_DETAILS='$location_details' where INVOICE_ID='$invoice_id'");

        $sess_array = $this->session->userdata('logged_in');
        $create_by = $sess_array['user_id'];
        $this->load->library('../controllers/lockdate');
        $location_details = $this->lockdate->location_details();
        $create_on = gmdate("Y-m-d H:i:s");

        $data = array('BOOK_NUMBER' => $book_num,
            'CUSTOMER_ID' => $cut_id,
            'BOOK_NAME' => 'INVO',
            'INVOICE_TYPE' => $invoice_type,
            'INVOICE_DATE' => $invoice_date,
            'DESCRIPTION' => $description,
            'SUB_TOTAL_PRICE' => $total,
            'SGST_PERCENT' => $sgst_percent,
            'CGST_PERCENT' => $cgst_percent,
            'FLOOD_CESS_PERCENT' => $flood_cess_percent,
            'SGST_AMOUNT' => $sgst_amt,
            'CGST_AMOUNT' => $cgst_amt,
            'FLOOD_CESS_AMOUNT' => $flood_cess_amt,
            'ROUND_OFF' => $round_off,
            'TOTAL_PRICE' => $grand_total,
            //'PAID_PRICE' => $paid_amt,
            'CURRENT_DATE' => $curnt_date,
            'ACC_YEAR_CODE' => $year_code,
            'COMPANY' => $company,
            'INVOICE_RECURRING' => $rec_inv,
            'INVOICE_RECURRING_TYPE' => $rec_inv_type,
            'INVOICE_RECURRING_COMMENT' => $rec_inv_cmnt,
            'NEXT_INVOICE_DATE' => $next_inv_date,
            'TEMP_INVOICE_ADDED' => $temp_inv_added,
            'TEMP_INVOICE_ID' => $temp_inv_no,
            'CREATED_BY' => $create_by,
            'CREATED_ON' => $create_on,
            'LOCATION_DETAILS' => $location_details);

        $this->invoice_model->insert_data('tbl_invoice', $data);
        $invo_id = $this->db->insert_id();

        if (isset($_POST['item'])) {
            for ($i = 0; $i < count($_POST['item']); $i++) {
                $item = $_POST['item'][$i];
                $cost = $_POST['cost'][$i];
                $des = $_POST['description'][$i];
                $qty = $_POST['qty'][$i];

                $data = array('ITEM' => $item,
                    'DESCRIPTION' => $des,
                    'UNIT_COST' => $cost,
                    'QUANTITY' => $qty,
                    'INVOICE_ID' => $invo_id,
                    'ACC_YEAR_CODE' => $year_code,
                    'CREATED_BY' => $create_by,
                    'CREATED_ON' => $create_on,
                    'LOCATION_DETAILS' => $location_details);
                $this->invoice_model->insert_data('tbl_invoicedetails', $data);
//                echo"<br>";
            }
        }
        $this->db->query("update tbl_transaction set DEL_FLAG=0,MODIFIED_BY=$modified_by,MODIFIED_ON='$modified_on',
         LOCATION_DETAILS='$location_details' where BOOK_NAME='INVOE' AND BOOK_NUMBER='$book_num' ");

        $query1 = $this->db->query("SELECT `description` FROM `tbl_invoice_description` WHERE `id`=$description");
        $row1 = $query1->row_array();
        $description1 = $row1['description'];
        $remarks = $description1 . " / " . $cust_name;
        $trn_data = array('FIN_YEAR_ID' => 2,
            'ACC_ID' => 108,
            'DATE_OF_TRANSACTION' => $invoice_date,
            'CREDIT' => $grand_total,
            'REMARKS' => $remarks,
            'DEL_FLAG' => 1,
            'BOOK_NUMBER' => $book_num,
            'BOOK_NAME' => 'INVOE',
            'SUB_ACC' => $cut_id,
            'ACC_YEAR_CODE' => $year_code,
            'COMPANY' => $company,
            'INVOICE_TYPE' => $invoice_type,
            'CREATED_BY' => $create_by,
            'CREATED_ON' => $create_on,
            'LOCATION_DETAILS' => $location_details);
        $trn_data1 = array('FIN_YEAR_ID' => 2,
            'ACC_ID' => 47,
            'DATE_OF_TRANSACTION' => $invoice_date,
            'DEBIT' => $grand_total,
            'REMARKS' => $remarks,
            'DEL_FLAG' => 1,
            'BOOK_NUMBER' => $book_num,
            'BOOK_NAME' => 'INVOE',
            'SUB_ACC' => $cut_id,
            'ACC_YEAR_CODE' => $year_code,
            'COMPANY' => $company,
            'INVOICE_TYPE' => $invoice_type,
            'CREATED_BY' => $create_by,
            'CREATED_ON' => $create_on,
            'LOCATION_DETAILS' => $location_details);

        $this->invoice_model->insert_data('tbl_transaction', $trn_data);
        $this->invoice_model->insert_data('tbl_transaction', $trn_data1);


        $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
        $data['cust'] = $this->invoice_model->select_customer('tbl_account');
        $data['description'] = $this->invoice_model->select_description();
        $data['msg'] = 'Invoice Edited Successfully';
        $data['errmsg'] = "";
//        $layout = array('page' => 'form_invoice', 'title' => 'Invoice', 'data' => $data);
//        render_template($layout);
        redirect('invoice');

        /* $data['sub_acc_list']= $this->invoice_model->select_sub_acc('tbl_account');
          $data['cust']=$this->invoice_model->select_customer('tbl_account');
          $data['msg']='Invoice added successfully';
          $data['errmsg']="";
          $layout=array('page'=>'form_invoice','title'=>'Invoice','data'=>$data);
          render_template($layout); */
      }

      function select_data() {
        //echo "Hai";
        $buk_num = $this->input->post('voc_no');

        $data['vno'] = $this->invoice_model->select_info('tbl_transaction', $buk_num);
        $this->load->view('form_displayData', $data);
    }

    function invoice_delete() {
        $menu_id = 35;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $sess_array = $this->session->userdata('logged_in');
        $year_code = $sess_array['accounting_year'];
        $company = $sess_array['comp_code'];
        $data_id = $this->uri->segment(3);
        $acc_year = $this->uri->segment(4);
        $invoiceId = decrypt($this->uri->segment(5)) ?? null;
        $data_id = str_replace("~", "/", $data_id);
        $data_id = str_replace("-", "=", $data_id);
        $data_id = str_replace(".", "+", $data_id);
        $book_num = $this->encryption->decrypt($data_id);
        $query2 = $this->db->query("select ACC_YEAR_CODE,DATE_OF_TRANSACTION from tbl_transaction where BOOK_NUMBER=$book_num AND BOOK_NAME='INVOE' AND DEL_FLAG=1 and  ACC_YEAR_CODE=$acc_year");
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

            //$book_num= $this->uri->segment(3);
            $data['vno'] = $this->invoice_model->invoice_edit($book_num, $acc_year, $company, $invoiceId);
            $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
            $data['cust'] = $this->invoice_model->select_customer('tbl_account');
            $data['description'] = $this->invoice_model->select_description();
            $data['msg'] = '';
            $data['errmsg'] = "";
            $layout = array('page' => 'form_invoice_delete', 'title' => 'Invoice', 'data' => $data);
            render_template($layout);
        } else {
            $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
            $data['cust'] = $this->invoice_model->select_customer('tbl_account');
            $data['description'] = $this->invoice_model->select_description();
            $data['msg'] = '';
            $data['errmsg'] = $message_display;
//            $layout = array('page' => 'form_invoice', 'title' => 'Invoice', 'data' => $data);
//            render_template($layout);
//            return FALSE;
            redirect('invoice');
        }
    }

    function del_data() {
        $menu_id = 35;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $buk_num = $this->input->post('txt_buk_num');
        $sess_array = $this->session->userdata('logged_in');
        $deleted_by = $sess_array['user_id'];
        $accounting_year = $sess_array['accounting_year'];
        $this->load->library('../controllers/lockdate');
        $location_details = $this->lockdate->location_details();
        $deleted_on = gmdate("Y-m-d H:i:s");
        $data = array('DEL_FLAG' => '0',
            'DELETED_BY' => $deleted_by,
            'DELETED_ON' => $deleted_on,
            'LOCATION_DETAILS' => $location_details);

        $this->invoice_model->delete_data1('tbl_transaction', $data, $buk_num, $accounting_year);
    }

    function delete_data() {
        $menu_id = 35;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $invoice_id = $this->input->post('hdd_invo_id');
        $book_num = $this->input->post('txt_buk_num');
        $sess_array = $this->session->userdata('logged_in');
        $deleted_by = $sess_array['user_id'];
        $accounting_year = $sess_array['accounting_year'];
        $this->load->library('../controllers/lockdate');
        $location_details = $this->lockdate->location_details();
        $deleted_on = gmdate("Y-m-d H:i:s");
        $data = array('DEL_FLAG' => '0',
            'DELETED_BY' => $deleted_by,
            'DELETED_ON' => $deleted_on,
            'LOCATION_DETAILS' => $location_details);
        $this->invoice_model->delete_data1('tbl_transaction', $data, $book_num, $accounting_year);
        $this->invoice_model->invo_delete('tbl_invoice', $data, $invoice_id);
        $this->invoice_model->invo_delete('tbl_invoicedetails', $data, $invoice_id);

        $temp_inv_id = $this->input->post('temp_inv_id');
        $temp_data = array(
		    'INVOICE_STATUS' => 0
		);
        $this->db->where('INVOICE_ID', $temp_inv_id);
        $this->db->where('DEL_FLAG=1');
        $this->db->update('tbl_temp_invoice', $temp_data);

        $data['sub_acc_list'] = $this->invoice_model->select_sub_acc('tbl_account');
        $data['cust'] = $this->invoice_model->select_customer('tbl_account');
        $data['description'] = $this->invoice_model->select_description();
        $data['msg'] = 'Invoice Deleted successfully';
        $data['errmsg'] = "";
//        $layout = array('page' => 'form_invoice', 'title' => 'Invoice', 'data' => $data);
//        render_template($layout);
        redirect('invoice');

        /* $data['sub_acc_list']= $this->invoice_model->select_sub_acc('tbl_account');
          $data['cust']=$this->invoice_model->select_customer('tbl_account');
          $data['msg']='Invoice delete successfully';
          $data['errmsg']="";
          $layout=array('page'=>'form_invoice','title'=>'Invoice','data'=>$data);
          render_template($layout); */
      }

      function mult_search() {
        $type = $this->input->post('type');
        $dat_from = $this->input->post('calc');
        if ($dat_from != '') {
            $dat_from = strtotime($dat_from);
            $dat_from = date("Y-m-d", $dat_from);
        } else {
            $dat_from = date("Y-m-1");
        }

        $dat_to = $this->input->post('dat');
        if ($dat_to != '') {
            $dat_to = strtotime($dat_to);
            $dat_to = date("Y-m-d", $dat_to);
        } else {
            $dat_to = date("Y-m-d");
        }
        $key_words = $this->input->post('key_words');
        $inv_type = $this->input->post('inv_type');
        $data['type'] = $type;
        if ($type == 'recurring') {
            $data['serch'] = $this->invoice_model->recurring_invoice_list($dat_from);
        } else {
            $data['serch'] = $this->invoice_model->multipe_select($dat_from, $dat_to, $key_words, $inv_type);
        }
        $this->load->view('form_search_data', $data);
    }

    function recurring_invoice_list() {
        $menu_id = 73;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
//        $data['staff_list'] = $this->dashboard_model->selectStaff();
        $from_date = date('Y-m-d');
//        $to_date = date('Y-m-d H:i:s');
//        $to_date = date('Y-m-d', strtotime('+1 month'));
        $data['cond'] = $this->invoice_model->recurring_invoice_list($from_date);
        $layout = array('page' => 'form_recrng_invoice_list', 'title' => 'Reecurring Invoice List', 'data' => $data);
        render_template($layout);
    }

    function gst_invoice_list() {
        $menu_id = 76;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
//        $sess_array = $this->session->userdata('logged_in');
//        $year_code = $sess_array['accounting_year'];
//        $company = $sess_array['comp_code'];
        $data['company'] = $this->invoice_model->select_company();
        $layout = array('page' => 'form_gst_invoice_list', 'title' => 'GST Invoice List', 'data' => $data);
        render_template($layout);
    }

    function get_gst_invoice_list() {
        $dat_from = $this->input->post('frm');
        if ($dat_from != '') {
            $dat_from = strtotime($dat_from);
            $dat_from = date("Y-m-d", $dat_from);
        } else {
            $dat_from = date("Y-m-1");
        }

        $dat_to = $this->input->post('to');
        if ($dat_to != '') {
            $dat_to = strtotime($dat_to);
            $dat_to = date("Y-m-d", $dat_to);
        } else {
            $dat_to = date("Y-m-d");
        }
        $key_words = $this->input->post('key_words');
        $company_code = $this->input->post('company_code');
        $generate_pdf = $this->input->post('generate_pdf');
        $data['company'] = $this->invoice_model->select_company($company_code);
        $data['frm'] = $this->input->post('frm');
        $data['to'] = $this->input->post('to');
//        $data['type'] = $type;
//        if($type == 'recurring') {
//            $data['serch'] = $this->invoice_model->recurring_invoice_list($dat_from); 
//        } else {
        $data['serch'] = $this->invoice_model->get_gst_invoice_list($dat_from, $dat_to, $key_words, $company_code);
//        }
        if ($generate_pdf == 'generate_pdf') {

//            $html = $this->load->view('invoice_pdf', $data);
            $this->load->library('pdfgenerator');
            $html = $this->load->view('gst_invoice_pdf', $data, true);
            $filename = 'gst_invoice_report_' . time();
            $this->pdfgenerator->generate($html, $filename, true, 'A4', 'landscape');
        } else if ($generate_pdf == 'generate_excel') {
            $filename = 'gst_invoice_report_' . time() . '.xls';
            $html = $this->load->view('gst_invoice_excel', $data, true);
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$filename");
            echo $html;
        } else {
            $this->load->view('form_gst_search_data', $data);
        }
    }


    function api_gst_invoice_report() {
        $this->load->library('../controllers/Permition_checker_api');
        $this->form_validation->set_rules('menu_id','Menu Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('from_date','From Date','trim');
        $this->form_validation->set_rules('to_date','To Date','trim');
        $this->form_validation->set_rules('company','Company','trim|required');
        $this->form_validation->set_rules('key_words','Key Words','trim');
        if ($this->form_validation->run() != TRUE) {
            $data['status'] = 0;
            $data['msg'] = 'Data Validation Error';
            header('Content-Type: application/json');
            echo json_encode($data);
        } 
        else {
            $menu_id = $this->input->post('menu_id');
            $user_id = $this->input->post('user_id');
            $return = $this->permition_checker_api->permition_viewprocess($menu_id, $user_id);
            if($return == 'access_denied') {
                $data['status'] = 0;
                $data['msg'] = "Access Denied";
                header('Content-Type: application/json');
                echo json_encode($data);
            }
            else {
                $from_date = $this->input->post('from_date');
                $from_date = strtotime($from_date);
                $from_date = date('Y-m-d', $from_date);
                $to_date = $this->input->post('to_date');
                $to_date = strtotime($to_date);
                $to_date = date('Y-m-d', $to_date);
                $company = $this->input->post('company');
                $key_words = $this->input->post('key_words');
                $data= $this->invoice_model->get_gst_invoice_list($from_date, $to_date, $key_words, $company)->result();
                if(count($data) > 0) {
                    $retrn_value = array('status' => 1, 'data'=> $data);
                    header('Content-Type: application/json');
                    echo json_encode($retrn_value);
                }
                else {
                    $data['status'] = 0;
                    $data['msg'] = "No Data Found";
                    header('Content-Type: application/json');
                    echo json_encode($data);
                }   
            }    
        }
    }


    function payment_report() {
        $menu_id = 80;
        $this->load->library('../controllers/permition_checker');
        // $this->permition_checker->permition_viewprocess($menu_id);
        $data['company'] = $this->invoice_model->select_company();
        $layout = array('page' => 'form_payment_report', 'title' => 'Payment Report', 'data' => $data);
        render_template($layout);
    }

    function get_payment_report_list() {
        $dat_from = $this->input->post('frm');
        if ($dat_from != '') {
            $dat_from = date("Y-m-d", strtotime($dat_from));
        } else {
            $dat_from = date("Y-m-1");
        }

        $dat_to = $this->input->post('to');
        if ($dat_to != '') {
            $dat_to = date("Y-m-d", strtotime($dat_to));
        } else {
            $dat_to = date("Y-m-d");
        }
        $key_words = $this->input->post('key_words');
        $invoice_type = $this->input->post('invoice_type');
        $generate_pdf = $this->input->post('generate_pdf');
        $data['company'] = $this->invoice_model->select_company(1); //sis company id is 1
        $data['frm'] = $this->input->post('frm');
        $data['to'] = $this->input->post('to');
        $data['serch'] = $this->invoice_model->get_payment_report_list($dat_from, $dat_to, $key_words, $invoice_type);
        if ($generate_pdf == 'generate_pdf') {

            $this->load->library('pdfgenerator');
            $html = $this->load->view('payment_report_pdf', $data, true);
            $filename = 'payment_report_' . time();
            $this->pdfgenerator->generate($html, $filename, true, 'A4', 'landscape');
        } else if ($generate_pdf == 'generate_excel') {
            $filename = 'payment_report_' . time() . '.xls';
            $html = $this->load->view('payment_report_excel', $data, true);
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$filename");
            echo $html;
        } else {
            $this->load->view('form_payment_report_search_data', $data);
        }
    }

    function print_payment_report() {
        $data_id = $this->uri->segment(3);
        $accounting_year = $this->uri->segment(4);
        $data['encrypted_data'] = $data_id;
        $sess_array = $this->session->userdata('logged_in');
        $company = $sess_array['comp_code'];
        $data_id = str_replace("~", "/", $data_id);
        $data_id = str_replace("-", "=", $data_id);
        $data_id = str_replace(".", "+", $data_id);
        $book_num = $this->encryption->decrypt($data_id);
        $invoiceId = decrypt($this->uri->segment(5)) ?? null;
        $data['vno'] = $this->invoice_model->invoice_edit($book_num, $accounting_year, $company, $invoiceId);
        $data['company'] = $this->invoice_model->select_company($company);
        $this->load->library('pdfgenerator');
        $html = $this->load->view('invoice_pdf', $data, true);
        $filename = 'invoice_report_' . time();
        $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
    }

}

?>