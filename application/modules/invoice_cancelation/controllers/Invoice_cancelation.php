<?php

class Invoice_cancelation extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->model('invoice_cancelation_model');
    }

    function index() {
        $menu_id = 62;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_viewprocess($menu_id);
        $data['msg'] = "";
        $data['errmsg'] = "";
        $layout = array('page' => 'form_invoice_cancelation', 'title' => 'Invoice', 'data' => $data);
        render_template($layout);
    }

    function invoice_details() {

        $book_num = $this->input->post('invoice_no');

        $data['vno'] = $this->invoice_cancelation_model->invoice_edit($book_num);

        $data['msg'] = '';
        $data['errmsg'] = "";
        $this->load->view('form_invoice_edit', $data);
    }

    function add_cancelation() {
        $menu_id = 62;
        $this->load->library('../controllers/permition_checker');
        $this->form_validation->set_rules('txt_validation', 'Invoice date', 'required');
        if ($this->form_validation->run() != FALSE) {
            $this->permition_checker->permition_addprocess($menu_id);
            $sess_array = $this->session->userdata('logged_in');
            $year_code = $sess_array['accounting_year'];
            $cust_id = $this->input->post('txt_cust');
            $book_name = 'DRTN';
            $book_num = $this->input->post('temp_cancel_num');
            $invo_book_num = $this->input->post('hdd_buk_num');
            if ($book_num == '') {
                $description1 = $this->input->post('txt_descri');
                $description = 'Invoice canceled (INVOE' . $invo_book_num . ') ' . $description1;
            } else {
                $description = $this->input->post('txt_descri');
            }
            $total_price = $this->input->post('txt_total');
            $cancel_amount = $this->input->post('txt_can_amount');
            $cancel_date = $this->input->post('txt_cancel_date');
            if ($cancel_date != '') {
                $cancel_date = strtotime($cancel_date);
                $cancel_date = date('Y-m-d', $cancel_date);
            }
            $current_date = date('Y-m-d');
            $invoice_id = $this->input->post('txt_inv_id');
            $sess_array = $this->session->userdata('logged_in');
            $year_code = $sess_array['accounting_year'];
            $create_by = $sess_array['user_id'];
            $create_on = gmdate("Y-m-d H:i:s");
            $this->load->library('../controllers/lockdate');
            $this->lockdate->index($cancel_date);
            $check_status = $this->lockdate->check_date($cancel_date);
            $message_display = $this->lockdate->message_val($cancel_date, $check_status);
            if ($check_status == 'true') {
                $data['msg'] = "";
                $data['errmsg'] = $message_display;
                $layout = array('page' => 'form_invoice_cancelation', 'title' => 'Invoice', 'data' => $data);
                render_template($layout);
                return FALSE;
            }
            $location_details = $this->lockdate->location_details();

            if ($book_num != '') {
                $this->permition_checker->permition_editprocess($menu_id);
                $query2 = $this->db->query("select ACC_YEAR_CODE,CANCELATION_DATE from tbl_invoice_cancelation where BOOK_NUM=$book_num AND BOOK_NAME='DRTN' AND DEL_FLAG=1");
                $val2 = $query2->row_array();
                $acc_year = $val2['ACC_YEAR_CODE'];
                $cancel_date = $val2['CANCELATION_DATE'];
                $sess_array = $this->session->userdata('logged_in');
                $year_code = $sess_array['accounting_year'];
                $this->load->library('../controllers/lockdate');
                $this->lockdate->index($cancel_date);
                $check_status = $this->lockdate->check_date($cancel_date);
                $message_display = $this->lockdate->message_val($cancel_date, $check_status);
                if ($check_status == 'true') {
                    $data['msg'] = "";
                    $data['errmsg'] = $message_display;
                    $layout = array('page' => 'form_invoice_cancelation', 'title' => 'Invoice', 'data' => $data);
                    render_template($layout);
                    return FALSE;
                }
                if ($acc_year == $year_code) {
                    $modified_on = gmdate("Y-m-d H:i:s");
                    $this->db->query("update tbl_invoice_cancelation set DEL_FLAG=0,MODIFIED_BY=$create_by,MODIFIED_ON='$modified_on',LOCATION_DETAILS='$location_details' where BOOK_NUM=$book_num");
                } else {
                    $data['msg'] = "";
                    $data['errmsg'] = "Accounting Year Do not Match";
                    $layout = array('page' => 'form_invoice_cancelation', 'title' => 'Invoice', 'data' => $data);
                    render_template($layout);
                    return FALSE;
                }
            } else {
                $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUM), 100)+1 AS BOOK_NUMBER FROM tbl_invoice_cancelation");
                $row = $query->row_array();
                $book_num = $row['BOOK_NUMBER'];
            }
            $data_cancel = array('BOOK_NUM' => $book_num,
                'CUSTOMER_ID' => $cust_id,
                'BOOK_NAME' => $book_name,
                'DEL_FLAG' => 1,
                'DESCRIPTION' => $description,
                'TOTAL_PRICE' => $total_price,
                'CANCEL_AMOUNT' => $cancel_amount,
                'CANCELATION_DATE' => $cancel_date,
                'CURRENT_DATE' => $current_date,
                'ACC_YEAR' => $year_code,
                'INVOICE_ID' => $invoice_id,
                'CREATED_ON' => $create_on,
                'CREATED_BY' => $create_by,
                'LOCATION_DETAILS' => $location_details,
                'ACC_YEAR_CODE' => $year_code);
            $this->invoice_cancelation_model->insert('tbl_invoice_cancelation', $data_cancel);
            $trn_data = array('ACC_ID' => 47,
                'DATE_OF_TRANSACTION' => $cancel_date,
                'CREDIT' => $cancel_amount,
                'REMARKS' => $description,
                'DEL_FLAG' => 1,
                'BOOK_NUMBER' => $book_num,
                'BOOK_NAME' => 'DRTN',
                'SUB_ACC' => $cust_id,
                'ACC_YEAR_CODE' => $year_code,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details,
                'ACC_YEAR_CODE' => $year_code);
            $trn_data1 = array('ACC_ID' => 133,
                'DATE_OF_TRANSACTION' => $cancel_date,
                'DEBIT' => $cancel_amount,
                'REMARKS' => $description,
                'DEL_FLAG' => 1,
                'BOOK_NUMBER' => $book_num,
                'BOOK_NAME' => 'DRTN',
                'SUB_ACC' => $cust_id,
                'ACC_YEAR_CODE' => $year_code,
                'CREATED_BY' => $create_by,
                'CREATED_ON' => $create_on,
                'LOCATION_DETAILS' => $location_details,
                'ACC_YEAR_CODE' => $year_code);
            $this->invoice_cancelation_model->insert('tbl_transaction', $trn_data);
            $this->invoice_cancelation_model->insert('tbl_transaction', $trn_data1);
            $invo_book_num = $this->input->post('hdd_buk_num');
            $invo_book_name = 'INVO';
            $data_up = array('CANCEL_AMOUNT' => $cancel_amount,
                'CANCEL_STATUS' => "CANCELED");
            $this->invoice_cancelation_model->update('tbl_transaction', $data_up, $invo_book_num, $invo_book_name);
            $this->invoice_cancelation_model->update('tbl_invoice', $data_up, $invo_book_num, $invo_book_name);
            $data['msg'] = "Invoice Canceled Successfully";
            $data['errmsg'] = "";
            $layout = array('page' => 'form_invoice_cancelation', 'title' => 'Invoice', 'data' => $data);
            render_template($layout);
        } else {
            $data['msg'] = "";
            $data['errmsg'] = "No invoice Selected";
            $layout = array('page' => 'form_invoice_cancelation', 'title' => 'Invoice', 'data' => $data);
            render_template($layout);
        }
    }

    function invoice_cancel_details() {
        $cancel_book_no = $this->input->post('cancel_no');
        $data['cancel_details'] = $this->db->query("select tbl_invoice_cancelation.*,tbl_invoice.BOOK_NUMBER as b_no from tbl_invoice_cancelation join tbl_invoice on tbl_invoice_cancelation.INVOICE_ID=tbl_invoice.INVOICE_ID where tbl_invoice_cancelation.DEL_FLAG=1 and tbl_invoice_cancelation.BOOK_NUM=$cancel_book_no");
        if ($data['cancel_details']->num_rows() < 1) {
            $data['msg'] = "";
            $data['errmsg'] = "Not Found";
            $this->load->view('form_cancel_error', $data);
            return FALSE;
        }
        $val = $data['cancel_details']->row_array();

        $book_num = $val['b_no'];
        $data['vno'] = $this->invoice_cancelation_model->invoice_edit2($book_num);
        $data['msg'] = "";
        $data['errmsg'] = "";
        $this->load->view('form_cancelation_edit', $data);
    }

    function account_delete() {
        $menu_id = 62;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $cancel_no = $this->uri->segment(3);
        $query2 = $this->db->query("select ACC_YEAR_CODE,CANCELATION_DATE from tbl_invoice_cancelation where BOOK_NUM=$cancel_no AND BOOK_NAME='DRTN' AND DEL_FLAG=1");
        $val2 = $query2->row_array();
        $acc_year = $val2['ACC_YEAR_CODE'];
        $cancel_date = $val2['CANCELATION_DATE'];
        $sess_array = $this->session->userdata('logged_in');
        $year_code = $sess_array['accounting_year'];
        $this->load->library('../controllers/lockdate');
        $this->lockdate->index($cancel_date);
        $check_status = $this->lockdate->check_date($cancel_date);
        $message_display = $this->lockdate->message_val($cancel_date, $check_status);
        if ($check_status == 'true') {
            $data['msg'] = "";
            $data['errmsg'] = $message_display;
            $layout = array('page' => 'form_invoice_cancelation', 'title' => 'Invoice', 'data' => $data);
            render_template($layout);
            return FALSE;
        }
        if ($acc_year == $year_code) {
            $sess_array = $this->session->userdata('logged_in');
            $deleted_by = $sess_array['user_id'];
            $deleted_on = gmdate("Y-m-d H:i:s");

            $query1 = $this->db->query("select tbl_invoice_cancelation.*,tbl_invoice.BOOK_NUMBER as b_no from tbl_invoice_cancelation join tbl_invoice on tbl_invoice_cancelation.INVOICE_ID=tbl_invoice.INVOICE_ID where tbl_invoice_cancelation.DEL_FLAG=1 and tbl_invoice_cancelation.BOOK_NUM=$cancel_no");
            $val = $query1->row_array();
            $book_num = $val['b_no'];
            $this->db->query("update tbl_invoice_cancelation set DEL_FLAG=0,DELETED_BY=$deleted_by,DELETED_ON='$deleted_on' where BOOK_NUM=$cancel_no and DEL_FLAG=1");
            $this->db->query("update tbl_transaction set CANCEL_AMOUNT='',CANCEL_STATUS='ACTIVE' where BOOK_NUMBER=$book_num and BOOK_NAME='INVOE' and DEL_FLAG=1");
            $this->db->query("update tbl_invoice set CANCEL_AMOUNT='',CANCEL_STATUS='ACTIVE' where BOOK_NUMBER=$book_num and BOOK_NAME='INVO' and DEL_FLAG=1");
            redirect('invoice_cancelation');
        } else {
            $data['msg'] = "";
            $data['errmsg'] = "Accounting Year Do not Match";
            $layout = array('page' => 'form_invoice_cancelation', 'title' => 'Invoice', 'data' => $data);
            render_template($layout);
            return FALSE;
        }
    }

}

?>