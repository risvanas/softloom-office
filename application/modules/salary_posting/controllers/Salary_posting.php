<?php

class Salary_posting extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'template'));
        $this->template->set_template('admin_template');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->model('salaryposting_model');
    }

    function index() {
        $menu_id = 37;
        $this->load->library('../controllers/permition_checker');
        $this->form_validation->set_rules('txt_date', 'Date', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->permition_checker->permition_viewprocess($menu_id);
            $data['staff_list'] = $this->salaryposting_model->staff_details('tbl_account');
            $data['msg'] = "";
            $data['errmsg'] = "";
            $layout = array('page' => 'form_staff', 'data' => $data);
            render_template($layout);
        } else {
            $this->permition_checker->permition_addprocess($menu_id);
            $sess_array = $this->session->userdata('logged_in');
            $year_code = $sess_array['accounting_year'];
            $n = $this->input->post('Num');
            if ($n == 0) {
                $data['staff_list'] = $this->salaryposting_model->staff_details('tbl_account');
                $data['msg'] = "";
                $data['errmsg'] = "";
                $layout = array('page' => 'form_staff', 'data' => $data);
                render_template($layout);
            }

            $temp_voc_num = $this->input->post('temp_voc_num');
            $voucher_date = $this->input->post('txt_date');
            $this->load->library('../controllers/lockdate');
            $this->lockdate->index($voucher_date);
            $check_status = $this->lockdate->check_date($voucher_date);
            $message_display = $this->lockdate->message_val($voucher_date, $check_status);
            if ($check_status == 'true') {
                $data['staff_list'] = $this->salaryposting_model->staff_details('tbl_account');
                $data['msg'] = '';
                $data['errmsg'] = $message_display;
                $layout = array('page' => 'form_staff', 'data' => $data);
                render_template($layout);
                return FALSE;
            }
            if ($temp_voc_num != "") {
                $this->permition_checker->permition_editprocess($menu_id);
                $query2 = $this->db->query("select ACC_YEAR_CODE from tbl_transaction where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='SLA' AND DEL_FLAG=1");
                $val2 = $query2->row_array();
                $acc_year = $val2['ACC_YEAR_CODE'];
                if ($year_code == $acc_year) {

                    $sess_array = $this->session->userdata('logged_in');
                    $modified_by = $sess_array['user_id'];
                    $this->load->library('../controllers/lockdate');
                    $location_details = $this->lockdate->location_details();
                    $modified_on = gmdate("Y-m-d H:i:s");
                    $this->db->query("update tbl_transaction set DEL_FLAG=0,MODIFIED_BY=$modified_by,MODIFIED_ON='$modified_on',LOCATION_DETAILS='$location_details' where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='SLA'");
                    $book_num = $temp_voc_num;
                } else {
                    $data['staff_list'] = $this->salaryposting_model->staff_details('tbl_account');
                    $data['msg'] = '';
                    $data['errmsg'] = "Accounting Year Do not Match";
                    $layout = array('page' => 'form_staff', 'data' => $data);
                    render_template($layout);
                    return FALSE;
                }
            } else {
                $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='SLA' ");
                $row = $query->row_array();
                $book_num = $row['BOOK_NUMBER'];
            }

            for ($i = 1; $i < $n; $i++) {

                //$book_num=$this->input->post('txt_buk_num');
                $voucher_date = $this->input->post('txt_date');
                $voucher_date = strtotime($voucher_date);
                $voucher_date = date("Y-m-d", $voucher_date);
                $staffid = $this->input->post('txt_staffid' . $i);
                $staffname = $this->input->post('txt_staffname' . $i);
                $salary = $this->input->post('txt_salary' . $i);
                $remarks = "Salary - " . $staffname;
                $sess_array = $this->session->userdata('logged_in');
                $create_by = $sess_array['user_id'];
                $this->load->library('../controllers/lockdate');
                $location_details = $this->lockdate->location_details();
                $create_on = gmdate("Y-m-d H:i:s");
                $data = array('FIN_YEAR_ID' => '2',
                    'ACC_ID' => 42,
                    'DATE_OF_TRANSACTION' => $voucher_date,
                    'CREDIT' => $salary,
                    'REMARKS' => $remarks,
                    'BOOK_NUMBER' => $book_num,
                    'BOOK_NAME' => 'SLA',
                    'SUB_ACC' => $staffid,
                    'ACC_YEAR_CODE' => $year_code,
                    'CREATED_BY' => $create_by,
                    'CREATED_ON' => $create_on,
                    'LOCATION_DETAILS' => $location_details);
                $data2 = array('FIN_YEAR_ID' => '2',
                    'ACC_ID' => 99,
                    'DATE_OF_TRANSACTION' => $voucher_date,
                    'DEBIT' => $salary,
                    'REMARKS' => $remarks,
                    'BOOK_NUMBER' => $book_num,
                    'BOOK_NAME' => 'SLA',
                    'ACC_YEAR_CODE' => $year_code,
                    'CREATED_BY' => $create_by,
                    'CREATED_ON' => $create_on,
                    'LOCATION_DETAILS' => $location_details);

                $this->salaryposting_model->insert_data('tbl_transaction', $data);
                $this->salaryposting_model->insert_data('tbl_transaction', $data2);
            }
            $data['staff_list'] = $this->salaryposting_model->staff_details('tbl_account');
            $data['msg'] = 'Salary added successfully';
            $data['errmsg'] = "";
            $layout = array('page' => 'form_staff', 'data' => $data);
            render_template($layout);
        }
    }

    function details_staff_edit() {

        $buk_num = $this->input->post('voc_no');
        $data['vno'] = $this->salaryposting_model->select_info('tbl_transaction', $buk_num);
        //$this->load->view('form_displayData',$data);
        $this->load->view('form_edit_data', $data);
    }

    function del_data() {
        $menu_id = 37;
        $this->load->library('../controllers/permition_checker');
        $this->permition_checker->permition_deleteprocess($menu_id);
        $sess_array = $this->session->userdata('logged_in');
        $year_code = $sess_array['accounting_year'];
        $buk_num = $this->uri->segment(3);
        $query2 = $this->db->query("select ACC_YEAR_CODE,DATE_OF_TRANSACTION from tbl_transaction where BOOK_NUMBER=$buk_num AND BOOK_NAME='SLA' AND DEL_FLAG=1");
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
            //$buk_num=$this->input->post('txt_buk_num');
            $sess_array = $this->session->userdata('logged_in');
            $deleted_by = $sess_array['user_id'];
            $this->load->library('../controllers/lockdate');
            $location_details = $this->lockdate->location_details();
            $deleted_on = gmdate("Y-m-d H:i:s");
            $data = array('DEL_FLAG' => '0',
                'DELETED_BY' => $deleted_by,
                'DELETED_ON' => $deleted_on,
                'LOCATION_DETAILS' => $location_details);
            $this->salaryposting_model->delete_data('tbl_transaction', $data, $buk_num);
            //$data['staff_list']=$this->salaryposting_model->staff_details('tbl_account');
            //$data['msg']='';
            // $layout = array('page' =>'form_staff','data'=>$data);
            //render_template($layout);
            $data['staff_list'] = $this->salaryposting_model->staff_details('tbl_account');
            $data['msg'] = 'Salary Deleted successfully';
            $data['errmsg'] = "";
            $layout = array('page' => 'form_staff', 'data' => $data);
            render_template($layout);
        } else {
            $data['staff_list'] = $this->salaryposting_model->staff_details('tbl_account');
            $data['msg'] = '';
            $data['errmsg'] = $message_display;
            $layout = array('page' => 'form_staff', 'data' => $data);
            render_template($layout);
            return FALSE;
        }
    }

}

?>