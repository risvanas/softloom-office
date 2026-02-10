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
        $autoload['helper'] = array('security');
        $this->load->helper('security');
        $this->form_validation->set_rules('txt_voucher_date', 'voucher date', 'required');
        if ($this->form_validation->run() != TRUE) {
            $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
            $data['msg'] = "";
            $data['errmsg'] = "";
            $layout = array('page' => 'form_voucher', 'title' => 'Payment Voucher', 'data' => $data);
            render_template($layout);
        } else {
            $voucher_date = $this->input->post('txt_voucher_date');
            $this->load->library('../controllers/lockdate');
            $this->lockdate->index($voucher_date);

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
                $this->db->query("update tbl_transaction set DEL_FLAG=0 where BOOK_NUMBER=$temp_voc_num AND BOOK_NAME='PV'");
                $book_num = $temp_voc_num;
            } else {
                $query = $this->db->query("SELECT IFNULL(MAX(BOOK_NUMBER), 100)+1 AS BOOK_NUMBER FROM tbl_transaction WHERE BOOK_NAME='PV' ");
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
                    'SUB_ACC' => $sub_acc_id);

                $data2 = array('FIN_YEAR_ID' => '2',
                    'ACC_ID' => '39',
                    'DATE_OF_TRANSACTION' => $voucher_date,
                    'CREDIT' => $amt,
                    'REMARKS' => $remark,
                    'DESCRIPTION' => $rem,
                    'TRANS_TYPE' => 'cash',
                    'BOOK_NUMBER' => $book_num,
                    'BOOK_NAME' => 'PV',
                    'REF_VOUCHERNO' => $rvno
                );

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
        $buk_num = $this->input->post('voc_no');

        $data['vno'] = $this->voucher_model->select_info('tbl_transaction', $buk_num);
        $this->load->view('form_displayData', $data);
    }

    function del_data() {
        $buk_num = $this->input->post('txt_buk_num');
        $data = array('DEL_FLAG' => '0');

        $this->voucher_model->delete_data1('tbl_transaction', $data, $buk_num);
    }

    function delete_data() {
        //echo "Hai";
        echo $buk_num = $this->uri->segment(3);
        $data = array('DEL_FLAG' => '0');
        $this->voucher_model->delete_data1('tbl_transaction', $data, $buk_num);
        $data['sub_acc_list'] = $this->voucher_model->select_sub_acc('tbl_account');
        $data['msg'] = "Voucher Delete successfully";
        $data['errmsg'] = "";
        $layout = array('page' => 'form_voucher', 'title' => 'Voucher', 'data' => $data);
        render_template($layout);
        return FALSE;
    }

}

?>